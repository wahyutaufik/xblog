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
    'bono.prettifyURL' => true,
    'bono.providers' => array(
        '\\Bono\\Provider\\LanguageProvider',
        '\\Norm\\Provider\\NormProvider',
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
            '/entry' => NULL
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
        'mapping' => array(
            'User' => array(
                'schema' => array(
                    'username' => String::getInstance('username')->filter('trim|required|unique:User,username'),
                    'password' => Password::getInstance('password')->filter('trim|confirmed|salt')
                ),
            ),
        ),
    ),
    'auth' => array(
        'allow' => array(
            '/login' => NULL,
            '/logout' => NULL,
            '/auth' => NULL,
        ),
    ),
);