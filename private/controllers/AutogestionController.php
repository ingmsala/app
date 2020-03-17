<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\config\Globales;

/**
 * ActividadTipoController implements the CRUD actions for ActividadTipo model.
 */
class AutogestionController extends Controller
{

	public function actionIndex()
    {
        return $this->redirect(['/curriculares/autogestion/inicio']);
    }

}