<?php

namespace app\modules\solicitudprevios\controllers;


use yii\web\Controller;


/**
 * AdjuntoticketController implements the CRUD actions for Adjuntoticket model.
 */
class DefaultController extends Controller
{
    /**
     * {@inheritdoc}
     */
    
    public function actionIndex()
    {
        return $this->redirect(['/solicitudprevios/crear']);
        
    }

}
