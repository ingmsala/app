<?php

namespace app\controllers;

use app\config\Globales;
use app\models\Nombramiento;
use app\models\Role;
use Yii;
use app\models\Rolexuser;
use app\models\RolexuserSearch;
use app\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * RolexuserController implements the CRUD actions for Rolexuser model.
 */
class RolexuserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'cambiar', 'migrar', 'asignarpreceptores'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'importar', 'migrar', 'asignarpreceptores'],   
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
                        'allow' => true,
                        'actions' => ['cambiar'],
                        'roles' => ['@'],
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
     * Lists all Rolexuser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RolexuserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMigrar()
    {
        $usuarios = User::find()->all();
        //return var_dump($usuarios);
        foreach ($usuarios as $user) {
            $roluser = new Rolexuser();
            $roluser->user = $user->id;
            $roluser->role = $user->role;
            $roluser->save();
            //return var_dump($roluser);
        }

        return $this->redirect(['index']);
    }

    public function actionAsignarpreceptores()
    {
        $nomb = Nombramiento::find()->where(['cargo' => 227])->andWhere(['<=', 'division', 53])->all();
                
        //return var_dump($usuarios);
        foreach ($nomb as $preceptor) {

            $user = User::find()->where(['username' => $preceptor->docente0->mail])->one();
            $roluser = new Rolexuser();
            $roluser->user = $user->id;
            $roluser->role = 9;
            $roluser->save();
            //return var_dump($roluser);
        }

        return $this->redirect(['index']);
    }

    /**
     * Displays a single Rolexuser model.
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
     * Creates a new Rolexuser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rolexuser();
        $usuarios = User::find()->all();
        $roles = Role::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'usuarios' => $usuarios,
            'roles' => $roles,
        ]);
    }

    /**
     * Updates an existing Rolexuser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $usuarios = User::find()->all();
        $roles = Role::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'usuarios' => $usuarios,
            'roles' => $roles,
        ]);
    }

    public function actionCambiar($i = 0)
    {   
        if($i == 1)
            $this->layout = '@app/views/layouts/main';
        elseif($i == 2)
            $this->layout = '@app/modules/sociocomunitarios/views/layouts/main';
        elseif($i == 3)
            $this->layout = '@app/views/layouts/mainpersonal';
        elseif($i == 4){
            $this->layout = '@app/views/layouts/mainactivar';
        }
                
        $roles = Rolexuser::find()->where(['user' => Yii::$app->user->identity->id])->all();
        $echodiv = '';
        foreach ($roles as $rol) {
                $echodiv .= '<div class="pull-left" style="height: 16vh; width: 100%; vertical-align: middle;">';
                $echodiv .= '<div>';
                $echodiv .= '<center>'.Html::a($rol->role0->nombre, Url::to(['user/changerole', 'id'=>$rol->user, 'role'=>$rol->role]), ['data-method' => 'POST', 'class' => 'menuHorarios', 'role'=>'button', 'style'=>'font-size:5vh; width:100; height: 15vh;']);
                $echodiv .= '</div><center>';
                $echodiv .= '</div>';
        }
        return $this->render('cambiar', [
            'echodiv' => $echodiv,
        ]);
    }

    /**
     * Deletes an existing Rolexuser model.
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
     * Finds the Rolexuser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rolexuser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rolexuser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
