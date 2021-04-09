<?php

namespace app\modules\libroclase\controllers;

use app\config\Globales;
use app\models\Actividad;
use app\models\ActividadSearch;
use app\models\Agente;
use app\models\Docentexdepartamento;
use app\models\Plan;
use app\modules\libroclase\models\Detalleunidad;
use Yii;
use app\modules\libroclase\models\Programa;
use app\modules\libroclase\models\ProgramaSearch;
use app\modules\libroclase\models\TemaunidadSearch;
use app\modules\libroclase\models\Unidad;
use kartik\grid\GridView;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * ProgramaController implements the CRUD actions for Programa model.
 */
class ProgramaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['materiaxdivision'],
                'rules' => [
                    [
                        'actions' => ['materiaxdivision'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                $persona = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                                $depto = Docentexdepartamento::find()->where(['agente' => $persona->id])->count();
                                return (in_array (Yii::$app->user->identity->username, Globales::authttemas) || $depto>0 );
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
     * Lists all Programa models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $this->layout = '@app/views/layouts/mainpersonal';
        $searchModel = new ProgramaSearch();
        $dataProvider = $searchModel->poractividad($id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actividad' => $id
        ]);
    }
}