<?php

use app\components\CardWidget;
use app\modules\ticket\models\Adjuntoticket;
use app\modules\ticket\models\Asignacionticket;
use app\widgets\Listado;
use kartik\base\Config;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use kartik\markdown\Markdown;
use kartik\markdown\Module;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\widgets\ListView;

if($dataProvider != null){
    if($dataProvider->getTotalCount()>0){
        echo '<div class="clearfix"></div>';
        echo '<h3>Respuestas</h3>';
        $echo = '';
        
        foreach ($dataProvider->getModels() as $model) {

        $adjuntos = Adjuntoticket::find()->where(['detalleticket' => $model->id])->all();
        $arr = ArrayHelper::map($adjuntos,'url', function($model){
            $len = (Yii::$app->params['devicedetect']['isMobile']) ? 20 : 40;
            if(strlen($model->nombre)>$len){
                $arr = [];
                $arr = explode(".", $model->nombre);
                $ext = end($arr);
                return substr(ltrim($model->nombre),0,$len).'...'.$ext;


            }else
                return $model->nombre;
        });

        $estado2 = ($model->estadoticket == 1) ? '<span class="label label-success">'.$model->estadoticket0->nombre.'</span>' : '<span class="label label-danger">'.$model->estadoticket0->nombre.'</span>';
        $estado='';
        if($model->estadoauthpago != null){
            if($model->estadoauthpago == 1)
                $lbl = 'info';
            elseif($model->estadoauthpago == 2)
                $lbl = 'petroleo';
            elseif($model->estadoauthpago == 3)
                $lbl = 'purple';
            else
                $lbl = 'warning';
            $estado .=   ' <span class="label label-'.$lbl.'"> Orden: '.$model->estadoauthpago0->nombre.'</span>';
        }

        $asignacion = ($model->asignacionticket0->agente == null) ? $model->asignacionticket0->areaticket0->nombre : $model->asignacionticket0->agente0->apellido.', '.substr(ltrim($model->asignacionticket0->agente0->nombre),0,1);
        $areaanterior = false;
        //return var_dump($model->asignacionticket0->anteriorasignacion0);
        $anterior = Asignacionticket::findOne($model->asignacionticket0->anteriorasignacion);
        if($anterior->agente == null){
            $asignacionanterior = $anterior->areaticket0->nombre;
            $areaanterior = true;
            $creador = $asignacionanterior;
        }else{
            $asignacionanterior = $anterior->agente0->apellido.', '.substr(ltrim($anterior->agente0->nombre),0,1);
            $creador = $model->agente0->apellido.', '.substr(ltrim($model->agente0->nombre),0,1);
        }
        $pie = '';

        
        if($arr != null){
            $pie .= '<hr style="margin-bottom:0px;" />';
            $pie .= '<div class="push-left text-muted">Adjuntos</div><div class="row" style="margin-left:2%">';
                foreach ($arr as $key => $img) {
                    $pie .= '<div style="margin-left:5%" class="col-md-3">'.Html::a('<div class="label label-default">'.$img.'</div>', Url::to(['adjuntoticket/descargar', 'file' => $key]), ['target'=>'_blank']).'</div>';
                }
            $pie .= '</div>';
        }

        $module = Config::getModule(Module::MODULE);
        $output = Markdown::convert($model->descripcion, ['custom' => $module->customConversion]);
        
        $descrip = HtmlPurifier::process($output);

        date_default_timezone_set('America/Argentina/Buenos_Aires');

        $fecha = Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
        $hora = explode(':', $model->hora);

        if($asignacion == $asignacionanterior){
            $textasignacion = 'Asignado a <b>'.$asignacion.'</b>';
        }else{
            $textasignacion = 'Asignación cambia de <b>'.$creador.'  <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>  '.$asignacion.'</b>';
        }

                
        $echo .= '<div class="vista-listado flowGrid">
                    <div class="item-aviso flowGridItem">
                        <div class="header-aviso-resultados Empleos">
                            <h3>'.$textasignacion.'</h3>
                            <h4>'.$estado.'</h4>
                            <p class="fecha-publicado-resultados"><span class="pull-right">'.$estado2.'</span><br/><span class="text-muted">'.$fecha.' - '.$hora[0].':'.$hora[1].'hs. por '.$model->agente0->apellido.', '.substr(ltrim($model->agente0->nombre),0,1).'</span></p>
                        </div>
                        <div class="content-aviso-resultados">
                        '.$descrip.'
                        </div>
                        <div class="footer-aviso-resultados">
                            <div class="box-rs">
                            '.$pie.'
                            </div>
                            
                        </div>
                    </div>
                                    
                </div>';

        }



        echo $echo;

    }
    

}
?>