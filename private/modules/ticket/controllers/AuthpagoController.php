<?php

namespace app\modules\ticket\controllers;

use app\config\Globales;
use app\models\Agente;
use Yii;
use app\modules\ticket\models\Authpago;
use app\modules\ticket\models\AuthpagoSearch;
use app\modules\ticket\models\Estadoauthpago;
use app\modules\ticket\models\Proveedorpago;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthpagoController implements the CRUD actions for Authpago model.
 */
class AuthpagoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update'],
                'rules' => [
                    
                    [
                        'actions' => ['index'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                           try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECECONOMICA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],
                    [
                        'actions' => ['create', 'update'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                           try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_AGENTE, Globales::US_NODOCENTE]);
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
     * Lists all Authpago models.
     * @return mixed
     */
    public function actionIndex()
    {
        $g = new Globales();
        $this->layout = $g->getLayout(Yii::$app->user->identity->role);

        $searchModel = new AuthpagoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Authpago model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($modelauth)
    {
        return var_dump($modelauth);
        
    }

    /**
     * Creates a new Authpago model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //$model = new Authpago();
        //$form = Yii::$app->request->post()['form'];
        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        $modelauth = new Authpago();
        $modelauth->estado = 1;
        $modelauth->agente = $agente->id;
        $modelauth->activo = 1;
        $proveedores = Proveedorpago::find()->all();
        $estados = Estadoauthpago::find()->where(['id' => 1])->all();
        if ($modelauth->load(Yii::$app->request->post())) {
            return $this->redirect(['/ticket/ticket/create', 'id' => Yii::$app->request->post()]);
        }

        return $this->renderAjax('create', [
            //'model' => $model,
            'modelauth' => $modelauth,
            //'form' => $form,
            'estados' => $estados,
            'proveedores' => $proveedores,
        ]);
    }
    public function actionCreateupdate($proveedor=null, $estado=null, $fecha=null, $ordenpago=null, $monto=null)
    {
        //$model = new Authpago();
        
        $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        $modelauth = new Authpago();
        
        $modelauth->estado = 1;
        $modelauth->agente = $agente->id;
        $modelauth->activo = 1;
        $modelauth->proveedor = $proveedor;
        $modelauth->fecha = $fecha;
        $modelauth->ordenpago = $ordenpago;
        $modelauth->monto = $monto;
        
        $proveedores = Proveedorpago::find()->all();
        $estados = Estadoauthpago::find()->where(['id' => 1])->all();
        if ($modelauth->load(Yii::$app->request->post())) {
            return $this->redirect(['/ticket/ticket/create', 'id' => Yii::$app->request->post()]);
        }

        return $this->renderAjax('create', [
            //'model' => $model,
            'modelauth' => $modelauth,
            //'form' => $form,
            'estados' => $estados,
            'proveedores' => $proveedores,
        ]);
    }

    /**
     * Updates an existing Authpago model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $modelauth = $this->findModel($id);
        
        $modelauthaguardar = new Authpago();
        $proveedores = Proveedorpago::find()->all();
        $estados = Estadoauthpago::find()->where(['id' => $modelauth->estado])->all();
        if ($modelauth->load(Yii::$app->request->post())) {

            $agente = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
            $modelauthaguardar->ticket = $modelauth->ticket;
            $modelauthaguardar->proveedor = $modelauth->proveedor;
            $modelauthaguardar->estado = $modelauth->estado;
            
            $fechaauth = explode("/",$modelauth->fecha);
            $newfechaauth = date("Y-m-d", mktime(0, 0, 0, $fechaauth[1], $fechaauth[0], $fechaauth[2]));
            $modelauthaguardar->fecha = $newfechaauth;

            $modelauthaguardar->ordenpago = $modelauth->ordenpago;
            $modelauthaguardar->monto = $modelauth->monto;
            $modelauthaguardar->agente = $agente->id; 
            $modelauthaguardar->activo = 1;

            $modelauthX = $this->findModel($id);
            $modelauthX->activo = 2;
            $modelauthX->save();
            $modelauthaguardar->save();

            
            return $this->redirect(['/ticket/ticket/view', 't' => $modelauth->ticket0->token]);
        }

        $fechaexplode = explode("-",$modelauth->fecha);
        $newdatefecha = date("d/m/Y", mktime(0, 0, 0, $fechaexplode[1], $fechaexplode[2], $fechaexplode[0]));
        $modelauth->fecha = $newdatefecha;

        return $this->renderAjax('update', [
            'modelauth' => $modelauth,
            'estados' => $estados,
            'proveedores' => $proveedores,
        ]);
    }

    /**
     * Deletes an existing Authpago model.
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
     * Finds the Authpago model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Authpago the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Authpago::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
