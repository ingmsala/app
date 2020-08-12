<?php

namespace app\modules\edh\controllers;

use app\config\Globales;
use app\models\Docente;
use Yii;
use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\AlumnoSearch;
use app\modules\curriculares\models\Aniolectivo;
use app\modules\curriculares\models\Comision;
use app\modules\curriculares\models\Docentexcomision;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * AlumnoController implements the CRUD actions for Alumno model.
 */
class MenuopcionesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN]);
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
        

        
            $this->layout = 'main';
            return $this->render('index');
        
        
        


           

        

        

        
    }

}
