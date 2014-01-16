Junar-compatible webservice
==========================

Full API REST to communicate your database with the Junar platform

**Steps**

0.- Put this code on any directory of you server.
If you know how create a subdomain, use "api" or "data" as subdomain.

1.- Configure your connection on the database file
	/junar/application/config/database.php 
	*(as copy of /junar/application/config/database.sample.php)*

2.- Check the main controller to insert some query to the database and start using this API
	/junar/application/controller/api.php

3.- Publish your first webservice in Junar (one for each API function)
You'll need these parameters:

**Endpoint** 
data.yoursite.com/index.php/api/FUNCTION_NAME/PARAMS 

**Webservice type** 
REST/JSON

**Path to headers** 
$.headers

**Path to data** 
$.data

If you do not require security you are ready to publish data on Junar.

Other options
==========
.- If you want to improve your URLa copy the *.htaccess.ifneeded * in *. htaccess * and apply the necessary changes.
.- You can expose a home page by changing the file /junar/application/view/api_home.php 
There is a good idea to place here an index of the data resources and some tutorials.

Technical resources
=================
We use Codeigniter
We include a rest-server library[0] 

**Requirements**
PHP 5.3
Apache 2.2 (not mandatory)
A database

**Compatible engine databases**
Compatible as Codeigniter
MySql (tested)
Oracle (tested)
MS SQL
Postgres
SQLite
ODBC.


--------------------------------------------------------
[0] https://github.com/avdata99/codeigniter-restserver
