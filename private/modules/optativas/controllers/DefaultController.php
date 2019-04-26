<?php

namespace app\modules\optativas\controllers;

use yii\web\Controller;
use Yii;use yii\filters\AccessControl;


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
        return $id;
    }
}
