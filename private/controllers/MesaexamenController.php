<?php

namespace app\controllers;

use app\config\Globales;
use app\models\Actividad;
use app\models\Actividadxmesa;
use app\models\Docente;
use app\models\Espacio;
use Yii;
use app\models\Mesaexamen;
use app\models\MesaexamenSearch;
use app\models\Tribunal;
use app\models\Turnoexamen;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MesaexamenController implements the CRUD actions for Mesaexamen model.
 */
class MesaexamenController extends Controller
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
                        'actions' => ['index'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_DOCENTE, Globales::US_PRECEPTOR, Globales::US_REGENCIA, Globales::US_SECRETARIA, Globales::US_HORARIO, Globales::US_CONSULTA, Globales::US_PRECEPTORIA]);
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
     * Lists all Mesaexamen models.
     * @return mixed
     */
    public function actionIndex($turno, $all = 0)
    {
        if(in_array (Yii::$app->user->identity->role, [Globales::US_DOCENTE, Globales::US_PRECEPTOR])){
            $this->layout = 'mainpersonal';
            $doc = Docente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        }
        else{
            $this->layout = 'main';
            $doc = null;
        }
            
        $searchModel = new MesaexamenSearch();
        $dataProvider = $searchModel->search($turno, $all);
        $turnoex = Turnoexamen::findOne($turno);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'turnoex' => $turnoex,
            'doc' => $doc,
            'all' => $all,
        ]);
    }

    /**
     * Displays a single Mesaexamen model.
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
     * Creates a new Mesaexamen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mesaexamen();

        

        $turnosexamen = Turnoexamen::find()->all();
        $espacios = Espacio::find()->all();
        $docentes = Docente::find()->all();
        $actividades = Actividad::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;

            $model->save();

            $doc = Yii::$app->request->post()['docentes'];
            $act = Yii::$app->request->post()['actividades'];

            foreach ($doc as $d) {
                $tribunal = new Tribunal();
                $tribunal->mesaexamen = $model->id;
                $tribunal->docente = $d;
                $tribunal->save();
            }

            foreach ($act as $a) {
                $actividadxmesa = new Actividadxmesa();
                $actividadxmesa->mesaexamen = $model->id;
                $actividadxmesa->actividad = $a;
                $actividadxmesa->save();
            }
            
            //return var_dump(Yii::$app->request->post());
            return $this->redirect(['index', 'turno' => $model->turnoexamen]);
            
        }

        return $this->render('create', [
            'model' => $model,
            'turnosexamen' => $turnosexamen,
            'espacios' => $espacios,
            'docentes' => $docentes,
            'actividades' => $actividades,
        ]);
    }

    /**
     * Updates an existing Mesaexamen model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $turnosexamen = Turnoexamen::find()->all();
        $espacios = Espacio::find()->all();
        $docentes = Docente::find()->all();
        $actividades = Actividad::find()->all();

        $actividadesxmesa = Actividadxmesa::find()->where(['mesaexamen' => $id])->all();
        $tribunal = Tribunal::find()->where(['mesaexamen' => $id])->all();

        if ($model->load(Yii::$app->request->post())) {

            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;

            $model->save();

            $doc = Yii::$app->request->post()['docentes'];
            $act = Yii::$app->request->post()['actividades'];

            foreach ($actividadesxmesa as $am) {
                $am->delete();
            }
            foreach ($tribunal as $tr) {
                $tr->delete();
            }

            foreach ($doc as $d) {
                $tribunal = new Tribunal();
                $tribunal->mesaexamen = $model->id;
                $tribunal->docente = $d;
                $tribunal->save();
            }

            foreach ($act as $a) {
                $actividadxmesa = new Actividadxmesa();
                $actividadxmesa->mesaexamen = $model->id;
                $actividadxmesa->actividad = $a;
                $actividadxmesa->save();
            }

        return $this->redirect(['index', 'turno' => $model->turnoexamen]);
        }

        $desdeexplode = explode("-",$model->fecha);
        $newdatedesde = date("d/m/Y", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[2], $desdeexplode[0]));
        $model->fecha = $newdatedesde;

        return $this->render('update', [
            'model' => $model,
            'turnosexamen' => $turnosexamen,
            'espacios' => $espacios,
            'docentes' => $docentes,
            'actividades' => $actividades,
            'actividadesxmesa' => $actividadesxmesa,
            'tribunal' => $tribunal,
        ]);
    }

    /**
     * Deletes an existing Mesaexamen model.
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
     * Finds the Mesaexamen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mesaexamen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mesaexamen::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
