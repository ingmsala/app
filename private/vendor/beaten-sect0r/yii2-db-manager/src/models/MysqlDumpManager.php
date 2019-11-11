<?php

namespace bs\dbManager\models;

use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

/**
 * Class MysqlDumpManager.
 */
class MysqlDumpManager extends BaseDumpManager
{
    /**
     * @param $path
     * @param array $dbInfo
     * @param array $dumpOptions
     * @return mixed
     */
    public function makeDumpCommand($path, array $dbInfo, array $dumpOptions)
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        // default port
        if (empty($dbInfo['port'])) {
            $dbInfo['port'] = '3306';
        }
        if (YII_ENV_DEV) {
            $arguments = [
                        'C:/wamp64/bin/mysql/mysql5.7.26/bin/mysqldump',
                        '--host=' . $dbInfo['host'],
                        '--port=' . $dbInfo['port'],
                        '--user=' . $dbInfo['username'],
                        '--password=' . $dbInfo['password'],
                    ];
        }else{
            $arguments = [
                        '/usr/bin/mysqldump',
                        '--host=' . $dbInfo['host'],
                        '--port=' . $dbInfo['port'],
                        '--user=' . $dbInfo['username'],
                        '--password=' . $dbInfo['password'],
                    ];
        }
        
        if ($dumpOptions['schemaOnly']) {
            $arguments[] = '--no-data';
        }
        if ($dumpOptions['preset']) {
            $arguments[] = trim($dumpOptions['presetData']);
        }
        $arguments[] = $dbInfo['dbName'];
        if ($dumpOptions['isArchive']) {
            $arguments[] = '|';
            $arguments[] = 'gzip';
        }
        $arguments[] = '>';
        $arguments[] = $path;

        return implode(' ', $arguments);
    }

    /**
     * @param $path
     * @param array $dbInfo
     * @param array $restoreOptions
     * @return mixed
     */
    public function makeRestoreCommand($path, array $dbInfo, array $restoreOptions)
    {
        $arguments = [];
        if (StringHelper::endsWith($path, '.gz', false)) {
            $arguments[] = 'gunzip -c';
            $arguments[] = $path;
            $arguments[] = '|';
        }
        // default port
        if (empty($dbInfo['port'])) {
            $dbInfo['port'] = '3306';
        }
        if (YII_ENV_DEV) {
            $arguments = ArrayHelper::merge($arguments, [
            'C:/wamp64/bin/mysql/mysql5.7.26/bin/mysql',
            '--host=' . $dbInfo['host'],
            '--port=' . $dbInfo['port'],
            '--user=' . $dbInfo['username'],
            '--password=' . $dbInfo['password'],
        ]);
        }else{
            $arguments = ArrayHelper::merge($arguments, [
            '/usr/bin/mysql',
            '--host=' . $dbInfo['host'],
            '--port=' . $dbInfo['port'],
            '--user=' . $dbInfo['username'],
            '--password=' . $dbInfo['password'],
        ]);
        }
        $arguments = ArrayHelper::merge($arguments, [
            '/usr/bin/mysql',
            '--host=' . $dbInfo['host'],
            '--port=' . $dbInfo['port'],
            '--user=' . $dbInfo['username'],
            '--password=' . $dbInfo['password'],
        ]);
        if ($restoreOptions['preset']) {
            $arguments[] = trim($restoreOptions['presetData']);
        }
        $arguments[] = $dbInfo['dbName'];
        if (!StringHelper::endsWith($path, '.gz', false)) {
            $arguments[] = '<';
            $arguments[] = $path;
        }

        return implode(' ', $arguments);
    }
}
