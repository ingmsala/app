<?php 

	namespace app\modules\api\test\controllers;
	use yii\rest\Controller;
	use yii\data\SqlDataProvider;
	use app\modules\curriculares\models\Matricula;
	use app\models\User;
use app\modules\curriculares\models\Seguimiento;
use app\modules\sociocomunitarios\models\Detallerubrica;
use Yii;
use yii\filters\AccessControl;
	use yii\base\UserException;
use yii\data\ArrayDataProvider;
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
	            'sql' => "SELECT aniolectivo.nombre as year, alumno.apellido as student_lastName, alumno.nombre as student_name, matricula.id as enrollment_id, areaoptativa.nombre as field, actividad.nombre as subject, espaciocurricular.duracion as subject_duration, comision.id as commission_id, comision.nombre as commission_name, estadomatricula.nombre as state, matricula.fecha as date_state, tipoespacio.nombre as subject_type 
	            			FROM matricula 
	            			LEFT JOIN comision ON matricula.comision = comision.id 
	            			LEFT JOIN estadomatricula ON matricula.estadomatricula = estadomatricula.id 
	            			LEFT JOIN espaciocurricular ON comision.espaciocurricular = espaciocurricular.id
	            			LEFT JOIN areaoptativa ON espaciocurricular.areaoptativa = areaoptativa.id  
	            			LEFT JOIN tipoespacio ON espaciocurricular.tipoespacio = tipoespacio.id  
	            			LEFT JOIN aniolectivo ON espaciocurricular.aniolectivo = aniolectivo.id 
	            			LEFT JOIN alumno ON matricula.alumno = alumno.id 
	            			LEFT JOIN actividad ON espaciocurricular.actividad = actividad.id
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

			$mat = Matricula::findOne($enrollment_id);
			if($mat->comision0->espaciocurricular0->tipoespacio == 2){

				$array = [];
				
				$seg = Seguimiento::find()->where(['matricula' => $enrollment_id])->all();

				

				foreach ($seg as $s) {
					$detallerubrica = Detallerubrica::find()->where(['seguimiento' => $s->id])->all();
					$detru = '';

					foreach ($detallerubrica as $dr) {
						$detru.= $dr->calificacionrubrica0->rubrica0->descripcion.': '.$dr->calificacionrubrica0->detalleescalanota0->nota.'. ';
					}
					date_default_timezone_set('America/Argentina/Buenos_Aires');

					$array['item']['tracking_id'] = $s->id;
					$array['item']['tracking_date'] = Yii::$app->formatter->asDate($s->fecha, 'dd/MM/yyyy');

					try {
						$array['item']['tracking_detail'] = $s->tiposeguimiento0->nombre.' - '.$s->descripcion.': '.$detru.' - '.$s->estadoseguimiento0->nombre;
					} catch (\Throwable $th) {
						$array['item']['tracking_detail'] = $s->tiposeguimiento0->nombre.' - '.$s->descripcion.': '.$detru;
					}

					
				}


		
				//return var_dump($array);
				
				return new ArrayDataProvider([
					'allModels' => $array,
					
				]);

				
				
			}else{

				$array = [];
				
				$seg = Seguimiento::find()->where(['matricula' => $enrollment_id])->all();

				date_default_timezone_set('America/Argentina/Buenos_Aires');

				foreach ($seg as $s) {
					$array['item']['tracking_id'] = $s->id;
					$array['item']['tracking_date'] = Yii::$app->formatter->asDate($s->fecha, 'dd/MM/yyyy');

					try {
						$array['item']['tracking_detail'] = $s->tiposeguimiento0->nombre.' - '.$s->descripcion.' - '.$s->estadoseguimiento0->nombre;
					} catch (\Throwable $th) {
						$array['item']['tracking_detail'] = $s->tiposeguimiento0->nombre.' - '.$s->descripcion;
					}
					
				}


		
				//return var_dump($array);
				
				return new ArrayDataProvider([
					'allModels' => $array,
					
				]);

				/*return new SqlDataProvider([
					'sql' => 'SELECT
								seg.id AS tracking_id,
								fecha AS tracking_date,
								CONCAT(UPPER(ts.nombre), " - ", descripcion, " - ", COALESCE(UPPER(es.nombre), "")) AS tracking_detail
								FROM
									seguimiento seg
								LEFT JOIN 
									tiposeguimiento ts ON seg.tiposeguimiento = ts.id
								LEFT JOIN 
									estadoseguimiento es ON seg.estadoseguimiento = es.id
								WHERE seg.matricula='.$enrollment_id,
					'pagination' => false,
				]);*/
			}

	    }


	    
	}

?>
