<?php

namespace bs\dbManager\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\web\Controller;
use bs\dbManager\models\Dump;
use bs\dbManager\models\Restore;
use Symfony\Component\Process\Process;
use yii\filters\AccessControl;
use app\config\Globales;

/**
 * Default controller.
 */
class DefaultController extends Controller
{
    /**
     * @return Module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'download', 'restore', 'storage', 'delete', 'deleteAll', 'nuevoajax'],
                'rules' => [
                    [
                        'actions' => ['nuevoajax'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_PRECEPTORIA]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['index', 'create', 'download', 'restore', 'storage', 'delete', 'deleteAll'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                    'nuevoajax' => ['post'],
                    'delete' => ['post'],
                    'delete-all' => ['post'],
                    'restore' => ['get', 'post'],
                    '*' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {

        

        
        try{
             $dataArray = $this->prepareFileData();
        $dbList = $this->getModule()->dbList;
        $model = new Dump($dbList, $this->getModule()->customDumpOptions);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $dataArray,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);
        $activePids = $this->checkActivePids();
            return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'dbList' => $dbList,
            'activePids' => $activePids,
        ]);
        }catch(\Exception $exception){
           Yii::$app->session->setFlash('error', var_dump($exception));
        return $this->redirect(['/optativas']);
        }
        
       
                            

        
    }

    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $model = new Dump($this->getModule()->dbList, $this->getModule()->customDumpOptions);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['index']);
            $dbInfo = $this->getModule()->getDbInfo($model->db);
            $dumpOptions = $model->makeDumpOptions();
            $manager = $this->getModule()->createManager($dbInfo);
            $dumpPath = $manager->makePath($this->getModule()->path, $dbInfo, $dumpOptions);
            $dumpCommand = $manager->makeDumpCommand($dumpPath, $dbInfo, $dumpOptions);
            Yii::trace(compact('dumpCommand', 'dumpPath', 'dumpOptions'), get_called_class());
            if ($model->runInBackground) {
                $this->runProcessAsync($dumpCommand);
            } else {
                $this->runProcess($dumpCommand);
            }
        } else {
            Yii::$app->session->setFlash('error', 'Dump request invalid.' . '<br>' . Html::errorSummary($model));
        }

        return $this->redirect(['index']);
    }

    public function actionNuevoajax()
    {
        //date_default_timezone_set('America/Argentina/Buenos_Aires');
        $param = Yii::$app->request->post();
        $id = $param['id'];
        $dataArray = $this->prepareFileData();

        $todayBackup = false;

        foreach ($dataArray as $backup) {
            $createAt = Yii::$app->formatter->asDate($backup['create_at'], 'yyyy-MM-dd');
            if ($createAt == date('Y-m-d')){
                $todayBackup = true;
            }
            
        }

        //return var_dump($dataArray[]['create_at']);

         
        if(!$todayBackup){


            $model = new Dump($this->getModule()->dbList, $this->getModule()->customDumpOptions);
        
            $dbInfo = $this->getModule()->getDbInfo('db');
            $dumpOptions = $model->makeDumpOptions();
            $manager = $this->getModule()->createManager($dbInfo);
            $dumpPath = $manager->makePath($this->getModule()->path, $dbInfo, $dumpOptions);
            $dumpCommand = $manager->makeDumpCommand($dumpPath, $dbInfo, $dumpOptions);
            Yii::trace(compact('dumpCommand', 'dumpPath', 'dumpOptions'), get_called_class());
            if ($model->runInBackground) {
                $this->runProcessAsync($dumpCommand);
            } else {
                $this->runProcess($dumpCommand);
            }
        
        }else{
            $id='no se creo xq existe';
        }
        return $id;
    }

    /**
     * @inheritdoc
     */
    public function actionDownload($id)
    {
        $dumpPath = $this->getModule()->path . StringHelper::basename(ArrayHelper::getValue($this->getModule()->getFileList(), $id));

        return Yii::$app->response->sendFile($dumpPath);
    }

