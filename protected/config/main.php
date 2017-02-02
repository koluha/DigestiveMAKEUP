<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Продажа алкогольной продукций',
    // preloading 'log' component
    'preload' => array('log', 'efontawesome'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.models.core.*',
        'application.models.forms.*',
        'application.components.*',
        'application.widgets.*',
    ),
    'modules' => array(
        'admin' => array(
            'defaultController' => 'default/index',
            'layoutPath' => 'protected/modules/admin/views/layouts',
            'layout' => 'column2'
        ),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '1234',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        'efontawesome' => array(
            'class' => 'ext.EFontAwesome.components.EFontAwesome',
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path', //
            'showScriptName' => false,
            'rules' => array(
                '<module:(admin)>' => '<module>/default/index',
                '<url:\w+>' => 'catalog',
                'product/<url:\w+>' => 'product',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                
                '<module:\w+>/<controller:\w+>/<action:[\w-]+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>' => '<module>/<controller>',
                
            ),
        ),
        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),
        'mailer' => array(
            'class' => 'application.extensions.mailer.EMailer',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => YII_DEBUG ? null : 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    'params' => array(
        // this is used in contact page
        'adminEmailOrder' => array('sitengines@mail.ru', 'kolyan2288@mail.ru'),
        'pagination_limit' => 12,
        'meta_title' => 'Алкогольная продукция интернет-магазина digestive',
        'meta_keywords' => 'Алкогольная продукция интернет-магазина digestive',
        'meta_description' => 'Интернет-магазин алкогольной продукций',
    ),
);
