<?php

namespace app\modules\libroclase\controllers\desarrollo;

use app\config\Globales;
use app\modules\libroclase\models\desarrollo\Desarrollo;
use Yii;
use app\modules\libroclase\models\desarrollo\Detalledesarrollo;
use app\modules\libroclase\models\desarrollo\DetalledesarrolloSearch;
use Symfony\Component\Finder\Glob;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DetalledesarrolloController implements the CRUD actions for Detalledesarrollo model.
 */
class DetalledesarrolloController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'registrar'],
                'rules' => [
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
                    [
                        'actions' => ['registrar'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_AGENTE]);
                                
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
                    'registrar' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Detalledesarrollo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DetalledesarrolloSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Detalledesarrollo model.
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
     * Creates a new Detalledesarrollo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionRegistrar()
    {
        $t= Yii::$app->request->post()['t'];
        $tema= Yii::$app->request->post()['tema'];
        $estado= Yii::$app->request->post()['estado'];

        $desarrollo = Desarrollo::find()
                        ->where(['token' => $t])
                        ->one();
        $detalledesarrollo = Detalledesarrollo::find()
                        ->where(['desarrollo' => $desarrollo->id])
                        ->andWhere(['temaunidad' => $tema])
                        ->one();
        if($detalledesarrollo==null){
            $model = new Detalledesarrollo();
            $model->desarrollo = $desarrollo->id;
            $model->temaunidad = $tema;
        }else{
            $model = $detalledesarrollo;
        }
        $model->estado=$estado;
        $model->save();

        return 'ok';
    }

    public function actionCreate()
    {
        $model = new Detalledesarrollo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Detalledesarrollo model.
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
     * Deletes an existing Detalledesarrollo model.
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
     * Finds the Detalledesarrollo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Detalledesarrollo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Detalledesarrollo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