    /**
     * @inheritdoc
     */
    public function actionRestore($id)
    {
        $dumpFile = $this->getModule()->path . StringHelper::basename(ArrayHelper::getValue($this->getModule()->getFileList(), $id));
        $model = new Restore($this->getModule()->dbList, $this->getModule()->customRestoreOptions);
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $dbInfo = $this->getModule()->getDbInfo($model->db);
                $restoreOptions = $model->makeRestoreOptions();
                $manager = $this->getModule()->createManager($dbInfo);
                $restoreCommand = $manager->makeRestoreCommand($dumpFile, $dbInfo, $restoreOptions);
                Yii::trace(compact('restoreCommand', 'dumpFile', 'restoreOptions'), get_called_class());
                if ($model->runInBackground) {
                    $this->runProcessAsync($restoreCommand, true);
                } else {
                    $this->runProcess($restoreCommand, true);
                }

                return $this->redirect(['index']);
            }
        }

        return $this->render('restore', [
            'model' => $model,
            'file' => $dumpFile,
            'id' => $id,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionStorage($id)
    {
        if (Yii::$app->has('backupStorage')) {
            $dumpname = StringHelper::basename(ArrayHelper::getValue($this->getModule()->getFileList(), $id));
            $dumpPath = $this->getModule()->path . $dumpname;
            $exists = Yii::$app->backupStorage->has($dumpname);
            if ($exists) {
                Yii::$app->backupStorage->delete($dumpname);
                Yii::$app->session->setFlash('success', 'Dump deleted from storage.');
            } else {
                $stream = fopen($dumpPath, 'r+');
                Yii::$app->backupStorage->writeStream($dumpname, $stream);
                Yii::$app->session->setFlash('success', 'Dump uploaded to storage.');
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * @inheritdoc
     */
    public function actionDelete($id)
    {
        $dumpFile = $this->getModule()->path . StringHelper::basename(ArrayHelper::getValue($this->getModule()->getFileList(), $id));
        if (unlink($dumpFile)) {
            Yii::$app->session->setFlash('success', 'Dump deleted successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Error deleting dump.');
        }

        return $this->redirect(['index']);
    }

    /**
     * @inheritdoc
     */
    public function actionDeleteAll()
    {
        if (!empty($this->getModule()->getFileList())) {
            $fail = [];
            foreach ($this->getModule()->getFileList() as $file) {
                if (!unlink($file)) {
                    $fail[] = $file;
                }
            }
            if (empty($fail)) {
                Yii::$app->session->setFlash('success', 'All dumps successfully removed.');
            } else {
                Yii::$app->session->setFlash('error', 'Error deleting dumps.');
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * @param $command
     * @param bool $isRestore
     */
    protected function runProcess($command, $isRestore = false)
    {
        $process = new Process($command);
        $process->run();
        if ($process->isSuccessful()) {
            //$msg = (!$isRestore) ? Yii::t('dbManager', 'Backup creado exitosamente.') : Yii::t('dbManager', 'Backup restaurado existosamente.');
            //Yii::$app->session->addFlash('success', $msg);
        } else {
            $msg = (!$isRestore) ? 'Dump failed.' : 'Restore failed.';
            Yii::$app->session->addFlash('error', $msg . '<br>' . 'Command - ' . $command . '<br>' . $process->getOutput() . $process->getErrorOutput());
            Yii::error($msg . PHP_EOL . 'Command - ' . $command . PHP_EOL . $process->getOutput() . PHP_EOL . $process->getErrorOutput());
        }
    }

    /**
     * @param $command
     * @param bool $isRestore
     */
    protected function runProcessAsync($command, $isRestore = false)
    {
        $process = new Process($command);
        $process->start();
        $pid = $process->getPid();
        $activePids = Yii::$app->session->get('backupPids', []);
        if (!$process->isRunning()) {
            if ($process->isSuccessful()) {
                $msg = (!$isRestore) ? 'Dump successfully created.' : 'Dump successfully restored.';
                Yii::$app->session->addFlash('success', $msg);
            } else {
                $msg = (!$isRestore) ? 'Dump failed.' : 'Restore failed.';
                Yii::$app->session->addFlash('error', $msg . '<br>' . 'Command - ' . $command . '<br>' . $process->getOutput() . $process->getErrorOutput());
                Yii::error($msg . PHP_EOL . 'Command - ' . $command . PHP_EOL . $process->getOutput() . PHP_EOL . $process->getErrorOutput());
            }
        } else {
            $activePids[$pid] = $command;
            Yii::$app->session->set('backupPids', $activePids);
            Yii::$app->session->addFlash('info', 'Process running with pid={pid}', ['pid' => $pid] . '<br>' . $command);
        }
    }

    /**
     * @return array
     */
    protected function checkActivePids()
    {
        $activePids = Yii::$app->session->get('backupPids', []);
        $newActivePids = [];
        if (!empty($activePids)) {
            foreach ($activePids as $pid => $cmd) {
                $process = new Process('ps -p ' . $pid);
                $process->run();
                if (!$process->isSuccessful()) {
                    Yii::$app->session->addFlash('success',
                        'Process complete!' . '<br> PID=' . $pid . ' ' . $cmd);
                } else {
                    $newActivePids[$pid] = $cmd;
                }
            }
        }
        Yii::$app->session->set('backupPids', $newActivePids);

        return $newActivePids;
    }

    /**
     * @return array
     */
    protected function prepareFileData()
    {
        //date_default_timezone_set('America/Argentina/Buenos_Aires');
        $dataArray = [];
        foreach ($this->getModule()->getFileList() as $id => $file) {
            $dataArray[] = [
                'id' => $id,
                'type' => pathinfo($file, PATHINFO_EXTENSION),
                'name' => StringHelper::basename($file),
                'size' => Yii::$app->formatter->asSize(filesize($file)),
                'create_at' => Yii::$app->formatter->asDatetime(filectime($file)),
            ];
        }
        ArrayHelper::multisort($dataArray, ['create_at'], [SORT_DESC]);

        return $dataArray ?: [];
    }
}