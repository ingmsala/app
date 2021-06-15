<?php

namespace app\modules\becas\controllers;

use app\config\Globales;
use app\modules\becas\models\Becaalumno;
use app\modules\becas\models\Becaconviviente;
use Yii;
use app\modules\becas\models\Becanegativaanses;
use app\modules\becas\models\BecanegativaansesSearch;
use app\modules\becas\models\Becasolicitante;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BecanegativaansesController implements the CRUD actions for Becanegativaanses model.
 */
class BecanegativaansesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update'],   
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionDescargar($file)
    {
        
        $model = Becanegativaanses::find()->where(['url' => $file])->one();

        $path = Yii::getAlias('@webroot') . '/assets/images/negativaansesFMfcgzGkXSTfLSXK/'.$file;

        $file = $path;

        if (file_exists($file)) {

            Yii::$app->response->sendFile($file, $model->nombre);
        }

    }

    /**
     * Lists all Becanegativaanses models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BecanegativaansesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Becanegativaanses model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Becanegativaanses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Becanegativaanses();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Becanegativaanses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Becanegativaanses model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $origen, $pers)
    {
        if($origen == 'c'){
            $ori = 'grupofamiliar';
            $pers = Becaconviviente::findOne($pers);
            $pers2 = Becasolicitante::find()->where(['persona' => $pers->persona])->one();
            if($pers2!=null){
                if($pers2->conviviente == 1){
                    $pers2->negativaanses = null;
                    $pers2->ayudas =0;
                    $pers2->ocupaciones =0;
                    $pers2->save();
                }
            }
            
        }
        elseif($origen == 'a'){
            $pers = Becaalumno::findOne($pers);
            $ori = 'solicitud';
        }
        elseif($origen == 's'){
            $ori = 'solicitud';
            $pers = Becasolicitante::findOne($pers);
            if($pers->conviviente == 1){
                try {
                    $pers2 = Becaconviviente::find()->where(['persona' => $pers->persona])->one();
                    $pers2->negativaanses = null;
                    $pers2->ayudas =0;
                    $pers2->ocupaciones =0;
                    $pers2->save();
                } catch (\Throwable $th) {
                    //throw $th;
                }
                
            }
        }
        else{
            $pers = null;
            $ori = 'error';
        }
            

        try {
            $pers->negativaanses = null;
            $pers->ayudas =0;
            $pers->ocupaciones =0;
            $pers->save();
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        $model = $this->findModel($id);
        $s = $model->becasolicitud0->token;
        $model->delete();

        return $this->redirect(['/becas/default/'.$ori, 's' => $s]);
    }

    /**
     * Finds the Becanegativaanses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Becanegativaanses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Becanegativaanses::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
