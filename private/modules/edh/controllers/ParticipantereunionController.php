<?php

namespace app\modules\edh\controllers;

use app\config\Globales;
use app\models\Agente;
use app\models\AgenteSearch;
use app\models\Detallecatedra;
use app\models\Horario;
use app\models\Nombramiento;
use app\models\Rolexuser;
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
use yii\helpers\Html;
use yii\helpers\Url;

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
        $participantes_actuales = array_column($reunion->participantereunions, 'participante');

        
        $alumno = Alumno::find()->where(['id' => $reunion->caso0->matricula0->alumno])->one();
        $tutores = Tutor::find()
                ->where(['alumno' => $reunion->caso0->matricula0->alumno])
                ->andWhere(['not in', 'documento', $participantes_actuales])
                ->all();

        $docentes_curso = Detallecatedra::find()
            ->joinWith(['catedra0', 'catedra0.actividad0', 'agente0'])
            ->where(['catedra.division' => $reunion->caso0->matricula0->division])
            ->andWhere(['<>', 'actividad.id', 31])
            ->andWhere(['<>', 'actividad.id', 33])
            ->andWhere(['<>', 'actividad.id', 195])
            ->andWhere(['revista' => 6])
            ->andWhere(['aniolectivo' => $reunion->caso0->matricula0->aniolectivo])
            ->andWhere(['not in', 'agente.documento', $participantes_actuales])
            ->orderBy('agente.apellido, agente.nombre')
            ->all();

        $items = [];

        $nombramientos = Nombramiento::find()
                            ->joinWith(['agente0'])
                            ->where(['in', 'cargo', [225,207,242]])
                            ->andWhere(['not in', 'agente.documento', $participantes_actuales])
                            ->all();

        
        $preceptorcurso = Agente::find()
            ->where(['id' => $reunion->caso0->preceptor])
            ->andWhere(['not in', 'documento', $participantes_actuales])
            ->one();

        $jefe = Agente::find()
            ->where(['id' => $reunion->caso0->jefe])
            ->andWhere(['not in', 'documento', $participantes_actuales])
            ->one();
        

        foreach ($docentes_curso as $detcat) {
            $items [] = [$detcat->agente0->documento.'-1-'.$detcat->catedra0->actividad => $detcat->catedra0->division0->nombre.' - '.$detcat->agente0->apellido.', '.$detcat->agente0->nombre.' ('.$detcat->catedra0->actividad0->nombre.')'];
        }

        try {
            $items [] = [$preceptorcurso->documento.'-2' => $reunion->caso0->matricula0->division0->nombre.' - '.$preceptorcurso->apellido.', '.$preceptorcurso->nombre.' (Preceptor/a)'];
        } catch (\Throwable $th) {
            //throw $th;
        }
        

        try {
            $items [] = [$jefe->documento.'-6' => $jefe->apellido.', '.$jefe->nombre.' (Jefe de '.$reunion->caso0->matricula0->division0->preceptoria0->descripcion.')'];
        } catch (\Throwable $th) {
            //throw $th;
        }
        

        foreach ($nombramientos as $nom) {
            $items [] = [$nom->agente0->documento.'-3' => $nom->agente0->apellido.', '.$nom->agente0->nombre.' ('.$nom->cargo0->nombre.')'];
        }

        //return var_dump(array_column(array_column($docentes_curso, 'agente0'), 'documento'));
        $agentes = Agente::find()
                ->where(['not in', 'documento', array_column(array_column($docentes_curso, 'agente0'), 'documento')])
                ->andWhere(['not in', 'documento', array_column(array_column($nombramientos, 'agente0'), 'documento')])
                ->andWhere(['not in', 'documento', $participantes_actuales])
            ->orderBy('apellido, nombre')->all();

        foreach ($agentes as $agente) {
            $items [] = [$agente->documento.'-1' => $agente->apellido.', '.$agente->nombre];
        }

        if(!in_array($reunion->caso0->matricula0->alumno0->documento,$participantes_actuales))
            $items [] = [$reunion->caso0->matricula0->alumno0->documento.'-4' => $reunion->caso0->matricula0->alumno0->apellido.', '.$reunion->caso0->matricula0->alumno0->nombre.' (Estudiante)'];
        
            foreach ($tutores as $tutor) {
            $items [] = [$tutor->documento.'-5' => $tutor->apellido.', '.$tutor->nombre.' ('.$tutor->parentesco.')'];
        }

        if (Yii::$app->request->post()) {
            
            $participantes = Yii::$app->request->post()['Participantereunion']['participantes'];
            //return var_dump($participantes);
            if($participantes != null){
                foreach ($participantes as $participante) {
                    $parti = explode('-',$participante);
                    $modelX = new Participantereunion();
                    $modelX->reunionedh = $id;
                    $modelX->tipoparticipante = $parti[1];
                    $modelX->asistio = 0;
                    $modelX->comunico = 0;
                    $modelX->participante = $parti[0];
                    if(count($parti)==3)
                        $modelX->actividad = $parti[2];
                    //return var_dump($modelX);
                    $modelX->save();
                    
                }
                
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
    public function actionAsistioupdate()
    {
        //return Yii::$app->request->post('asistio');
        if(Yii::$app->request->post('asistio') == 'true')
            $asistio = 1;
        else
            $asistio = 0;
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        $model->asistio = $asistio;
        $model->save();
        return 'Cambio a '.$asistio;

        
    }
    public function actionComunicoupdate()
    {
        //return Yii::$app->request->post('asistio');
        if(Yii::$app->request->post('comunico') == 'true')
            $comunico = 1;
        else
            $comunico = 0;
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        $model->comunico = $comunico;
        $model->save();

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = Yii::$app->formatter->asDate($model->reunionedh0->fecha, 'dd/MM/yyyy');
        $hora = explode(':', $model->reunionedh0->hora);
        $hora = $hora[0].':'.$hora[1].'hs.';
        
        if(strpos($model->reunionedh0->lugar, 'virtual') !== false){
            $lugar = 'en '.$model->reunionedh0->lugar;
        }else{
            if($model->reunionedh0->url == null)
                $lugar = 'en forma virtual,';
            else
                $lugar = 'en forma virtual ('.Html::a(Url::to($model->reunionedh0->url, true), Url::to($model->reunionedh0->url, true)).'),';
        }
        if($model->comunico == 1){
            $output = 'Estimado docente de '.$model->reunionedh0->caso0->matricula0->division0->nombre.', se lo invita a participar de la reunión informativa sobre la situación de '.$model->reunionedh0->caso0->matricula0->alumno0->nombre.' '.$model->reunionedh0->caso0->matricula0->alumno0->apellido.', estudiante del curso. La misma se realizará '.$lugar.' el día '.$fecha.' a las '.$hora;
            $output .= '<br />Esperamos contar con su presencia. Saludamos atte.<br />Equipo de Educación Domiciliaria y Hospitalaria.';
            //$output = 'aa';
            $sendemail=Yii::$app->mailer->compose()
                                ->setFrom([Globales::MAIL => 'Educación Domiciliaria'])
                                ->setTo('msala@unc.edu.ar')
                                ->setSubject($model->reunionedh0->tematica)
                                ->setHtmlBody($output)
                                ->send();
        }
        

        return 'Cambio a '.$comunico;

        
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
