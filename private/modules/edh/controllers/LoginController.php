<?php

namespace app\modules\edh\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Division;
use app\config\Globales;

class LoginController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],   
                        'allow' => true,
                        'roles' => ['@'],

                    ],

                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    

    public function actionIndex2()
    {
        if(Yii::$app->user->identity->role == Globales::US_CAE_ADMIN){
            $this->layout = '/edh/layouts/main';
            return $this->redirect(['/edh/menuopciones']);
        }
        return $this->render('index');
    }

    
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionIndex()
    {
        
        $this->layout = 'mainlogin';
        if (!Yii::$app->user->isGuest) {
            if(Yii::$app->user->identity->role == Globales::US_CAE_ADMIN){
                $this->layout = '/edh/layouts/main';
                return $this->redirect(['/edh/menuopciones']);
            }
            
            
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(Yii::$app->user->identity->role == Globales::US_CAE_ADMIN){
                $this->layout = '/edh/layouts/main';
                return $this->redirect(['/edh/menuopciones']);
            }
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['/edh/login']);
    }

   /* public function actionError()
    {
       $excepcion = Yii::$app->errorHandler->exception;
       if($excepcion !==null){
        Yii::$app->session->setFlash('danger', "No tiene credenciales para acceder a la operación");
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }

        
    }*/

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    
	
    
}
