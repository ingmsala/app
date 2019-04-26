<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Role;
use app\config\Globales;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'cambiarpass'],
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
                        'allow' => true,
                        'actions' => ['cambiarpass'],
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $roles = Role::find()
                ->where(['>', 'id', Globales::US_ADMIN])
                ->all();

        if ($model->load(Yii::$app->request->post())) {

            $model->setPassword($model->password);
            $model->generateAuthKey();

            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $roles = Role::find()
                ->where(['>', 'id', Globales::US_ADMIN])
                ->all();

        if ($model->load(Yii::$app->request->post())) {

            $model->setPassword($model->password);
            $model->generateAuthKey();

            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {   
        if($id!=1)
            $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCambiarpass()
 {      
    $model = new User;

    $model = User::find()
        ->where(['username' => Yii::$app->user->identity->username])->one();
    $model->scenario = $model::SCENARIO_CHANGEPASS;


    
     if(isset($_POST['User'])){
            
        $model->attributes = $_POST['User'];
        $valid = $model->validate();
                
        if($valid){
                //return $this->redirect(['index']);

                $model->setPassword($model->new_password);
                
                       
            if($model->save()){
                Yii::$app->session->set('success', "Se modificó la contraseña correctamente");
                return $this->redirect(['cambiarpass']);
            }
        }
    }
    
    if(in_array (Yii::$app->user->identity->role, [Globales::US_DOCENTE, Globales::US_PRECEPTOR, Globales::US_SACADEMICA, Globales::US_COORDINACION, Globales::US_SREI])){
        $this->layout = '@app/modules/optativas/views/layouts/main';
    }
    
    return $this->render('cambiarpass',
        [
            'model'=>$model,

        ]); 
 }
}
