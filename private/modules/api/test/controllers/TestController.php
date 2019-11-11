<?php 

	namespace app\modules\api\test\controllers;
	use yii\rest\Controller;
	use yii\data\SqlDataProvider;
	use app\modules\optativas\models\Matricula;
	use app\models\User;
	use yii\filters\AccessControl;
	use yii\base\UserException;
use yii\filters\auth\HttpBasicAuth;
	
	class TestController extends Controller
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

        $behaviors['authenticator'] = [

            'class' => HttpBasicAuth::className(),

            'auth' => [$this, 'auth']

        ];

        

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
		
	    public function actionMatricula($dni)
	    {
	        return new SqlDataProvider([
	            'sql' => "SELECT aniolectivo.nombre as year, alumno.apellido as student_lastName, alumno.nombre as student_name, matricula.id as enrollment_id, areaoptativa.nombre as field, actividad.nombre as subject, optativa.duracion as subject_duration, comision.id as commission_id, comision.nombre as commission_name, estadomatricula.nombre as state, matricula.fecha as date_state 
	            			FROM matricula 
	            			LEFT JOIN comision ON matricula.comision = comision.id 
	            			LEFT JOIN estadomatricula ON matricula.estadomatricula = estadomatricula.id 
	            			LEFT JOIN optativa ON comision.optativa = optativa.id
	            			LEFT JOIN areaoptativa ON optativa.areaoptativa = areaoptativa.id  
	            			LEFT JOIN aniolectivo ON optativa.aniolectivo = aniolectivo.id 
	            			LEFT JOIN alumno ON matricula.alumno = alumno.id 
	            			LEFT JOIN actividad ON optativa.actividad = actividad.id
	            			WHERE alumno.dni='".$dni."'",
	            'pagination' => false,
	        ]);
	    }

	    public function actionInasistencia($enrollment_id)
	    {
	        return new SqlDataProvider([
	            'sql' => "SELECT matricula.id as enrollment_id, clase.id class_id, clase.fecha as date_class  
	            			FROM inasistencia 
	            			LEFT JOIN matricula ON inasistencia.matricula = matricula.id 
	            			LEFT JOIN clase ON inasistencia.clase = clase.id 
	            			WHERE matricula.id=".$enrollment_id,
	            'pagination' => false,
	        ]);
	    }

	    public function actionAgenda($commission_id)
	    {
	        return new SqlDataProvider([
	            'sql' => "SELECT clase.id as class_id, clase.fecha as class_date, clase.hora as class_hour, clase.tema as class_topic, tipoclase.nombre as class_type, comision.id as commission_id, comision.nombre as commission_name
	            			FROM clase 
	            			LEFT JOIN tipoclase ON clase.tipoclase = tipoclase.id 
	            			LEFT JOIN comision ON clase.comision = comision.id 
	            			WHERE clase.comision=".$commission_id,
	            'pagination' => false,
	        ]);
	    }

	    public function actionSeguimiento($enrollment_id)
	    {
	        return new SqlDataProvider([
	            'sql' => 'SELECT
						    seg.id AS tracking_id,
						    fecha AS tracking_date,
						    CONCAT(ts.nombre, " - ", descripcion) AS tracking_detail
						    FROM
						        seguimiento seg
						    LEFT JOIN 
						        tiposeguimiento ts ON seg.tiposeguimiento = ts.id
						    WHERE seg.matricula='.$enrollment_id,
	            'pagination' => false,
	        ]);
	    }


	    
	}

?>
