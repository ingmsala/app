<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
//require_once('MyGlobals.php');
require __DIR__ . '/../../private/config/globales.php';

require __DIR__ . '/../../private/vendor/autoload.php';
require __DIR__ . '/../../private/vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../../private/config/web.php';

(new yii\web\Application($config))->run();
