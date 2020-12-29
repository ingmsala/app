<?php 

	namespace app\modules\api\test\controllers;
	use yii\rest\Controller;
	use yii\data\SqlDataProvider;
	use app\models\Horarioexamen;
	use app\models\User;
	use yii\filters\AccessControl;
	use yii\base\UserException;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use Yii;
	
	class ApihorarioController extends Controller
	{
	    //public $modelClass = 'app\modules\optativas\models\Alumno';
	    public $enableCsrfValidation = false;

public function behaviors()

    {

        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
        'class' => \yii\filters\Cors::className(),
        'cors' => [
            'Origin' => ['*'],
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Request-Method'    => ['GET, POST, OPTIONS, PUT, PATCH, DELETE'],
            'Access-Control-Request-Headers' => ['X-Requested-With,content-type'],
        ]
    ];

        /*$behaviors['authenticator'] = [

            'class' => HttpBasicAuth::className(),

            'auth' => [$this, 'auth']

        ];*/

        

        return $behaviors;

    }

    public function auth($username, $password)

    {

        $user = User::findByUsername($username);

        if(!$username or !$password or !$user)

            //return false;

            //OR

            throw new UserException( "Credenciales no autorizadas" );

        if ($user->validatePassword($password)) 

            return $user;
        else

        	throw new UserException( "Credenciales no autorizadas" );
     
           

    }
		
	    public function actionHorarioclase($legajo)
	    {
	    	/*$detallecat = Horarioexamen::find()
                    ->joinWith(['catedra0', 'hora0', 'catedra0.detallecatedras', 'catedra0.detallecatedras.agente0', 'catedra0.actividad0', 'catedra0.division0', 'catedra0.division0.turno0'])
                    ->andWhere(['detallecatedra.revista' => 6])
                    ->andWhere(['agente.legajo' => $legajo])
                    ->orderBy('horarioexamen.fecha, division.turno, hora.id')
                    ->all();*/
            //Yii::$app->response->format = Response::FORMAT_JSON;
	        return new SqlDataProvider([
	            'sql' => "SELECT
						    tur.nombre AS turno_name, di.nombre AS division_name, ac.nombre AS actividad_name, ds.nombre AS dia_name, hor.nombre AS hora_name
						FROM
						    `horario` h
						LEFT JOIN catedra c ON h.catedra = c.id
						LEFT JOIN hora hor ON h.hora = hor.id
						LEFT JOIN diasemana ds ON h.diasemana = ds.id
						LEFT JOIN detallecatedra dc ON dc.catedra = c.id
						LEFT JOIN docente doc ON dc.agente = doc.id
						LEFT JOIN actividad ac ON c.actividad = ac.id
						LEFT JOIN division di ON c.division = di.id
						LEFT JOIN turno tur ON di.turno = tur.id
						WHERE
						    dc.revista = 6
						AND
							doc.legajo = {$legajo}
						ORDER BY ds.id, di.turno, hor.id",
	            'pagination' => false,
	        ]);/*
	        
	        $listDocentes=ArrayHelper::toArray($detallecat, [
                    'app\models\Detallecatedra' => [
                        'id' => function($detallecatedra) {
                            return $detallecatedra['agente0']['id'];},
                        'name' => function($detallecatedra) {
                            return $detallecatedra['agente0']['apellido'].', '.$detallecatedra['agente0']['nombre'].' ('.$detallecatedra['catedra0']['actividad0']['nombre'].')';},
                    ],
                ]);

	        return $listDocentes;*/
	    }

	    public function actionHorarioclasejson($legajo)
	    {
	    	/*$detallecat = Horarioexamen::find()
                    ->joinWith(['catedra0', 'hora0', 'catedra0.detallecatedras', 'catedra0.detallecatedras.agente0', 'catedra0.actividad0', 'catedra0.division0', 'catedra0.division0.turno0'])
                    ->andWhere(['detallecatedra.revista' => 6])
                    ->andWhere(['agente.legajo' => $legajo])
                    ->orderBy('horarioexamen.fecha, division.turno, hora.id')
                    ->all();*/
            Yii::$app->response->format = Response::FORMAT_JSON;
	        return new SqlDataProvider([
	            'sql' => "SELECT
						    tur.nombre AS turno_name, di.nombre AS division_name, ac.nombre AS actividad_name, ds.nombre AS dia_name, hor.nombre AS hora_name
						FROM
						    `horario` h
						LEFT JOIN catedra c ON h.catedra = c.id
						LEFT JOIN hora hor ON h.hora = hor.id
						LEFT JOIN diasemana ds ON h.diasemana = ds.id
						LEFT JOIN detallecatedra dc ON dc.catedra = c.id
						LEFT JOIN docente doc ON dc.agente = doc.id
						LEFT JOIN actividad ac ON c.actividad = ac.id
						LEFT JOIN division di ON c.division = di.id
						LEFT JOIN turno tur ON di.turno = tur.id
						WHERE
						    dc.revista = 6
						AND
							doc.legajo = {$legajo}
						ORDER BY ds.id, di.turno, hor.id",
	            'pagination' => false,
	        ]);/*
	        
	        $listDocentes=ArrayHelper::toArray($detallecat, [
                    'app\models\Detallecatedra' => [
                        'id' => function($detallecatedra) {
                            return $detallecatedra['agente0']['id'];},
                        'name' => function($detallecatedra) {
                            return $detallecatedra['agente0']['apellido'].', '.$detallecatedra['agente0']['nombre'].' ('.$detallecatedra['catedra0']['actividad0']['nombre'].')';},
                    ],
                ]);

	        return $listDocentes;*/
	    }

	    	    public function actionHorarioexamenjson($legajo)
	    {
	    	/*$detallecat = Horarioexamen::find()
                    ->joinWith(['catedra0', 'hora0', 'catedra0.detallecatedras', 'catedra0.detallecatedras.agente0', 'catedra0.actividad0', 'catedra0.division0', 'catedra0.division0.turno0'])
                    ->andWhere(['detallecatedra.revista' => 6])
                    ->andWhere(['agente.legajo' => $legajo])
                    ->orderBy('horarioexamen.fecha, division.turno, hora.id')
                    ->all();*/
            Yii::$app->response->format = Response::FORMAT_JSON;
	        return new SqlDataProvider([
	            'sql' => "SELECT
						    tur.nombre AS turno_name, di.nombre AS division_name, ac.nombre AS actividad_name, DATE_FORMAT(h.fecha,'%d/%m/%Y') AS dia_name, hor.nombre AS hora_name, al.nombre AS anio
						FROM
						    `horarioexamen` h
						LEFT JOIN catedra c ON h.catedra = c.id
						LEFT JOIN anioxtrimestral axt ON h.anioxtrimestral = axt.id
						LEFT JOIN aniolectivo al ON axt.aniolectivo = al.id
						LEFT JOIN hora hor ON h.hora = hor.id
						lEFT JOIN detallecatedra dc ON dc.catedra = c.id
						LEFT JOIN docente doc ON dc.agente = doc.id
						LEFT JOIN actividad ac ON c.actividad = ac.id
						LEFT JOIN division di ON c.division = di.id
						LEFT JOIN turno tur ON di.turno = tur.id
						WHERE
						    dc.revista = 6
						AND
							h.tipo = 2
						AND

							doc.legajo = {$legajo}
						ORDER BY h.fecha, hor.id, di.turno",
	            'pagination' => false,
	        ]);/*
	        
	        $listDocentes=ArrayHelper::toArray($detallecat, [
                    'app\models\Detallecatedra' => [
                        'id' => function($detallecatedra) {
                            return $detallecatedra['agente0']['id'];},
                        'name' => function($detallecatedra) {
                            return $detallecatedra['agente0']['apellido'].', '.$detallecatedra['agente0']['nombre'].' ('.$detallecatedra['catedra0']['actividad0']['nombre'].')';},
                    ],
                ]);

	        return $listDocentes;*/
	    }

	    


	    
	}

?>
