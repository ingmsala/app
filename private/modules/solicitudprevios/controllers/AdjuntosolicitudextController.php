<?php

namespace app\modules\solicitudprevios\controllers;

use app\config\Globales;
use Yii;
use app\modules\solicitudprevios\models\Adjuntosolicitudext;
use app\modules\solicitudprevios\models\AdjuntosolicitudextSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdjuntosolicitudextController implements the CRUD actions for Adjuntosolicitudext model.
 */
class AdjuntosolicitudextController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'descargar'],
                'rules' => [
                    [
                        'actions' => ['descargar'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_SECRETARIA]) || in_array (Yii::$app->user->identity->username, Globales::solicitudesext))
                                    return true;
                                return false;
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],   
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

    /**
     * Lists all Adjuntosolicitudext models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdjuntosolicitudextSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDescargar($file)
    {
        
        $model = Adjuntosolicitudext::find()->where(['url' => $file])->one();

        $path = Yii::getAlias('@webroot') . '/assets/images/solicitud6d639c31fbcc6029/'.$file;

        $file = $path;

        if (file_exists($file)) {

            Yii::$app->response->sendFile($file, $model->nombre);
        }

    }

    /**
     * Displays a single Adjuntosolicitudext model.
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
     * Creates a new Adjuntosolicitudext model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Adjuntosolicitudext();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Adjuntosolicitudext model.
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
     * Deletes an existing Adjuntosolicitudext model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Adjuntosolicitudext model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adjuntosolicitudext the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adjuntosolicitudext::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
