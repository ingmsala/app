<?php

namespace app\controllers;

use Yii;
use app\models\Detallecatedra;
use app\models\DetallecatedraSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Docente;
use app\models\Revista;
use app\models\Condicion;
use app\models\Catedra;
use yii\filters\AccessControl;
use app\config\Globales;

use yii\widgets\ActiveForm; // Ajaxvalidation

use yii\web\Response; // Ajaxvalidation



/**
 * DetalleCatedraController implements the CRUD actions for DetalleCatedra model.
 */
class DetallecatedraController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'inactive', 'fechafin', 'migrate'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete', 'inactive', 'fechafin'],   
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
                        'actions' => ['index', 'view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_CONSULTA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                     [
                        'actions' => ['migrate'],   
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
     * Lists all DetalleCatedra models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DetalleCatedraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DetalleCatedra model.
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

    public function actionMigrate()
    {
        $dc = DetalleCatedra::find()
            ->select(['docente', 'catedra'])
            ->distinct()
            ->joinWith(['catedra0', 'catedra0.division0'])
            ->where(['revista' => 1])
            ->andWhere(['activo' => 1])
            ->andWhere(['in', 'division.turno',[1,2] ])
            ->orderBy('division.id')
            ->all();
        
        $txt = '';
        foreach ($dc as $dcx) {
            $model = new DetalleCatedra();
            $model->docente = $dcx->docente;
            $model->catedra = $dcx->catedra;
            $model->hora = $dcx->catedra0->actividad0->cantHoras;
            $model->condicion = 6;
            $model->revista = 6;
            $model->save();
            $txt .= var_dump($model);
            //$txt .= $dcx->catedra0->division0->nombre.' - '.$dcx->catedra0->actividad0->nombre.' - '.$dcx->docente0->apellido.'<br/>';
        }
        return $txt;

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['catedra/view', 'id' => $catedra]);
        }*/

        
    }

    /**
     * Creates a new DetalleCatedra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DetalleCatedra();
        if (isset ($_REQUEST['catedra'])) {
            $catedra = $_REQUEST['catedra'] ;
            
            $catedrax= Catedra::findOne($catedra);
            

            }else{
                $catedra='';
                $catedrax=Catedra::find()->all();
            } 

        
        $docentes=Docente::find()->orderBy('apellido', 'nombre', 'legajo')->all();

        if(Yii::$app->user->identity->role == Globales::US_SUPER){
            $condiciones=Condicion::find()->all();
            $revistas=Revista::find()->all();
        }else{
            $condiciones=Condicion::find()->where(['<>', 'id', 6])->all();
            $revistas=Revista::find()->where(['<>', 'id', 6])->all();
        }
        

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);

        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['catedra/view', 'id' => $catedra]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'catedra' => $catedra,

            'catedras' => $catedrax,
            'docentes' => $docentes,
            'condiciones' => $condiciones,
            'revistas' => $revistas,

        ]);
    }

    /**
     * Updates an existing DetalleCatedra model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (isset ($_REQUEST['catedra'])) {
            $catedra = $_REQUEST['catedra'] ;
            
            $catedrax= Catedra::findOne($catedra);
            

            }else{
                $catedra='';
                $catedrax=Catedra::find()->all();
            } 

        
        $docentes=Docente::find()->orderBy('apellido', 'nombre', 'legajo')->all();
        if(Yii::$app->user->identity->role == Globales::US_SUPER){
            $condiciones=Condicion::find()->all();
            $revistas=Revista::find()->all();
        }else{
            $condiciones=Condicion::find()->where(['<>', 'id', 6])->all();
            $revistas=Revista::find()->where(['<>', 'id', 6])->all();
        }

       if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);

        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['catedra/view', 'id' => $catedra]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'catedra' => $catedra,

            'catedras' => $catedrax,
            'docentes' => $docentes,
            'condiciones' => $condiciones,
            'revistas' => $revistas,
        ]);
    }

    public function actionUpdatehorario($id)
    {

        $model = $this->findModel($id);
        $catedra = $model->catedra0->id;
        $catedrax= Catedra::findOne($catedra);
        
        
        $docentes=Docente::find()->orderBy('apellido', 'nombre', 'legajo')->all();
        $condiciones=Condicion::find()->where(['=', 'id', 6])->all();
        $revistas=Revista::find()->where(['=', 'id', 6])->all();

       if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);

        }

        if ($model->load(Yii::$app->request->post())) {
            $model->catedra = $catedra;
            if($model->save())
                return $this->redirect(['horario/completoxcurso', 'division' => $catedrax->division, 'vista' => 'docentes']);
        }

        return $this->render('updatehorario', [
            'model' => $model,
            'catedra' => $catedra,

            'catedras' => $catedrax,
            'docentes' => $docentes,
            'condiciones' => $condiciones,
            'revistas' => $revistas,
        ]);
    }

    /**
     * Deletes an existing DetalleCatedra model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {   
        $catedra = $this->findModel($id)->catedra;
        $this->findModel($id)->delete();
        
        return $this->redirect(['catedra/view' , 'id' => $catedra]);

    }


       public function actionFechafin($id)
    {   
       

        $model = $this->findModel($id);
        $catedra = $model->catedra;
        $model->activo = Globales::CAT_INACTIVO;
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['catedra/view', 'id' => $catedra]);
        }

        return $this->renderAjax('fechafin', [
            'model' => $this->findModel($id),
        ]);

    }

    /**
     * Finds the DetalleCatedra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DetalleCatedra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DetalleCatedra::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
}
