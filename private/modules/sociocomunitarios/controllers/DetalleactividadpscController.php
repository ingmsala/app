<?php

namespace app\modules\sociocomunitarios\controllers;

use app\config\Globales;
use app\models\Agente;
use app\modules\curriculares\models\Detalleacta;
use app\modules\curriculares\models\Docentexcomision;
use app\modules\sociocomunitarios\models\Actividadpsc;
use Yii;
use app\modules\sociocomunitarios\models\Detalleactividadpsc;
use app\modules\sociocomunitarios\models\DetalleactividadpscSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DetalleactividadpscController implements the CRUD actions for Detalleactividadpsc model.
 */
class DetalleactividadpscController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'presentacion', 'calificacion', 'nullcalificacion','nullpresentacion' ],
                'rules' => [
                    [
                        'actions' => ['presentacion', 'calificacion', 'nullcalificacion','nullpresentacion'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                if(in_array (Yii::$app->user->identity->role, [1,8])){
                                    $autoriza = true;
                                     if(in_array (Yii::$app->user->identity->role, [1])){
                                         return true;
                                    }
                                    $com = isset($_SESSION['comisiontsx']) ? $_SESSION['comisiontsx'] : 0;
                                    
                                    
                                    $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                    $cant = count(Docentexcomision::find()
                                                        ->where(['comision' => $com])
                                                        ->andWhere(['agente' => $agente->id])
                                                        ->all());
                                        if($cant>0){
                                            $autoriza = true;
                                        }
                                        $autoriza = true;
                                   
                                    

                                    if(
                                        count(Detalleacta::find()->joinWith(['acta0'])->where(['acta.comision' => $com])->andWhere(['acta.estadoacta' => 2])
                                                                        //->andWhere(['detalleacta.matricula' => $matricula->id])                    
                                                                        ->all()) > 0){
                                        //count(Acta::find()->where(['comision' => $matricula->comision])->andWhere(['estadoacta' => 2])->all()) > 0){
                                        Yii::$app->session->setFlash('info', "No se puede realizar la acción ya que la comisión tiene un acta en estado cerrado");
                                        $autoriza = true;
                                    }
                                    return $autoriza;
                                }
                                return true;
                                
                            }catch(\Exception $exception){
                                return true;
                            }
                        }

                    ],
                    

                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'presentacion' => ['POST'],
                    'calificacion' => ['POST'],
                    'nullcalificacion' => ['POST'],
                    'nullpresentacion' => ['POST'],
                ],
            ],
        ];
    }
    

    /**
     * Lists all Detalleactividadpsc models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DetalleactividadpscSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPresentacion()
    {
        //return var_dump(Yii::$app->request->post()['act']);
        $actividad= Yii::$app->request->post()['act'];
        $matricula= Yii::$app->request->post()['m'];
        $presentacion= Yii::$app->request->post()['estado'];

        
        $detalleactividad = Detalleactividadpsc::find()
                        ->where(['matricula' => $matricula])
                        ->andWhere(['actividad' => $actividad])
                        ->one();
        if($detalleactividad==null){
            $model = new Detalleactividadpsc();
            $model->matricula = $matricula;
            $model->actividad = $actividad;
        }else{
            $model = $detalleactividad;
        }
        $model->presentacion = $presentacion;
        if($presentacion==3){
            $model->calificacion = 3;
        }
        $model->save();

        

        return $presentacion;
    }

    public function actionNullpresentacion()
    {
        //return var_dump(Yii::$app->request->post()['act']);
        $actividad= Yii::$app->request->post()['act'];
        $matricula= Yii::$app->request->post()['m'];
        $presentacion= Yii::$app->request->post()['estado'];

        try {
            $detalleactividad = Detalleactividadpsc::find()
                        ->where(['matricula' => $matricula])
                        ->andWhere(['actividad' => $actividad])
                        ->one();
            $detalleactividad->presentacion = null;
            $detalleactividad->calificacion = null;
            $detalleactividad->save();
        } catch (\Throwable $th) {
            //throw $th;
        }
        

        return $this->redirect(['/sociocomunitarios/actividadpsc/view', 'id' => $actividad]);
        
    }

    public function actionNullcalificacion()
    {
        //return var_dump(Yii::$app->request->post()['act']);
        $actividad= Yii::$app->request->post()['act'];
        $matricula= Yii::$app->request->post()['m'];
        $calificacion= Yii::$app->request->post()['estado'];

        try {
            $detalleactividad = Detalleactividadpsc::find()
                        ->where(['matricula' => $matricula])
                        ->andWhere(['actividad' => $actividad])
                        ->one();
            if($detalleactividad->presentacion!=3)
                $detalleactividad->calificacion = null;
            $detalleactividad->save();
        } catch (\Throwable $th) {
            //throw $th;
        }
        

        return $this->redirect(['/sociocomunitarios/actividadpsc/view', 'id' => $actividad]);
        
    }

    public function actionCalificacion()
    {
        //return var_dump(Yii::$app->request->post()['act']);
        $actividad= Yii::$app->request->post()['act'];
        $matricula= Yii::$app->request->post()['m'];
        $calificacion= Yii::$app->request->post()['estado'];

        
        $detalleactividad = Detalleactividadpsc::find()
                        ->where(['matricula' => $matricula])
                        ->andWhere(['actividad' => $actividad])
                        ->one();
        if($detalleactividad==null){
            $model = new Detalleactividadpsc();
            $model->matricula = $matricula;
            $model->actividad = $actividad;
        }else{
            $model = $detalleactividad;
        }
        $model->calificacion = $calificacion;
        
        $model->save();

        return 'ok';
    }

    /**
     * Displays a single Detalleactividadpsc model.
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
     * Creates a new Detalleactividadpsc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Detalleactividadpsc();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Detalleactividadpsc model.
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
     * Deletes an existing Detalleactividadpsc model.
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
     * Finds the Detalleactividadpsc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Detalleactividadpsc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Detalleactividadpsc::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
