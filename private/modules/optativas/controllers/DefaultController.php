<?php

namespace app\modules\optativas\controllers;

use Yii;use yii\filters\AccessControl;
use app\modules\optativas\models\Comision;
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
                                return in_array (Yii::$app->user->identity->role, [1,3,6,8,9,12,13,14]);
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
        return $this->render('index');
    }

    public function actionSetsession($id)
    {   

        $session = Yii::$app->session;
		$session->set('comisionx', $_GET['id']);
        $session->set('aniolectivox', Comision::findOne($id)->optativa0->aniolectivo);
       
        return $id;
    }
}
