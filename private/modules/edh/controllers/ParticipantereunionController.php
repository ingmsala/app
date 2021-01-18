<?php

namespace app\modules\edh\controllers;

use app\models\Agente;
use app\models\AgenteSearch;
use app\models\Detallecatedra;
use app\models\Horario;
use app\models\Nombramiento;
use app\modules\curriculares\models\Alumno;
use app\modules\curriculares\models\Tutor;
use Yii;
use app\modules\edh\models\Participantereunion;
use app\modules\edh\models\ParticipantereunionSearch;
use app\modules\edh\models\Reunionedh;
use app\modules\libroclase\models\Detallehora;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ParticipantereunionController implements the CRUD actions for Participantereunion model.
 */
class ParticipantereunionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Participantereunion models.
     * @return mixed
     */
    public function actionIndex($reunion)
    {
        $searchModel = new ParticipantereunionSearch();
        $dataProvider = $searchModel->porReunion($reunion);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Participantereunion model.
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

    public function actionPorreunion($id)
    {
        $model = new Participantereunion();
        
        $reunion = Reunionedh::findOne($id);

        
        $alumno = Alumno::find()->where(['id' => $reunion->caso0->matricula0->alumno])->one();
        $tutores = Tutor::find()->where(['alumno' => $reunion->caso0->matricula0->alumno])->all();

        $docentes_curso = Detallecatedra::find()
            ->joinWith(['catedra0', 'catedra0.actividad0', 'agente0'])
            ->where(['catedra.division' => $reunion->caso0->matricula0->division])
            ->andWhere(['<>', 'actividad.id', 31])
            ->andWhere(['<>', 'actividad.id', 33])
            ->andWhere(['<>', 'actividad.id', 195])
            ->andWhere(['revista' => 6])
            ->andWhere(['aniolectivo' => $reunion->caso0->matricula0->aniolectivo])
            ->orderBy('actividad.nombre')
            ->all();

        $items = [];

        $nombramientos = Nombramiento::find()
                            ->where(['in', 'cargo', [225,227,242]])
                            ->all();
        
        foreach ($docentes_curso as $detcat) {
            $items [] = [$detcat->agente0->documento.'-1' => $detcat->agente0->apellido.', '.$detcat->agente0->nombre.' - '.$detcat->catedra0->division0->nombre.' ('.$detcat->catedra0->actividad0->nombre.')'];
        }

        foreach ($nombramientos as $nom) {
            $items [] = [$nom->agente0->documento.'-1' => $nom->agente0->apellido.' ('.$nom->cargo0->nombre.')'];
        }

        //return var_dump(array_column(array_column($docentes_curso, 'agente0'), 'documento'));
        $agentes = Agente::find()
                ->where(['not in', 'documento', array_column(array_column($docentes_curso, 'agente0'), 'documento')])
                ->orWhere(['not in', 'documento', array_column(array_column($nombramientos, 'agente0'), 'documento')])    
            ->orderBy('apellido, nombre')->all();

        foreach ($agentes as $agente) {
            $items [] = [$agente->documento.'-1' => $agente->apellido];
        }
        $items [] = [$reunion->caso0->matricula0->alumno0->documento.'-4' => $reunion->caso0->matricula0->alumno0->apellido.', '.$reunion->caso0->matricula0->alumno0->nombre.' (Estudiante)'];
        foreach ($tutores as $tutor) {
            $items [] = [$tutor->documento.'-5' => $tutor->apellido.', '.$tutor->nombre.' ('.$tutor->parentesco.')'];
        }

        if (Yii::$app->request->post()) {
            
            $participantes = Yii::$app->request->post()['Participantereunion']['participantes'];
            
            foreach ($participantes as $participante) {
                $modelX = new Participantereunion();
                $modelX->reunionedh = $id;
                $modelX->tipoparticipante = 1;
                $modelX->asistio = 0;
                $modelX->comunico = 0;
                $modelX->participante = $participante;
                $modelX->save();
                
            }

            return $this->redirect(['reunionedh/view', 'id' => $id]);
        }
        
        return $this->renderAjax('porreunion', [
            'id' => $id,
            'model' => $model,
            'items' => $items,
        ]);
    }

    public function actionProcesar()
    {
        
        $param = Yii::$app->request->post();
        $reunion = $param['model'];
        $c='';

        

        foreach ($param['id'] as $detalleseleccionado) {
            $model = new Participantereunion();
            $model->reunionedh = $reunion;
            $model->tipoparticipante = 1;
            $model->asistio = 0;
            $model->comunico = 0;
            $model->participante = $detalleseleccionado;
            $model->save();
            $c .= $detalleseleccionado.' - ';
        }

        return $c;
        return Yii::$app->request->post();
        $acta_id = Yii::$app->request->post('agente')['id'];
        return $acta_id;
    }

    /**
     * Creates a new Participantereunion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Participantereunion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Participantereunion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Participantereunion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $participante = $this->findModel($id);
        $reunion = $participante->reunionedh;
        $participante->delete();

        return $this->redirect(['reunionedh/view', 'id' => $reunion]);
    }

    /**
     * Finds the Participantereunion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Participantereunion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Participantereunion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
