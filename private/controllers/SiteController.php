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
        
        Yii::$app->session->setFlash('danger', 'Dentro de la opción del menú <b>'.Yii::$app->user->identity->role0->nombre.'</b> podrá "Cambiar el rol de usuario" para acceder a las funcionalidades administrativas o a las del cargo Docente o No docente para trámites personales.');
        if(Yii::$app->user->identity->activate == 0){
            return $this->redirect(['/user/cambiarpass', 'i'=>4]);
        }
        if (in_array (Yii::$app->user->identity->role, [Globales::US_SACADEMICA, Globales::US_COORDINACION, Globales::US_SREI])){
                return $this->redirect(['/curriculares/menuopciones']);
                
        }elseif(in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_NODOCENTE, Globales::US_MANTENIMIENTO, Globales::US_PRECEPTOR])){
            return $this->redirect(['/personal/menuprincipal']);
        }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
            return $this->redirect(['/reporte/preceptores/preceptores']);
        }elseif(Yii::$app->user->identity->role == Globales::US_PSC){
            return $this->redirect(['/sociocomunitarios']);
       }
        elseif(Yii::$app->user->identity->role == Globales::US_HORARIO){
                $this->layout = 'mainvacio';
                return $this->redirect(['/horario/menuopciones']);
            }
        elseif(Yii::$app->user->identity->role == Globales::US_MANTENIMIENTO){
            return $this->redirect(['/tareamantenimiento']);
        }elseif(Yii::$app->user->identity->role == Globales::US_CAE_ADMIN){
            $this->layout = '/edh/layouts/main';
            return $this->redirect(['/edh/menuopciones']);
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

    public function actionLogin()
    {
        return $this->goHome();
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLoginadmin()
    {
        $this->layout = 'mainlogin';
        if (!Yii::$app->user->isGuest) {
            if (in_array (Yii::$app->user->identity->role, [Globales::US_SACADEMICA, Globales::US_COORDINACION, Globales::US_SREI])){
                return $this->redirect(['/curriculares/menuopciones']);
            }elseif(in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_NODOCENTE, Globales::US_MANTENIMIENTO, Globales::US_PRECEPTOR])){
                 return $this->redirect(['/personal/menuprincipal']);
            }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
                return $this->redirect(['//reporte/preceptores/preceptores']);
            }elseif(Yii::$app->user->identity->role == Globales::US_HORARIO){
                $this->layout = 'mainvacio';
                return $this->redirect(['/horario/menuopciones']);
            }elseif(Yii::$app->user->identity->role == Globales::US_PSC){
                return $this->redirect(['/sociocomunitarios']);
            }elseif(Yii::$app->user->identity->role == Globales::US_CAE_ADMIN){
                $this->layout = '/edh/layouts/main';
                return $this->redirect(['/edh/menuopciones']);
            }
            
            
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(Yii::$app->user->identity->activate == 0){
                return $this->redirect(['/user/cambiarpass', 'i'=>4]);
            }
            if (in_array (Yii::$app->user->identity->role, [Globales::US_SACADEMICA, Globales::US_COORDINACION, Globales::US_SREI])){
                return $this->redirect(['/curriculares/menuopciones']);
            }elseif(in_array (Yii::$app->user->identity->role, [Globales::US_AGENTE, Globales::US_NODOCENTE, Globales::US_MANTENIMIENTO, Globales::US_PRECEPTOR])){
                return $this->redirect(['/personal/menuprincipal']);
            }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
                    return $this->redirect(['//reporte/preceptores/preceptores']);
            }elseif(Yii::$app->user->identity->role == Globales::US_PSC){
                return $this->redirect(['/sociocomunitarios']);
                
            }elseif(Yii::$app->user->identity->role == Globales::US_HORARIO){
                $this->layout = 'mainvacio';
                return $this->redirect(['/horario/menuopciones']);
            }elseif(Yii::$app->user->identity->role == Globales::US_CAE_ADMIN){
                $this->layout = '/edh/layouts/main';
                return $this->redirect(['/edh/menuopciones']);
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
