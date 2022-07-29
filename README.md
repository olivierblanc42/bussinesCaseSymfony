# laNimeAlerieSymfony

This is a business case use for the  web and mobile web developer formation by humanBooster.   
It is a fake commercial website La Nîmes'alerie use for the final exam if needed.
It is built with [Symfony](https://symfony.com/) and [API Platform](https://api-platform.com/).

## Table of contents

* [Getting Started](#start)
    * [Prerequisites](#prerequisites)
    * [Installation](#installation)
        * [Setting-up the database](#setupdb)
        * [Setting-up the JWT API](#setupJwt)
 


# Getting Started <a name="start"></a>

## Prerequisites <a name="prerequisites"></a>

:link:[FakerPHP/Faker](https://github.com/FakerPHP/Faker)
:link:[Nelmio/Alice](https://github.com/nelmio/alice)
:link:[wamp](https://www.wampserver.com/)
:link:[Symfony](https://symfony.com/)
:link:[ApiPlatform](https://github.com/api-platform)
                

  


## Installation <a name="installation"></a>
Start cloning the repository in a directory :
This command allows you to install the remote project locally on your machine
```
git clone https://github.com/olivierblanc42/bussinesCaseSymfony.git
```


Once installed, open a terminal and do the following command in the project directory to install depedencies of the project :
This command allows to install the dependencies listed in the composer.json
```
symfony composer install
```

### Setting-up the database <a name="setupdb"></a>

```
1.create a .env.local file at the root of your project 
2.store inside .env.local : ''DATABASE_URL="//mysql:root@127.0.0.1:3306/bddname"
```
Or choose another DATABASE_URL according to your DBMS and configuration in the .env file.

Then, you have to create the database by using this command in a terminal :
```
symfony console doctrine:database:create
```
This will create the database but tables. To create tables, do this command in a terminal and answer **yes** at the question. :
```
symfony console doctrine:migrations:migrate
```

To add datas in the database, write this command in a terminal and answer **y** at the question. :
```
symfony console hautelook:fixtures:load --purge-with-truncate
```

### Setting-up the JWT API <a name="setupJwt"></a>

```
1. symfony composer require jwt-auth
2. check in config lexik_jwt and .env
3. create a jwt folder in config
4. put in this folder two files private.pem and public.pem
5. get in .env JWT_PASSSPHRASE and copy it
6. copy in .env.local the JWT_PASSPHRASE and modify its content : 123456
```
# API
## Installation of the api-platform dependency
    symfony composer require api
---
## Adding operations on entities  

- Add an attribute #[ApiResource] above the class :
    ```php
    use ApiPlatform\Core\Annotation\ApiResource
    ```

- To modify the possible operations on the API, you must add options to #[ApiResource]  

- By removing or adding methods we can choose which ones will be usable on the entity:
    ```php
    #[ApiResource(
        collectionOperations: ['get'],
        itemOperations: ['get'],
    )]
    ```
---
## Validation methods

- First you have to install the dependency with this command line
    ```php
    compose require symfony/validator doctrine/annotations
    ```
- [By clicking here you can see the Symfony validation Doc][1]

---
## Installing JWT token
- Run this command line:
    ```
    symfony composer require jwt-auth
    ```

- Create the public/private keys
    - For dev environment:
        - Create config/jwt.yaml folder  
        - Add the two keys sent by Benjamin then add the mdp 123456 in .env.local   
        *The .key files are to be transformed into .pem* 

    <!-- - For the prod:  
        find out how to generate the keys -->


- Paste into config/package/security.yaml :
    ```yaml
    main:
        stateless: true
        provider: app_user_provider
        json_login:
            check_path: /authentication_token
            username_path: email
            password_path: password
            success_handler: lexik_jwt_authentication.handler.authentication_success
            failure_handler: lexik_jwt_authentication.handler.authentication_failure
        jwt: ~
    ```

- Replace the access_control in the same file:
    ```yaml
    access_control:
        - { path: ^/api/docs, roles: PUBLIC_ACCESS } # Allows accessing the Swagger UI
        - { path: ^/authentication_token, roles: PUBLIC_ACCESS }
        - { path: ^/api, roles: IS_AUTHENTICATED_FULLY }
    ```

- Add to config/route.yaml :
    ```yaml
    authentication_token:
        path: /authentication_token
        methods: ['POST']
    ```

- Modify the config/package/api_platform.yaml file and merge the swaggers:
    ```yaml
    swagger:
        versions: [3]
        api_keys:
            JWT:
                name: Authorization
                type: header
    ```

*To authenticate, you will now have to go to url/authentication_token*

- To create a Post operation on authentication token in the doc :
    - Create the file src/OpenApi/JwtDecorator.php and put this code inside :
    ```php
    <?php
    declare(strict_types=1);

    namespace App\OpenApi;

    use ApiPlatform\Core\OpenApi\FactoryOpenApiFactoryInterface;
    use ApiPlatformCoreOpenApi;
    use ApiPlatformCoreOpenApiModel;

    final class JwtDecorator implements OpenApiFactoryInterface
    {
        public function __construct(
            private OpenApiFactoryInterface $decorated
        ) {}

        public function __invoke(array $context = []): OpenApi
        {
            $openApi = ($this->decorated)($context);
            $schemas = $openApii->getComponents()->getSchemas();

            $schemas['JwtToken'] = new \ArrayObject([
                type' => 'object',
                properties' => [
                    token' => [
                        'type' => 'string',
                        readOnly' => true,
                    ],
                ],
            ]);
            $schemas['Credentials'] = new \ArrayObject([
                type' => 'object',
                properties' => [
                    email' => [
                        'type' => 'string',
                        'example' => 'admin@test.com',
                    ],
                    'password' => [
                        'type' => 'string',
                        'example' => '1234',
                    ],
                ],
            ]);

            $schemas = $openApi->getComponents()->getSecuritySchemes() ?? [];
            $schemas['JWT'] = new \ArrayObject([
                type' => 'http',
                scheme' => 'bearer',
                bearerFormat' => 'JWT',
            ]);

            $pathItem = new Model\PathItem(
                ref: 'JWT Token',
                post: new Model\Operation(
                    operationId: 'postCredentialsItem',
                    tags: ['Login'],
                    responses: [
                        '200' => [
                            'description' => 'Get JWT token',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/JwtToken',  ],
                                ],
                            ],
                        ],
                    ],
                    summary : 'Get JWT token to login.',
                    requestBody : new Model\RequestBody(
                        description : 'Générer un nouveau jeton JWT',
                        content : new \ArrayObject([
                            application/json' => [
                                schema' => [
                                    $ref' => '#/components/schemas/Credentials',
                                ],
                            ],
                        ]),
                    ),
                    sécurité : [],
                ),
            ) ;
            $openApi->getPaths()->addPath('/authentication_token', $pathItem) ;

            return $openApi ;
        }
    }
    ```

- Add to file config/services.yaml : 
    ```yaml
        App\OpenApi\JwtDecorator :
            décore : api_platform.openapi.factory
            arguments : ['@.inner']
    ```

    - creation of roles
        - Add to file config/package/security.yaml avant firewall :
        ```yaml 
           role_hierarchy :
            ROLE_ADMIN : ROLE_USER
            ROLE_SUPER_ADMIN : ROLE_USER
            ROLE_STATS : ROLE_USER
        ```





