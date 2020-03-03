<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Division;
use app\config\Globales;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'logout'],
                'rules' => [
                    [
                        'actions' => ['index', 'logout'],   
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
    

    public function actionIndex()
    {
        if (in_array (Yii::$app->user->identity->role, [Globales::US_DOCENTE, Globales::US_SACADEMICA, Globales::US_COORDINACION, Globales::US_SREI])){
                return $this->redirect(['/optativas']);
                
        }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTOR){
                 return $this->redirect(['/optativas/clase/claseshoy']);
            
        }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
            return $this->redirect(['/reporte/preceptores/preceptores']);
       }
        elseif(Yii::$app->user->identity->role == Globales::US_HORARIO){
                $this->layout = 'mainvacio';
                return $this->redirect(['/horario/menuopciones']);
            }
        elseif(Yii::$app->user->identity->role == Globales::US_MANTENIMIENTO){
            return $this->redirect(['/tareamantenimiento']);
        }
        return $this->render('index');
    }

    public function actionMantenimiento()
    {
        if (YII_ENV_DEV) {
            Yii::$app->getModule('debug')->instance->allowedIPs = [];
        }
        
        return $this->render('mantenimiento');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            if (in_array (Yii::$app->user->identity->role, [Globales::US_DOCENTE, Globales::US_SACADEMICA, Globales::US_COORDINACION, Globales::US_SREI])){
                return $this->redirect(['/optativas']);
            }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTOR){
                 return $this->redirect(['/optativas/clase/claseshoy']);
            }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
                return $this->redirect(['//reporte/preceptores/preceptores']);
            }elseif(Yii::$app->user->identity->role == Globales::US_HORARIO){
                $this->layout = 'mainvacio';
                return $this->redirect(['/horario/menuopciones']);
            }elseif(Yii::$app->user->identity->role == Globales::US_MANTENIMIENTO){
                return $this->redirect(['/tareamantenimiento']);
            }
            
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (in_array (Yii::$app->user->identity->role, [Globales::US_DOCENTE, Globales::US_SACADEMICA, Globales::US_COORDINACION, Globales::US_SREI])){
                return $this->redirect(['/optativas']);
            }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTOR){
                 return $this->redirect(['/optativas/clase/claseshoy']);
            }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
                    return $this->redirect(['//reporte/preceptores/preceptores']);
            }elseif(Yii::$app->user->identity->role == Globales::US_HORARIO){
                $this->layout = 'mainvacio';
                return $this->redirect(['/horario/menuopciones']);
            }elseif(Yii::$app->user->identity->role == Globales::US_MANTENIMIENTO){
                return $this->redirect(['/tareamantenimiento']);
            }
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
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

        return $this->goHome();
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
