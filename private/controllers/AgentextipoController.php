<?php

namespace app\controllers;

use app\config\Globales;
use app\models\Agente;
use Yii;
use app\models\Agentextipo;
use app\models\AgentextipoSearch;
use app\models\Nodocente;
use app\models\Tipocargo;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AgentextipoController implements the CRUD actions for Agentextipo model.
 */
class AgentextipoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'migrar'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'migrar'],   
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
                        'actions' => ['create', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA]);
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
     * Lists all Agentextipo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgentextipoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Agentextipo model.
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
     * Creates a new Agentextipo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($agente)
    {
        $model = new Agentextipo();
        $tipocargo = Tipocargo::find()->all();
        $agentex = Agente::findOne($agente);

        if ($model->load(Yii::$app->request->post())) {

            $tiposcargos = Yii::$app->request->post()['Agentextipo']['tipocargo'];
            //return var_dump(Yii::$app->request->post());
            foreach ($tiposcargos as $tc) {
                $tcx = new Agentextipo();
                $tcx->agente = $agente;
                $tcx->tipocargo = $tc;
                $tcx->save();
            }
            return $this->redirect(['agente/update', 'id' => $agente]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'tipocargo' => $tipocargo,
            'agentex' => $agentex,
        ]);
    }

    public function actionMigrar()
    {
        $agentes = Agente::find()->all();
        $docentes = [];
        foreach ($agentes as $agente) {

            if($agente->documento != null){
                $docentes [$agente->documento] = $agente->documento;
                $model = new Agentextipo();
                $model->agente = $agente->id;
                $model->tipocargo = 1;
                $model->save();
            }
            
           
        }
        //return var_dump($docentes);
        $agentesnd = Nodocente::find()
                    ->where(['not in', 'documento', $docentes])
                    ->all();
                    //return var_dump($agentesnd);
        foreach ($agentesnd as $agentend) {

            $modelagente = new Agente();
            $modelagente->legajo = $agentend->legajo;
            $modelagente->apellido = $agentend->apellido;
            $modelagente->nombre = $agentend->nombre;
            $modelagente->genero = $agentend->genero;
            $modelagente->documento = $agentend->documento;
            $modelagente->mail = $agentend->mail;
            $modelagente->fechanac = $agentend->fechanac;
            $modelagente->tipodocumento = $agentend->tipodocumento;
            $modelagente->localidad = $agentend->localidad;
            $modelagente->cuil = $agentend->cuil;
            $modelagente->domicilio = $agentend->domicilio;
            $modelagente->telefono = $agentend->telefono;
            $modelagente->mapuche = $agentend->mapuche;
            $modelagente->save();
            
            $model2 = new Agentextipo();
            $model2->agente = $modelagente->id;
            $model2->tipocargo = 2;
            $model2->save();
        }

        $agentesndydoc = Nodocente::find()
                    ->where(['in', 'documento', $docentes])
                    ->all();
                    //return var_dump($agentesndydoc);
        foreach ($agentesndydoc as $agentendydoc) {

            /*$modelagente = new Agente();
            $modelagente = $agentend;
            $modelagente->save();*/

            $ag = Agente::find()->where(['documento' => $agentendydoc->documento])->one();
            
            $model3 = new Agentextipo();
            $model3->agente = $ag->id;
            $model3->tipocargo = 2;
            $model3->save();
        }

        return var_dump($agentesndydoc);

        

        
    }

    /**
     * Updates an existing Agentextipo model.
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
     * Deletes an existing Agentextipo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $agente = $model->agente;
        $model->delete();

        return $this->redirect(['agente/update', 'id' => $agente]);
    }

    /**
     * Finds the Agentextipo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Agentextipo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Agentextipo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
