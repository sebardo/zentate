
Zentate API REST
=============

About
-----

This repository contains all necessary code in order to run the Zentate Api REST as part of a tecnical challenge


DER (diagram entity relation)
![DER](https://i.ibb.co/sFpDSTt/der.png)

Development
===========

The project is built with a several libraries as follow:

- composer create-project symfony/skeleton:"^4.4" zentate
- composer require symfony/orm-pack (database conections)
- composer require annotations (route annotations)
- composer require symfony/maker-bundle --dev (entty creator)
- composer require symfony/twig-bundle (templates)
- composer require symfony/asset 
- composer require nelmio/api-doc-bundle (api documentation)
- composer require trikoder/oauth2-bundle nyholm/psr7 (oauth2 authentication/authorization)
- composer require --dev symfony/phpunit-bridge (testing)
- composer require --dev symfony/browser-kit symfony/css-selector 
- composer require symfony/validator

Running the project 
---------------------------------------

This project requires `postgres` database with `postgres` user with `postgres` password to running in the system. If you want other database engine just modify .env file

Clone the repository and access to folder created, run composer, create database, schema and start server 
```
git clone https://github.com/sebardo/zentate.git
cd zentate
composer install
./bin/console doctrine:database:create
./bin/console doctrine:schema:create
symfony server:start
```

Generating Crypto Keys
----------------------

In order to enable the OAuth authentication flow a public/private keypair
must be generated. Under root directory `/`, run:

```bash
openssl genrsa -out private.key 2048
openssl rsa -in private.key -pubout -out public.key
```

Now can create OAuth client 
```
./bin/console trikoder:oauth2:create-client
```
Add CLIENT_ID and CLIENT_SECRET returned by command above on `phpunit.xml.dist` file

![PHPUNIT](https://i.ibb.co/544CBy6/phpunit.png)

Enjoy it!
----------------------
Now you can visit API REST documentation page and testing category and product endpoints at
https://127.0.0.1:8000/api/doc


Testing
----------------------
Can run testing to check all work well

```
./bin/phpunit
```


Author
------

Dario Sebastian Sasturain 4/2021


Steps
------
1. Create schema
2. Add seats to schema (create group and add multiple seats)
3. Set category to seats (can you set to group or a single seat)
4. Create evento with an schema
5. Interact with seats selection
