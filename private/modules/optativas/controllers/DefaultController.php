<?php

namespace app\modules\optativas\controllers;

use yii\web\Controller;
use Yii;

/**
 * Default controller for the `optativas` module
 */
class DefaultController extends Controller
{
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
