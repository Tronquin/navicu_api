<?php

namespace App\Navicu\Handler;

use App\Navicu\Exception\NavicuException;
use App\Navicu\Service\NavicuValidator;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Maneja toda la logica de negocio de la aplicacion. La intención
 * es crear un "Handler" por cada flujo y que extiendan de esta
 * clase
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
abstract class BaseHandler
{
    use ContainerAwareTrait;

    /** Codigos de respuesta general */
    const CODE_UNDEFINED = 0;
    const CODE_SUCCESS = 200;
    const CODE_BAD_REQUEST = 400;
    const CODE_EXCEPTION = 500;
    const CODE_PAYMENT_ = 20;

    /* codigos respuesta boleteria*/
    const CODE_NOT_AVAILABILITY = 11;
    const CODE_REPEATED_BOOK = 12;
    const CODE_REPEATED_TICKET = 13;
    const CODE_ERROR_ISSUE = 20;


    /* codigos respuesta holeteria*/
    const EXPIRED_RESERVATION = 5;

    /**
     * Codigo de respuesta del flujo
     *
     * @var int
     */
    private $code;

    /**
     * Codigo de respuesta http
     *
     * @var int
     */
    private $codeHttp;

    /**
     * Parametros del flujo
     *
     * @var array
     */
    private $params;

    /**
     * Errores durante el flujo
     *
     * @var array
     */
    private $errors;

    /**
     * Data de respuesta
     *
     * @var array
     */
    private $data;

    /**
     * Reglas de validacion definidas para el Handler
     *
     * @var array
     */
    private $rules;

    /**
     * Indica si el Handler ya fue procesado
     *
     * @var bool
     */
    private $processed;

    /**
     * Init Handler
     *
     * @param Request $request
     */
    final public function __construct(Request $request = null)
    {
        $this->code = self::CODE_UNDEFINED;
        $this->errors = [];
        $this->data = [];
        $this->rules = $this->validationRules();
        $this->processed = false;
        $this->params = [];

        global $kernel;

        $this->setContainer($kernel->getContainer());

        if ($request) {
            $this->setParamsFromRequest($request);
        }
    }

    /**
     * Aqui va la logica
     *
     * @return array
     * @throws NavicuException
     */
    protected abstract function handler() : array;

    /**
     * Todas las reglas de validacion para los parametros que recibe
     * el Handler
     *
     * Las reglas de validacion estan definidas en:
     * @see \App\Navicu\Service\NavicuValidator
     *
     * @return array
     */
    protected abstract function validationRules() : array;

    /**
     * Ejecuta el Handler
     */
    final public function processHandler() : void
    {
        try {
            $this->processed = true;

            $validator = new NavicuValidator();
            $validator->validate($this->params, $this->rules);

            if ($validator->hasError()) {

                $this->code = self::CODE_BAD_REQUEST;
                $this->codeHttp = self::CODE_BAD_REQUEST;
                $this->errors = $validator->getErrors();

            } else {

                $this->code = self::CODE_SUCCESS;
                $this->codeHttp = self::CODE_SUCCESS;
                $this->data = $this->handler();
            }

        } catch (NavicuException $ex) {

            $this->code = $ex->getCode();
            $this->codeHttp = self::CODE_EXCEPTION;
            $this->addError($ex->getMessage());

        } catch (\Exception $ex) {

            $this->code = self::CODE_EXCEPTION;
            $this->codeHttp = self::CODE_EXCEPTION;
            $this->addError($ex->getMessage());
        }
    }

    /**
     * Set params del Handler
     *
     * @param $parameters;
     * @return BaseHandler
     */
    public function setParams(array $parameters) : BaseHandler
    {
        $this->params = $parameters;
        return $this;
    }

    /**
     * Get Params del Handler
     *
     * @return array
     */
    public function getParams() : array
    {
        return $this->params;
    }

    /**
     * Set un parametro
     *
     * @param string $key
     * @param mixed $value
     * @return BaseHandler
     */
    public function setParam($key, $value) : BaseHandler
    {
        $this->params[$key] = $value;
        return $this;
    }

    /**
     * Agrega un error en la ejecucion
     *
     * @param string $error
     * @return BaseHandler
     */
    public function addError($error) : BaseHandler
    {
        $this->errors[] = $error;
        return $this;
    }

    /**
     * Indica si el proceso fue exitoso
     *
     * @return bool
     */
    public function isSuccess() : bool
    {
        return $this->code === self::CODE_SUCCESS && $this->codeHttp === self::CODE_SUCCESS;
    }

    /**
     * Obtiene la data del handler procesado
     *
     * @return array
     * @throws \Exception
     */
    public function getData() : array
    {
        if (! $this->processed) {
            throw new \Exception('Handler has not been processed, please call "processHandler" before "getData"');
        }

        return [
            'code' => $this->code,
            'data' => $this->data
        ];
    }

    /**
     * Obtiene la respuesta para los errores
     *
     * @return array
     * @throws \Exception
     */
    public function getErrors() : array
    {
        if (! $this->processed) {
            throw new \Exception('Handler has not been processed, please call "processHandler" before "getErrors"');
        }

        return [
            'code' => $this->code,
            'errors' => $this->errors
        ];
    }

    /**
     * Obtiene un objeto JsonResponse con la respuesta del Handler
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function getJsonResponseData() : JsonResponse
    {
        if (! $this->processed) {
            throw new \Exception('Handler has not been processed, please call "processHandler" before "getJsonResponseData"');
        }

        if ($this->isSuccess()) {
            return new JsonResponse($this->getData());
        }

        return new JsonResponse($this->getErrors(), $this->codeHttp);
    }

    /**
     * Codigo de respuesta personalizado
     *
     * @return int
     */
    public function getCode() : int
    {
        return $this->code;
    }

    /**
     * Codigo de respuesta http
     *
     * @return int
     */
    public function getCodeHttp() : int
    {
        return $this->codeHttp;
    }

    /**
     * Obtiene todos los parametros del request al params del handler
     *
     * @param Request $request
     * @return BaseHandler
     */
    private function setParamsFromRequest(Request $request) : BaseHandler
    {
        $this->params = $request->attributes->get('_route_params');

        foreach ($request->query->all() as $key => $value) {
            $this->setParam($key, $value);
        }

        foreach ($request->request->all() as $key => $value) {
            $this->setParam($key, $value);
        }

        if ($request->headers->get('content-type') === 'application/json') {

            $json = json_decode($request->getContent(), true);

            if ($json) {
                $this->params = array_merge($this->params, $json);
            }
        }

        return $this;
    }
}