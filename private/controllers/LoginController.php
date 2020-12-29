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
use app\models\CasModule;
use app\models\User;
use yii\helpers\Url;

//use silecs\yii2auth\cas\CasModule;

class LoginController extends Controller
{
    /**
     * {@inheritdoc}
     */
    

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
        
        //return $this->redirect(['/site/login']);
        //return $this->redirect(['/cas/auth/login']);
        
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
            }elseif(Yii::$app->user->identity->role == Globales::US_HORARIO){
                $this->layout = 'mainvacio';
                return $this->redirect(['/horario/menuopciones']);
            }
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCas(){
                
        return $this->redirect(['/cas/auth/desloguear']);
    }

    
}