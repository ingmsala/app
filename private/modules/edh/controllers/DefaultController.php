<?php

namespace app\modules\edh\controllers;

use app\config\Globales;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * AdjuntoticketController implements the CRUD actions for Adjuntoticket model.
 */
class DefaultController extends Controller
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
                            return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER,Globales::US_CAE_ADMIN, Globales::US_GABPSICO, Globales::US_PRECEPTOR, Globales::US_REGENCIA, Globales::US_PRECEPTORIA, Globales::US_COORDINACION, Globales::US_VICEACAD]);
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

    
    public function actionIndex()
    {
        return $this->redirect(['/edh/menuopciones']);
        
    }

}
