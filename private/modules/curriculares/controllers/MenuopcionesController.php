<?php

namespace app\modules\curriculares\controllers;

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
                                return in_array (Yii::$app->user->identity->role, [1,3,6,8,9,12,13,14]);
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
        

        $aniolectivo = Aniolectivo::find()->where(['activo' => 1])->one();

        if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SACADEMICA, Globales::US_COORDINACION, Globales::US_SREI, Globales::US_CONSULTA, Globales::US_SECRETARIA])){
            $comisionesoptativas = Docentexcomision::find()
            ->distinct()
            ->select(['comision', 'espaciocurricular.aniolectivo'])
            
            ->joinWith(['comision0', 'comision0.espaciocurricular0', 'comision0.espaciocurricular0.actividad0'])
            ->where(['espaciocurricular.aniolectivo' => $aniolectivo->id])
            ->andWhere(['espaciocurricular.tipoespacio' => 1])
            ->orderBy('actividad.nombre', 'espaciocurricular.nombre')
            ->count();

            $comisionessociocom = Docentexcomision::find()
            ->distinct()
            ->select(['comision', 'espaciocurricular.aniolectivo'])
            
            ->joinWith(['comision0', 'comision0.espaciocurricular0', 'comision0.espaciocurricular0.actividad0'])
            ->where(['espaciocurricular.aniolectivo' => $aniolectivo->id])
            ->andWhere(['espaciocurricular.tipoespacio' => 2])
            ->orderBy('actividad.nombre', 'espaciocurricular.nombre')
            ->count();
        }else{
            $comisionesoptativas = Docentexcomision::find()
            ->joinWith(['docente0', 'comision0', 'comision0.espaciocurricular0', 'comision0.espaciocurricular0.actividad0'])
            ->where(['docente.legajo' => Yii::$app->user->identity->username])
            ->andWhere(['espaciocurricular.aniolectivo' => $aniolectivo->id])
            ->andWhere(['espaciocurricular.tipoespacio' => 1])
            ->orderBy('actividad.nombre', 'espaciocurricular.nombre')
            ->count(); 

            $comisionessociocom = Docentexcomision::find()
            ->joinWith(['docente0', 'comision0', 'comision0.espaciocurricular0', 'comision0.espaciocurricular0.actividad0'])
            ->where(['docente.legajo' => Yii::$app->user->identity->username])
            ->andWhere(['espaciocurricular.aniolectivo' => $aniolectivo->id])
            ->andWhere(['espaciocurricular.tipoespacio' => 2])
            ->orderBy('actividad.nombre', 'espaciocurricular.nombre')
            ->count(); 
        }

           
        if($comisionessociocom>0 && $comisionesoptativas>0){
            $this->layout = 'mainpublic';
            return $this->render('index', [
                'comisionesoptativas' => $comisionesoptativas,
                'comisionessociocom' => $comisionessociocom,
            ]);
        }elseif($comisionessociocom>0){
            return $this->redirect(['/sociocomunitarios']);
        }elseif($comisionesoptativas>0){
            return $this->redirect(['/optativas']);
        }else{
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('danger', "No tiene ningun espacio curricular activo");
            return $this->goHome();
        }


           

        

        

        
    }

}
