<?php

namespace app\modules\sociocomunitarios\controllers;

use app\config\Globales;
use Yii;use yii\filters\AccessControl;
use app\modules\curriculares\models\Comision;
use app\modules\curriculares\models\Myfunction;
use yii\web\Controller;


/**
 * Default controller for the `optativas` module
 */
class DefaultController extends Controller
{
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
                                return in_array (Yii::$app->user->identity->role, [1,3,6,8,9,12,13,14,20, Globales::US_PRECEPTORIA, Globales::US_REGENCIA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    
                ],
            ],
            
        ];
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main';
        
        $claseHoyView = Myfunction::claseHoyView(2);
        

        $echo = $this->renderPartial('/clase/claseshoy', [
            'searchModel' => $claseHoyView['searchModel'],
            'dataProvider' => $claseHoyView['dataProvider'],
            'echo' => $claseHoyView['echo'],
            'echo2' => $claseHoyView['echo2'],
        ]);

        return $this->render('index', [
            
            'echo' => $echo,
            
        ]);
    }

    public function actionSetsession($id)
    {   

        $session = Yii::$app->session;
		$session->set('comisiontsx', $_GET['id']);
        $session->set('aniolectivox', Comision::findOne($id)->espaciocurricular0->aniolectivo);
       
        return $id;
    }
}
