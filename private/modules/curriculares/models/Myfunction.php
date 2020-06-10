<?php
namespace app\modules\curriculares\models;

use Yii;

use app\modules\curriculares\models\Clase;
use app\modules\curriculares\models\ClaseSearch;

class Myfunction {


	public static function claseHoyView($tipoespacio){
        
        $searchModel = new ClaseSearch();
        $dataProvider = $searchModel->getClasesHoy(Yii::$app->request->queryParams);

        date_default_timezone_set('America/Argentina/Buenos_Aires');

        if(in_array (Yii::$app->user->identity->role, [8,9])){
            $clasesdehoy = Clase::find()
                ->joinWith(['comision0', 'comision0.docentexcomisions', 'comision0.docentexcomisions.docente0', 'comision0.espaciocurricular0'])
                ->where(['fecha' => date('Y-m-d')])
                ->andWhere(['docente.mail' => Yii::$app->user->identity->username])
                ->andWhere(['espaciocurricular.tipoespacio' => $tipoespacio])
                ->orderBy('hora asc')->all();
        
            $clasesproximas = Clase::find()
                ->joinWith(['comision0', 'comision0.docentexcomisions', 'comision0.docentexcomisions.docente0', 'comision0.espaciocurricular0'])
                ->where(['BETWEEN', 'fecha', date('Y-m-d', strtotime("+1 days")), date('Y-m-d', strtotime("+7 days"))])
                ->andWhere(['docente.mail' => Yii::$app->user->identity->username])
                ->andWhere(['espaciocurricular.tipoespacio' => $tipoespacio])
                ->orderBy('fecha ASC, hora asc')->all();
        }else{
            $clasesdehoy = Clase::find()
                ->joinWith(['comision0', 'comision0.espaciocurricular0'])
                ->where(['fecha' => date('Y-m-d')])
                ->andWhere(['espaciocurricular.tipoespacio' => $tipoespacio])
                ->orderBy('hora asc')->all();
        
            $clasesproximas = Clase::find()
                ->joinWith(['comision0', 'comision0.espaciocurricular0'])
                ->where(['BETWEEN', 'fecha', date('Y-m-d', strtotime("+1 days")), date('Y-m-d', strtotime("+7 days"))])
                ->andWhere(['espaciocurricular.tipoespacio' => $tipoespacio])
                ->orderBy('fecha ASC, hora asc')->all(); 
        }

        if($tipoespacio == 1)
            $rurl = 'optativas';
        elseif($tipoespacio == 2)
            $rurl = 'sociocomunitarios';
        

        if(count($clasesdehoy)>0){
            $echo = '<div>';
            
            foreach ($clasesdehoy as $clase) {

                if($clase->hora != null){
                    //date_default_timezone_set('America/Argentina/Buenos_Aires');
                    $ini = Yii::$app->formatter->asTime($clase->hora, 'HH:mm');
                    //$ini = $clase->hora;
                    if($clase->horafin != null){
                        $fin = Yii::$app->formatter->asTime($clase->horafin,'HH:mm');
                        //$fin = $clase->horafin;
                        $horario = $ini.' a '.$fin;
                    }
                        
                    else{
                        $horario = $ini;
                    }
                }else{
                    $horario = 'Sin definir';
                }

                

                $echo .= '<a href="?r='.$rurl.'/clase/claseinterhoy&id='.$clase->id.'"><div class="col-6 col-md-6 col-lg-4">';
                 $echo .= '<div class="panel panel-default" style="height: 25vh;">
                  <div class="panel-heading">'.$clase->comision0->espaciocurricular0->actividad0->nombre.'</div>
                  <div class="panel-body">
                    <ul>
                        <li>Comisión: '.$clase->comision0->nombre.'</li>
                        <li>Horario: '.$horario.'</li>
                    </ul>
                    
                  </div>
                </div>
                </div></a>';
            }
            $echo .= '</div>'; 
        }else{
            $echo = "<i>No hay clases pautadas para hoy.</i>";
        }
        
        if(count($clasesproximas)>0){
            
            $echo2 = '<div>';
            foreach ($clasesproximas as $clase2) {
                if($clase2->hora != null){
                    
                    $ini = Yii::$app->formatter->asTime($clase2->hora, 'HH:mm');
                    if($clase2->horafin != null){
                        $fin = Yii::$app->formatter->asTime($clase2->horafin, 'HH:mm');
                        $horario2 = $ini.' a '.$fin;
                    }
                        
                    else{
                        $horario2 = $ini;
                    }
                }else{
                    $horario2 = 'Sin definir';
                }
                $echo2 .= '<a href="?r='.$rurl.'/clase/claseinterhoy&id='.$clase2->id.'"><div class="col-6 col-md-6 col-lg-4">';
                 $echo2 .= '<div class="panel panel-success" style="height: 25vh;">
                  <div class="panel-heading">'.$clase2->comision0->espaciocurricular0->actividad0->nombre.'</div>
                  <div class="panel-body">
                    <ul>
                        <li>Fecha: '.Yii::$app->formatter->asDate($clase2->fecha, 'dd/MM/yyyy').'</li>
                        <li>Comisión: '.$clase2->comision0->nombre.'</li>
                        <li>Horario: '.$horario2.'</li>
                    </ul>
                    
                  </div>
                </div>
                </div></a>';
            }
            $echo2 .= '</div>'; 
        }else{
            $echo2 = "<i>No hay clases próximas.</i>";
        }

        

        //$com = $_SESSION['comisionx'] = 0;
        
        //$comision = Comision::findOne($com);
       // $optativa = Espaciocurricular::findOne($comision->espaciocurricular);
        

        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'echo' => $echo,
            'echo2' => $echo2,
        ]; 
    }



}

?>