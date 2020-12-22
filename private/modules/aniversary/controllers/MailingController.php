<?php

namespace app\modules\aniversary\controllers;

use app\config\Globales;
use app\models\Detallecatedra;
use app\models\Docente;
use app\models\Nodocente;
use app\models\Nombramiento;
use app\models\User;
use Yii;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class MailingController extends Controller
{
    /**
     * {@inheritdoc}
     */
    
    public $enableCsrfValidation = false;
    public function behaviors()

    {

        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
        'class' => \yii\filters\Cors::className(),
        'cors' => [
            'Origin' => ['*'],
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Request-Method'    => ['GET, POST, OPTIONS, PUT, PATCH, DELETE'],
            'Access-Control-Request-Headers' => ['X-Requested-With,content-type'],
        ]
    ];

        $behaviors['authenticator'] = [

            'class' => HttpBasicAuth::className(),

            'auth' => [$this, 'auth']

        ];

        

        return $behaviors;

    }

    public function auth($username, $password)

    { //jh3J)2#P21!jwIScn"$nd" //CRON_ANIV
        if($username == 'CRON_ANIV' || $username == 'msala@unc.edu.ar')
            $user = User::findByUsername($username);
        else
            $user = false;

        if(!$username or !$password or !$user)

            //return false;

            //OR

            throw new UserException( "Credenciales no autorizadas" );

        if ($user->validatePassword($password)) 

            return $user;
        else

        	throw new UserException( "Credenciales no autorizadas" );
     
           

    }

    /**
     * Lists all Monacademica models.
     * @return mixed
     */

    public function actionIndex(){
        
        
        $nombramientos = Nombramiento::find()->all();

        $array = [];
        foreach ($nombramientos as $nom) {
            $array [$nom->docente0->documento] = $nom->docente0->documento;
        }

        $detallecatedras = Detallecatedra::find()->where(['activo' => 1])->all();

        foreach ($detallecatedras as $dc) {
            $array [$dc->docente0->documento] = $dc->docente0->documento;
        }

        $nodocentes = Nodocente::find()->all();

        foreach ($nodocentes as $nodocente) {
            $arraynodoc [$nodocente->documento] = $nodocente->documento;
        }

        $docentes = Docente::find()
            ->where(['apellido' => 'GUERRA'])
            //->where(['=','day(fechanac)', date('d')])
            //->andWhere(['=','month(fechanac)', date('m')])
            ->andWhere(['in', 'documento', $array])
            ->all();

        $nodocentes = Nodocente::find()
            ->where(['apellido' => 'GUERRA'])
            //->where(['=','day(fechanac)', date('d')])
            //->andWhere(['=','month(fechanac)', date('m')])
            ->andWhere(['in', 'documento', $array])
            ->all();
        //return var_dump($docentes);
        //$array2 = [];
        foreach ($docentes as $doc) {
            if(!in_array($doc->documento, $arraynodoc)){
                $sendemail=Yii::$app->mailer->compose()
                            
                            ->setFrom([Globales::MAIL2 => 'Colegio Monserrat DOC3'])
                            ->setTo('msala@unc.edu.ar')
                            ->setSubject('Feliz cumple')
                            ->setHtmlBody('<img style="border: 0;display: block;height: auto;width: 100%;max-width: 480px;" alt="<Feliz cumpleaños" width="480" src="https://admin.cnm.unc.edu.ar/front/assets/images/fc.jpg" />')
                            ->send();
            }
                //$array2[$doc->documento] = $doc->documento;
            
        }

        foreach ($nodocentes as $nodoc) {
                    
            $sendemail=Yii::$app->mailer->compose()
                            
                            ->setFrom([Globales::MAIL2 => 'Colegio Monserrat NO3'])
                            ->setTo('msala@unc.edu.ar')
                            ->setSubject('Feliz cumple')
                            ->setHtmlBody('<img style="border: 0;display: block;height: auto;width: 100%;max-width: 480px;" alt="<Feliz cumpleaños" width="480" src="https://admin.cnm.unc.edu.ar/front/assets/images/fc.jpg" />')
                            ->send();
        }

        //return var_dump($array2);


    }

    
}
