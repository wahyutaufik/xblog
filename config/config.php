<?php

use \Norm\Schema\String;
use \Norm\Schema\Password;
use \Norm\Schema\Integer;
use \Norm\Schema\Boolean;
use \Norm\Schema\Text;
use \Norm\Schema\Reference;

return array(
    'app.salt' => '19ca502ac4f23aec501c079fd02279931e414817f20ae3f68853e720122036cc',
    'appId' => '5ca5538009abb60291251ed99ec575e6658fb8c9',
    'secret' => 'fc683cd9ed1990ca2ea10b84e5e6fba048c24929',
    'bono.prettifyURL' => true,
    'bono.providers' => array(
        '\\Bono\\Provider\\LanguageProvider',
        '\\Norm\\Provider\\NormProvider',
        '\\App\\Provider\\BlogProvider',
    ),
    'bono.middlewares' => array(
        '\\Bono\\Middleware\\ControllerMiddleware',
        '\\Bono\\Middleware\\ContentNegotiatorMiddleware',
        '\\App\\Middleware\\AuthMiddleware',
        '\\Bono\\Middleware\\SessionMiddleware',
    ),
    'bono.controllers' => array(
        'default' => '\\Norm\\Controller\\NormController',
        'mapping' => array(
        ),
    ),
    'bono.contentNegotiator' => array(
        'extensions' => array(
            'json' => 'application/json',
        ),
        'views' => array(
            'application/json' => '\\Bono\\View\\JsonView',
        ),
    ),
    'norm.databases' => array(
        'mongo' => array(
            'driver' => '\\Norm\\Connection\\MongoConnection',
            'database' => 'xblog',
        ),
    ),
    'norm.collections' => array(
        'default' => array(
            'observers' => array(
                '\\Norm\\Observer\\Ownership',
                '\\Norm\\Observer\\Timestampable',
            ),
        ),
        'mapping' => array(
            'User' => array(
                'schema' => array(
                    'username' => String::getInstance('username')->filter('trim|required|unique:User,username'),
                ),
            ),
            'Entry' => array(
                'model' => '\\App\\Model\\Entry',
                'schema' => array(
                    'title' => String::getInstance('title'),
                    'content' => String::getInstance('content'),
                    'tags' => Reference::getInstance('tags')->to('Tags', 'description'),
                )
            ),
            'Tags' => array(
                'schema' => array(
                    'description' => String::getInstance('description'),
                )
            )
        ),
    ),
    'auth' => array(
        'allow' => array(
            '/' => NULL,
            '/entry/*' => NULL,
            '/login' => NULL,
            '/logout' => NULL,
            '/auth' => NULL,
        ),
        'restricted' => array(
            '/entry/*/*' => NULL,
        ),
        'urlServiceProvider' => 'http://localhost/acc/',
    ),
    'component.tree' => array(
        'mapping' => array(),
    ),
);
