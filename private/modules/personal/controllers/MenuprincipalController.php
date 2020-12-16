<?php

namespace app\modules\personal\controllers;

use app\config\Globales;
use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * AlumnoController implements the CRUD actions for Alumno model.
 */
class MenuprincipalController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_DOCENTE, Globales::US_PRECEPTOR, Globales::US_NODOCENTE, Globales::US_MANTENIMIENTO]);
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
     * Lists all Alumno models.
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->session->setFlash('danger', 'Dentro de la opción del menú <b>'.Yii::$app->user->identity->role0->nombre.'</b> podrá "Cambiar el rol de usuario" para acceder a las funcionalidades administrativas o a las del cargo Docente o No docente para trámites personales.');

        $this->layout = '@app/views/layouts/mainpersonal';
        return $this->render('index');

        
    }

}
