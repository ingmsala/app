<?php

namespace app\modules\sociocomunitarios\controllers;

use Yii;
use app\modules\curriculares\models\Espaciocurricular;
use app\modules\curriculares\models\ComisionSearch;
use app\modules\curriculares\models\Aniolectivo;
use app\modules\curriculares\models\Areaoptativa;
use app\modules\curriculares\models\EspaciocurricularSearch;
use app\models\Actividad;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * EspaciocurricularController implements the CRUD actions for Espaciocurricular model.
 */
class EspaciocurricularController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],   
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Espaciocurricular models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $searchModel = new EspaciocurricularSearch();
        $dataProvider = $searchModel->search(2);

        return $this->render('/sociocomunitario/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Espaciocurricular model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new ComisionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/sociocomunitario/view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Espaciocurricular model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $model = new Espaciocurricular();
        $actividades = Actividad::find()
                        ->where(['actividadtipo' => 5])
                        ->all();
        $aniolectivo = Aniolectivo::find()->all();
        $areasoptativas = Areaoptativa::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->tipoespacio = 2;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('/sociocomunitario/create', [
            'model' => $model,
            'actividades' => $actividades,
            'aniolectivo' => $aniolectivo,
            'areasoptativas' => $areasoptativas,
        ]);
    }

    /**
     * Updates an existing Espaciocurricular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        
        $model = $this->findModel($id);
        $actividades = Actividad::find()
                        ->where(['actividadtipo' => 5])
                        ->all();
        $aniolectivo = Aniolectivo::find()->all();
        $areasoptativas = Areaoptativa::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('/sociocomunitario/update', [
            'model' => $model,
            'actividades' => $actividades,
            'aniolectivo' => $aniolectivo,
            'areasoptativas' => $areasoptativas,
        ]);
    }

    /**
     * Deletes an existing Espaciocurricular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        
        $this->findModel($id)->delete();

        return $this->redirect(['/sociocomunitario/index']);
    }

    /**
     * Finds the Espaciocurricular model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Espaciocurricular the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Espaciocurricular::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
