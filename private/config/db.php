<?php
if (YII_ENV_DEV) {
	return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=test2',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',

	];
}
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=databases-mariadb-4.psi.unc.edu.ar;dbname=admin_monserrat',
    'username' => 'us_admin_monserrat',
    'password' => 'Bei5Mu1e',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
