# Estructura de carpetas

[![N|Solid](https://upload.wikimedia.org/wikipedia/commons/2/2d/Logo_Navicu_Wikipedia-09.png)](https://navicu.com/)

Se pretende presentar una documentacion sobre la estructura de carpetas y distribucion de los componentes de la plataforma segun el contenido de estas.

 

# BACKEND

  - bin
  - config
  - public
  - src
  - templates
  - tests
  - traslations
  - vendor
  -  .env
  -  .env.dist
  -  .gitignore
  -  composer.json
  -  phpunit.xml.dist
  -  symfony.lock

A continuacion se describen las carppetas y archivos:
-

  - bin
> 
> 

- config
> 
> 

- public
>  Contiene una carpeta IMAGES
>  Carpeta images: esta segmentada segun la utilidad del contenido multimedia (airlines,emails, icons, marca); Cada segmento esta orientado al siguiente enfoque: en primer lugar tenemos airline donde se almacenaran los logos de las areolines, en segundo lugar tendremos emails que incluira los iconos e imagenes usadas para cada correo esta carpeta crece su directorio segun cada email (creacion de un subdirectorio por cada tipo e email), de tercer lugar tenemos icons esta almacenara toda la iconografia del sistema en general solo aquello que se considere icono (imagenes pequeñas de simbologias), por ultimo tenemos la carpeta marca, en la calcual en su directorio pricipal tendremos el icono de navicu en todas sus presentaciones, internamente esta carpeta puede incrementarse los iconos segun su funcion por ejemplo email (contrandra los logos de la empresa que se usan para los email), tambien se puede crear carpeta para alguna promocion o personalizacion .

- src
> 
> 

- templates
>  Contiene dos segmentos formado por las carpetas siguientes:
>  client_profile 
>  Email: en esta carpeta se encuentran los archivos backend que contienen los correos electronicos tando a nivel de plantilla base como el correo integrado con la data real. Tenemos una segmentacion por tipos de correos:
>  1 - Carnival
>  2 - Flight: esta carpeta tiene los emails del subsistema de boleteria conformada  en su directorio raiz por los archivos que tienen el correo final enviado ademas tiene un segmento llamado template_mjml que se estructura de ls siguiente forma:
>   a . basic: contiene los archivos para editar y compilar con la estructura base del correo de la empresa, para ser utilizado en la construccion de un nuevo email.
>   b . emails: contiene una segmentacion de carpetas segun la cantidad de correo creados, el nombre de las carpetas seran el mismo nombre del archivo de correo electonico en cuestion, cada carpeta tiene la plantilla de el correo y sus archivos ejecutables.
>  3 - Security 

- test
> 
> 

- traslations
> 
> 

- vendor
> 
> 

- .env
> 
> 

- .env.dist
> 
> 

- .gitignore
> 
> 

- composer.json
> 
> 

- phpunit.xml.dist
> 
> 

- symfony.lock
> 
> 
