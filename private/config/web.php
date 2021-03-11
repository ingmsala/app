<?php

use app\config\Globales;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Gestión Administrativa',
    'basePath' => dirname(__DIR__),
    'language' => 'es',
    'bootstrap' => [
        'log',
        'devicedetect'
    ],
    //'catchAll' => ['site/mantenimiento'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',

    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '9I-_xkrT1Sx2CLZz4E1z6UvOjcDgM_39',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'devicedetect' => [
            'class' => 'alexandernst\devicedetect\DeviceDetect'
        ],
        
        'formatter' => [
        'class' => 'yii\i18n\Formatter',
        'nullDisplay' => '',
        'dateFormat' => 'dd/mm/yyyy',
        'defaultTimeZone' => 'America/Argentina/Buenos_Aires',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'loginUrl' => ['/login'],
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                 'class' => 'Swift_SmtpTransport',
                 'host' => 'smtp.gmail.com',  // ej. smtp.mandrillapp.com o smtp.gmail.com
                 'username' => Globales::MAIL,
                 'password' => Globales::PASS_MAIL,
                 'port' => '587', // El puerto 25 es un puerto común también
                 'encryption' => 'tls', // Es usado también a menudo, revise la configuración del servidor
             ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'cas' => [
            'class' => 'silecs\yii2auth\cas\CasModule',
            
        ],
        'monolog' => [
            'class' => '\Mero\Monolog\MonologComponent',
            'channels' => [
                'main' => [
                    'handler' => [
                        [
                            'type' => 'stream',
                            'path' => '@app/runtime/logs/main_' . date('Y-m-d') . '.log',
                            'level' => 'debug'
                        ]
                    ],
                    'processor' => [],
                ],
                'horarioclase' => [
                    'handler' => [
                        [
                            'type' => 'stream',
                            'path' => '@app/runtime/logs/horarioclase.log',
                            'level' => 'debug',
                        ]
                    ],
                    'processor' => [],
                ],
                'horarioexamen' => [
                    'handler' => [
                        [
                            'type' => 'stream',
                            'path' => '@app/runtime/logs/horarioexamen.log',
                            'level' => 'debug',
                        ]
                    ],
                    'processor' => [],
                ],
                'horariocoloquio' => [
                    'handler' => [
                        [
                            'type' => 'stream',
                            'path' => '@app/runtime/logs/horariocoloquio.log',
                            'level' => 'debug',
                        ]
                    ],
                    'processor' => [],
                ],
            ],
        ],
        'db' => $db,
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'jsOptions' => [ 'position' => \yii\web\View::POS_HEAD ],
                ],
            ],
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        
    ],
    'modules' => [
         'gridview' => ['class' => 'kartik\grid\Module'],
         'markdown' => [
            'class' => 'kartik\markdown\Module',
         ],
         'curriculares' => [
            'class' => 'app\modules\curriculares\Curriculares',
        ],
         'optativas' => [
                'class' => 'app\modules\optativas\Optativas',
         ],

         
        'horariogenerico' => [
                'class' => 'app\modules\horariogenerico\Horariogenerico',
        ],
        

         'edh' => [
                'class' => 'app\modules\edh\Edh',
         ],

         'mones' => [
                'class' => 'app\modules\mones\Mones',
         ],

         'aniversary' => [
                'class' => 'app\modules\aniversary\Aniversary',
         ],

         'solicitudprevios' => [
                'class' => 'app\modules\solicitudprevios\Solicitudprevios',
         ],

         'ticket' => [
                'class' => 'app\modules\ticket\Ticket',
         ],

         'api' => [
                'class' => 'app\modules\api\test\Test',
                                
         ],

         'sociocomunitarios' => [
            'class' => 'app\modules\sociocomunitarios\Sociocomunitarios',
                            
        ],

        'personal' => [
            'class' => 'app\modules\personal\Personal',
        ],

        'horarioespecial' => [
            'class' => 'app\modules\horarioespecial\Horarioespecial',
        ],
        'libroclase' => [
            'class' => 'app\modules\libroclase\Libroclase',
        ],

        'cas' => [
            'class' => 'silecs\yii2auth\cas\CasModule',
            'config' => [
                'host' => 'usuarios.unc.edu.ar',
                'port' => '443',
                'path' => 'cas',
                // optional parameters
                'certfile' => '', // empty, or path to a SSL cert, or false to ignore certs
                'debug' => true, // will add many logs into X/runtime/logs/cas.log
            ],
        ],

         'db-manager' => [
                'class' => 'bs\dbManager\Module',
                // path to directory for the dumps
                'path' => '@app/backup',
                
                // list of registerd db-components
                'dbList' => ['db'],
                'as access' => [
                    'class' => 'yii\filters\AccessControl',
                    'rules' => [
                        [
                               
                            'allow' => true,
                            'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [1]);
                                }catch(\Exception $exception){
                                    return false;
                                }
                            }

                        ],

                        
                    ],
                ],
        ],
    ], 
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
