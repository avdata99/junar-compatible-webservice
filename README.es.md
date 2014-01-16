Junar-compatible webservice
==========================

API REST completa para enviar los datos de tu base hasta Junar de modo simple y seguro

**Instrucciones**

0.- Coloque el codigo en cualquier directorio de sitio web actual.
Si conoce como hacerlo crear el subdominio "api" o "data", es una buena idea tambien

1.- Configure su conexion a base de datos en el archivo
	/junar/application/config/database.php 
	*(como copia de /junar/application/config/database.sample.php)*

2.- Revise el controlador principal para insertar alguna consulta a su base de datos y comenzar a usar el API
	/junar/application/controller/api.php

3.- Publique su primer webservice en Junar (uno por cada funcion del API)
Necesitará los parámetros:

**Endpoint** 
data.tuweb.com/index.php/api/NOMBRE_FUNCION/PARAMS

**Webservice type** 
REST/JSON

**Path to headers** 
$.headers

**Path to data** 
$.data

Si no requiere mecanismos de seguridad mas complejos el proceso esta listo y junar puede comenzar a consumir sus recuersos.


Opcionales
==========
.- Si desea mejorar us URL transforme el archivo *.htaccess.ifneeded* en *.htaccess* y aplique los cambios que considere necesarios.
.- Puede exponer al público una página de presentacion predeterminada en /junar/application/view/api_home.php. 
Si ademas de junar expondrá esta api al público es una buena idea colocar aqui un indice de los datos que libera y algun instructivo de uso.


Aspectos técnicos
=================
Basado en Codeigniter
Incluye librería rest-server[0] 

**Requisitos**
PHP 5.3
Apache 2.2 (se puede adaptar a otros)
Una base de datos

**Bases de datos**
Compatible con los mismos motores de bases de datos que incluye Codeigniter
MySql (testeado)
Oracle (testeado)
MS SQL
Postgres
SQLite
ODBC.


--------------------------------------------------------
[0] https://github.com/avdata99/codeigniter-restserver
