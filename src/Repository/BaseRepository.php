<?php

namespace App\Repository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @author Mary sanchezs <msmarycarmen@gmail.com>
 * @version 28/05/2016
 *
 * updateby Javier Vásquez
 */

class BaseRepository extends ServiceEntityRepository
{
    private $_select;

    private $_from;

    private $_where;

    private $_itemsPerPage;

    private $_currentPage;

    private $_totalItems;

    private $_orderBy;

    private $_orderType;

    private $_tsRank;


    public function __construct(RegistryInterface $registry, $class = null) 
    {
        parent::__construct($registry, $class);
    }

   /* Devuelve un array con resultados de una cosulta nativa mas su información de paginacion
    *
    * @return Array
    */
    protected function getResults($sql)
    {
        return $this->getEntityManager()
            ->getConnection()
            ->query($sql)
            ->fetchAll()
        ;
    }


   /**
     * Funcion encargada de agregar el sufijo POF para armar un string
     *
     * @param $arrayOfWords array, arreglo de palabras a concatenar con el sufijo
     * @param $suffix string, sufijo que se le agrega a cada token (Ej: ":*")
     * @param string $separator, separador del array (Ej: & |)
     * @return string
     * @author Isabel Nieto <isabelcnd@gmail.com>
     * @version 17/01/2017
     */
    private function addingSuffix($arrayOfWords, $suffix = null, $separator = null)
    {
        if (is_null($arrayOfWords) || (empty($arrayOfWords)))
            return null;

        // Transformamos el string separado por espacios en un array de palabras
        $text = explode(" ", $arrayOfWords);

        // Se unen los elementos mediante el sufijo previsto
        if (is_null($suffix))
            $response = implode(" ".$separator, $text);
        else
            $response = implode($suffix.$separator, $text);

        $response = $response . $suffix;
        return $response;
    }

    /**
     * Funcion encargada de construir el TsQuery necesario para utlizar los vectores
     *
     * @param $words string, conjunto de palabras a buscar
     * @param $searchVector string, nombre del vector el cual contiene las claves por las que buscar
     * @version 18/01/2017
     * @author Isabel Nieto <isabelcnd@gmail.com>
     * @return null|string
     */
    protected function getTsQuery(&$words, $searchVector)
    {
        // Sufijo utilizado para la busqueda por ts_vector
        $suffix = ":*";
        $separator = "&";

        $words = $this->normalizedWordToTsQuery($words);
        $words = $this->addingSuffix($words, $suffix, $separator);

        return $words ? "$searchVector @@ to_tsquery('spanish','$words')" : null;
    }

    /**
     * Funcion encargada de normalizar los arreglos que son utilizados para la busqueda
     * por el vector TsQuery
     *
     * @param $words
     * @return array|string
     * @author Isabel Nieto <isabelcnd@gmail.com>
     * @version 10-02-2017
     */
    private function normalizedWordToTsQuery($words)
    {
        $arrayOfNewWords = [];

        // Si es una busqueda sencilla le quitamos de igual forma los caracteres especiales
        if (strcmp(gettype($words),"string") == 0)
            return preg_replace('([^A-Za-z0-9[:space:]])', "", $words);

        if (is_null($words))
            return null;

        // Si la combinacion de busqueda fue de palabra y fecha simple se concatenan
        // los arreglos internos una vez normalizados
        foreach ($words as $word) {
            // Limpiar el string de simbolos.
            $aux = preg_replace('([^A-Za-z0-9[:space:]])', "", $word);

            // Concatenando el sub-arreglo de palabras
            $aux = implode(" ",$aux);
            array_push($arrayOfNewWords, $aux);
        }

        // Concatenando el arreglo de palabras resultantes
        $arrayOfNewWords = implode(" ", $arrayOfNewWords);

        return $arrayOfNewWords;
    }


    /**
     * Funcion encargada de separar el string ingresado en lo que va a la clausula "where" y al "tsQuery"
     *
     * @param $word array, cadena de palabras a separar y normalizar (Ej: "marÍa check_in:2014-12-14")
     *
     * @param null $arrayOfMatch, arreglo de palabras que coincidiran con los nombre de tipo date en la BD
     * @return null|string where => [check_in:2014-01-01:2014-03-01], tsQuery => [ {maria}, {sunsol}, {2016-02} ]
     * @version 17/01/2017
     * @author Isabel Nieto <isabelcnd@gmail.com>
     */
    public function separateByType($word, $arrayOfMatch = null)
    {
        if (is_null($word) || (empty($word)))
            return ["tsQuery" => null, "where" => null];

        $toWhereClause = [];
        $toTsQueryClause = [];
        $lengthMatch = count($arrayOfMatch);

        $utf8 = array(
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'i',
            '/[éèêë]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'c',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/–/'           =>   '-',
            '/[’‘‹›‚]/u'    =>   ' ',
            '/[“”«»„]/u'    =>   ' ',
            '/ /'           =>   ' ',
        );

        // Sustituir el array sin acentos
        $lowerCaseWord = strtolower($word);
        $wordsReplaced = preg_replace(array_keys($utf8), array_values($utf8), $lowerCaseWord);
        // Pasando string a array.
        $words = explode(" ", $wordsReplaced);

        // Eliminando palabras con longitud menor a 2
        $arrayOfWords =  array_filter(
            array_map(function ($w) {
                if (strlen($w) > 2)
                    return $w;
                else
                    return null;
            },
                $words)
        );

        // Patrones necesarios para separar las busquedas ingresadas
        $pattern_text_date = "\d{4}-\d{2}$";
        $pattern_text = "[a-z\d{0,4}]$";
        $pattern_where_date = "\d{4}-\d{2}-\d{2}:\d{4}-\d{2}-\d{2}$";

        // Solo texto
        $foundOnlyText = preg_grep("/$pattern_text/", $arrayOfWords);
        if (!empty( $foundOnlyText)) {
            array_push($toTsQueryClause, $foundOnlyText);
        }

        // Solo las fechas
        $foundOnlyDate = preg_grep("/$pattern_text_date/", $arrayOfWords);
        if (!empty( $foundOnlyDate)) {
            array_push($toTsQueryClause, $foundOnlyDate);
        }

        // Busquedas por rango de fecha
        for ($ii = 0; $ii < $lengthMatch; $ii++) {
            $foundWhereDate = preg_grep("/$arrayOfMatch[$ii]:$pattern_where_date/", $arrayOfWords);
            if (!empty( $foundWhereDate) )
                array_push($toWhereClause, $foundWhereDate);
        }
        return ["tsQuery" => $toTsQueryClause, "where" => $toWhereClause];
    }

}
