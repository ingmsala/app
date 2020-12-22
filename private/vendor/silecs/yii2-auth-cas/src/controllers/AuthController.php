<?php

/**
 * @license MIT License
 */

namespace silecs\yii2auth\cas\controllers;

use app\models\User;
use Yii;
use yii\helpers\Url;

/**
 * A controller inside the Module that will handle the HTTP query of the CAS server.
 *
 * Provides 2 actions, usually /cas/login and /cas/logout,
 * where "cas" is the key in the configuration file of the Yii2 application
 * `"modules" => ['cas' => ...]`.
 *
 * @author François Gannaz <francois.gannaz@silecs.info>
 */
class AuthController extends \yii\web\Controller
{
    public function actionLogin()
    {
        //$_SERVER['HTTPS']='off';//deshablitar para produccion
        $this->module->casService->forceAuthentication();
        
        $username = $this->module->casService->getUsername();
        //$_SERVER['HTTPS']='on';//deshablitar para produccion
        $user = null;
        if ($username) {
            $user = User::find()->where(['username' => $username])->one();
            
            if ($user != null) {
                Yii::$app->user->login(User::findByUsername($user->username));
            } else {
                Yii::$app->session->setFlash('danger', "Su usuario no está activado. Deberá comunicarse con la Oficina de Personal.");
                return $this->redirect(Url::home(true));
                throw new \yii\web\HttpException(403, "This user has no access to the application.");
            }
        }
        //return var_dump(Yii::$app->user->identity->username);
        return $this->goBack();
    }

    public function actionLogout()
    {
        //$_SERVER['HTTPS']='off';//deshablitar para produccion
        $this->module->casService->logout(Url::home(true));
        //$_SERVER['HTTPS']='on';//deshablitar para produccion
        if (!Yii::$app->getUser()->isGuest) {
            Yii::$app->getUser()->logout(true);
            //Yii::$app->user->logout();
        }
        
        // In case the logout fails (not authenticated)
        return $this->redirect(Url::home(true));
    }

    public function actionDesloguear(){
        $this->module->casService->logout(Url::home(true));
        if (!Yii::$app->getUser()->isGuest) {
            Yii::$app->getUser()->logout(true);
            //Yii::$app->user->logout();
        }
        return $this->redirect(['login']);
    }
}
