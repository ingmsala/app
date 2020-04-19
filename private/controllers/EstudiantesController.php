<?php

namespace app\controllers;

use Yii;
use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\TutorSearch;
use app\modules\curriculares\models\AlumnoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\config\Globales;
use app\modules\curriculares\models\Tutor;

/*CREATE TABLE `test2`.`alumnoxtutor` ( `id` BIGINT(8) NOT NULL AUTO_INCREMENT , `alumno` INT(4) NOT NULL , 
`tutor` INT(4) NOT NULL , PRIMARY KEY (`id`), INDEX (`alumno`), INDEX (`tutor`))
ALTER TABLE `alumnoxtutor` ADD FOREIGN KEY (`alumno`) REFERENCES `alumno`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `alumnoxtutor` ADD FOREIGN KEY (`tutor`) REFERENCES `tutor`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;


*/

/**
 * FaltaController implements the CRUD actions for Falta model.
 */
class EstudiantesController extends Controller
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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_PRECEPTORIA]);
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
     * Lists all Falta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $alumnos = Alumno::find()->orderBy('apellido, nombre')->all();
        $alumno = new Alumno();
        

        if (Yii::$app->request->post()) {
            try {
                $alumno = $this->findModel(Yii::$app->request->post()['Alumno']['id']);
            } catch (\Throwable $th) {
                Yii::$app->session->setFlash('danger', "Debe seleccionar un estudiante");
                return $this->redirect(['index']);
            }
            
            
            if ($alumno != null){
                $searchModel = new TutorSearch();
                            $dataProvider = $searchModel->tutoresxalumno($alumno->id);

                            $model = Tutor::find()->where(['alumno' => $alumno->id])->all();
 
                            return $this->render('index', [
                                //'searchModel' => $searchModel,
                                'dataProvider' => $dataProvider,
                                'alumnos' => $alumnos,
                                'alumno' => $alumno,
                                'model' => $model,
                            ]);
            }
            
            
        }

        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => null,
            'alumnos' => $alumnos,
            'alumno' => $alumno,
        ]);
    }

    /**
     * Displays a single Falta model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Falta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */


    /**
     * Updates an existing Falta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */


    /**
     * Deletes an existing Falta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    /**
     * Finds the Falta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Falta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Alumno::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
