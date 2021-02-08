<?php

namespace app\modules\edh\controllers;

use app\config\Globales;
use app\models\Division;
use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\Aniolectivo;
use Yii;
use app\modules\edh\models\Matriculaedh;
use app\modules\edh\models\MatriculaedhSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MatriculaedhController implements the CRUD actions for Matriculaedh model.
 */
class MatriculaedhController extends Controller
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
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN]);
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
     * Lists all Matriculaedh models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $searchModel = new MatriculaedhSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Matriculaedh model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Matriculaedh model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = new Matriculaedh();
        $alumnos = Alumno::find()->orderBy('apellido, nombre')->all();
        $aniolectivos = Aniolectivo::find()->all();
        $divisiones = Division::find()->where(['<', 'id', 53])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'alumnos' => $alumnos,
            'aniolectivos' => $aniolectivos,
            'divisiones' => $divisiones,
        ]);
    }

    /**
     * Updates an existing Matriculaedh model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = '@app/modules/edh/views/layouts/main';
        $model = $this->findModel($id);

        $alumnos = Alumno::find()->orderBy('apellido, nombre')->all();
        $aniolectivos = Aniolectivo::find()->all();
        $divisiones = Division::find()->where(['<', 'id', 53])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'alumnos' => $alumnos,
            'aniolectivos' => $aniolectivos,
            'divisiones' => $divisiones,
        ]);
    }

    /**
     * Deletes an existing Matriculaedh model.
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
     * Finds the Matriculaedh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Matriculaedh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Matriculaedh::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
