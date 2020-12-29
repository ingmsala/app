<?php

namespace app\controllers;

use Yii;
use app\models\Preceptoria;
use app\models\Turno;
use app\models\PreceptoriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\config\Globales;
use app\models\Division;
use app\models\DivisionSearch;
use app\models\Nombramiento;
use yii\data\ArrayDataProvider;

/**
 * PreceptoriaController implements the CRUD actions for Preceptoria model.
 */
class PreceptoriaController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['delete'],   
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
     * Lists all Preceptoria models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PreceptoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Preceptoria model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $echo = $this->divisiones($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'echo' => $echo
        ]);
    }


    public function divisiones($id)
	    {
	        
            $preceptores = Nombramiento::find()
                ->where(['cargo' => Globales::CARGO_PREC])
                ->orderBy('revista, division')->all();

            $pre = Preceptoria::find()->where(['id' => $id])->one();
            $divisiones = Division::find()
                        ->where(['preceptoria' => $pre->id])
                        ->orderBy('id')
                        ->all();

            $array = [];
            
            foreach ($divisiones as $division) {
                $array[$division->id][0] = $division->id;
                
                $array[$division->id][1] = $division->nombre;
                try {
                    $nombramiento = Nombramiento::find()
                    ->where(['cargo' => Globales::CARGO_PREC])
                    ->where(['division' => $division->id])
                    ->one();
                    $docente = $nombramiento->agente0->apellido.', '.$nombramiento->agente0->nombre;
                    $array[$division->id][999] = $nombramiento->id;
                } catch (\Throwable $th) {
                    $docente = '';
                    $array[$division->id][999] = 0;
                }
                
                $array[$division->id][2] = $docente;
            }

            $provider = new ArrayDataProvider([
                'allModels' => $array,
                
            ]);

	        return $this->renderPartial('/reporte/preceptores/preceptores', 
	        [
                
	            'provider' => $provider,
	            'preceptores' => $preceptores,
                
	        ]);
	    }

    /**
     * Creates a new Preceptoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Preceptoria();
        $turnos = Turno::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'turnos' => $turnos,
        ]);
    }

    /**
     * Updates an existing Preceptoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $turnos = Turno::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'turnos' => $turnos,
        ]);
    }

    /**
     * Deletes an existing Preceptoria model.
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
     * Finds the Preceptoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Preceptoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Preceptoria::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
