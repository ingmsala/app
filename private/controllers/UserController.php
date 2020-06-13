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
use app\models\Docente;
use app\models\Nodocente;
use yii\helpers\Html;

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
                'only' => ['index', 'view', 'create', 'update', 'delete', 'cambiarpass', 'importar'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'importar'],   
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

    public function actionImportar(){
        $docente = Docente::find()->all();
        $nodocente = Nodocente::find()->all();
        ini_set("pcre.backtrack_limit", "5000000");
        foreach ($docente as $doc) {
            $us = User::find()->where(['username'=>$doc->mail])->one();
            if($us == null){
                if($doc->mail != null && $doc->documento != null){
                    $user = new User();
                    $user->username = $doc->mail;
                    $user->role = Globales::US_DOCENTE;
                    $user->activate = 1;
                    $user->setPassword($doc->documento.'3223');
                    $user->generateAuthKey();
                    $user->save();
                }
                
            }
        }
        foreach ($nodocente as $nodoc) {
            $us2 = User::find()->where(['username'=>$nodoc->mail])->one();
            if($us2 == null){
                if($nodoc->mail != null && $nodoc->documento != null){
                    $user = new User();
                    $user->username = $nodoc->mail;
                    $user->role = Globales::US_NODOCENTE;
                    $user->activate = 1;
                    $user->setPassword($nodoc->documento.'3223');
                    $user->generateAuthKey();
                    $user->save();
                }
            }
        }
        return $this->redirect(['index']);

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

    public function actionResetpass($t)
    {
        Yii::$app->user->logout();
        $model = User::find()->where(['authKey' => $t])->one();
        
        if($model == null){
            Yii::$app->session->setFlash('danger', "El link no es correcto o el token ya ha sido utilizado.");
            return $this->goHome();
        }
        
        //return var_dump($model);
        $model->scenario = User::SCENARIO_RESETPASS;
        
        if($model->load(Yii::$app->request->post())){
            
            //$model = User::find()->where(['username' => $_POST['User']['username']])->one();
            //$model->attributes = $_POST['User'];
            
            $valid = $model->validate();
                    
            if($valid){
                
                $model->generateAuthKey();
                $model->setPassword($model->new_password);
                $model->activate = 1;
                    
                           
                if($model->save()){
                    Yii::$app->session->setFlash('success', "Se restableció la contraseña correctamente");
                    return $this->goHome();
                }
            }
        }

        
        //return var_dump($model);
        return $this->render('resetpass', [
            'model' => $model,
        ]);
    }

    public function actionSendreset()
    {
        Yii::$app->user->logout();
        $model = new User();
        
        if(isset($_POST['User'])){
            
            $model->attributes = $_POST['User'];
            $uss = User::find()->where(['username' => $model->username])->one();
            if($uss != null){
                
                try {
                    Yii::$app->mailer->compose()
                        ->setFrom([Globales::MAIL => 'Recuperar contraseña'])
                        ->setTo(Globales::MAIL)
                        ->setTo($uss->username)
                        ->setSubject('Generar nueva clave de acceso')
                        ->setHtmlBody('Para generar una nueva contraseña ingrese al siguiente link: '.Html::a('https://admin.cnm.unc.edu.ar/front/index.php?r=user/resetpass&t='.$uss->authKey, $url = 'https://admin.cnm.unc.edu.ar/front/index.php?r=user/resetpass&t='.$uss->authKey).' Este link sólo funcionará una sola vez.')
                        ->send();
                    Yii::$app->session->setFlash('success', "Se ha enviado a su casilla de correo las indicaciones para recuprar la contraseña");
                    return $this->goHome();
                }
                 catch (\Throwable $th) {
                    Yii::$app->session->setFlash('danger', "No tiene permisos para recuperar la contraseña.");
                    return $this->goHome();
                }
            
                
            }else{
                Yii::$app->session->setFlash('danger', "El usuario no existe.");
                return $this->goHome();
            }
        }

        return $this->render('sendreset', [
            'model' => $model,
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

    public function actionCambiarpass($i = 0)
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
                $model->generateAuthKey();
                $model->activate = 1;
                
                       
            if($model->save()){
                Yii::$app->session->setFlash('success', "Se modificó la contraseña correctamente");
                return $this->goHome();
            }
        }
    }

    
    
    //if(in_array (Yii::$app->user->identity->role, [Globales::US_DOCENTE, Globales::US_PRECEPTOR, Globales::US_SACADEMICA, Globales::US_COORDINACION, Globales::US_SREI])){
        $mensaje = '';
        if($i == 1)
            $this->layout = '@app/modules/optativas/views/layouts/main';
        elseif($i == 2)
            $this->layout = '@app/modules/sociocomunitarios/views/layouts/main';
        elseif($i == 3)
            $this->layout = '@app/modules/personal/views/layouts/mainpersonal';
        elseif($i == 4){
            $this->layout = '@app/views/layouts/mainactivar';
            $mensaje = 'En el primer acceso debe cambiar la contraseña.';
        }
            
    //}
    
    return $this->render('cambiarpass',
        [
            'model'=>$model,
            'mensaje'=>$mensaje,

        ]); 
 }
}
