<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Progress;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\optativas\models\ClaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Agenda de Clases';

?>

<?php $meses = [ 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12=> 'Diciembre', '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre']; ?>

<div class="pull-right" style="margin-bottom: 10px;">
        <button class="btn btn-default hidden-print" onclick="javascript:window.print()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
</div>
<div class="clase-index" style="margin-top: 20px;">

    <center><h2><?= $this->title  ?></h2></center>

    
    
    <ol class="breadcrumb">
      <?php echo '<b>Espacio Optativo:</b> '.$comision['optativa0']['aniolectivo0']['nombre'].' - '.$comision['optativa0']['actividad0']['nombre']?>
    

    <?php 

                    echo '<div style="margin-left:20px;">Profesores/as</div>';

                    $item = [];
                    $docentes = $comision['docentexcomisions'];

                    foreach ($docentes as $docente) {
                        if($docente->role == 8)
                            $item[] = [$docente->docente0->apellido, $docente->docente0->nombre];
                    }
                    echo Html::ul($item, ['item' => function($item) {
                             return 
                                        Html::tag('li', $item[0].', '.$item[1]);
                        
                    }]);

                    echo '<div style="margin-left:20px;">Preceptores</div>';

                    $item = [];
                    $docentes = $comision['docentexcomisions'];

                    foreach ($docentes as $docente) {
                        if($docente->role == 9)
                            $item[] = [$docente->docente0->apellido, $docente->docente0->nombre];
                    }
                    echo Html::ul($item, ['item' => function($item) {
                             return 
                                        Html::tag('li', $item[0].', '.$item[1]);
                        
                    }]);


    ?>

    </ol>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,

        //'filterModel' => $searchModel,
        /*'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        
        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
                'filename' =>Html::encode($this->title),
                
                //'alertMsg' => false,
            ],
            

        ],
        'toolbar'=>[
            
            '{export}',
            
        ],*/
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Fecha',
                //'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model) use($meses){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    if(!$model['fechaconf']){
                        //if (Yii::$app->formatter->asDate($model['fecha'], 'MM')<10)

                        //return Yii::$app->formatter->asDate($model['fecha'], 'n');
                        try{
                            return $meses[Yii::$app->formatter->asDate($model['fecha'], 'MM')].'<span style="color: red;"><i> (A definir)</i><span>';
                        }catch(\Exception $exception){
                            return Yii::$app->formatter->asDate($model['fecha'], 'MM');
                        }
                        
                    }
                   if ($model['fecha'] == date('Y-m-d')){
                        return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy').' (HOY)';
                   } 
                   return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Tipo de Clase',
                'attribute' => 'tipoclase0.nombre',
            ],
            [
                'label' => 'Horario',
                'format' => 'raw',
                'value' => function($model){
                    if($model->hora != null)
                        return $model->hora;
                    else
                        return '<span style="color: red;"><i>(A definir)</i><span>';
                }
            ],
            
         
            
            [
                'label' => 'Duración',
                'value' => function($model){
                    $hora_reloj = $model->horascatedra / 1.666666;
                    
                    $h = intval($hora_reloj);
                    $m = round((((($hora_reloj - $h) / 100.0) * 60.0) * 100), 0);
                    if ($m == 60)
                    {
                        $h++;
                        $m = 0;
                    }
                    $retval = sprintf("%02d:%02d", $h, $m);
                    
                    return $retval.' hs.';
                },
            ],
          [
                'label' => 'Tema',
                'value' => function($model){
                    return $model->tema;
                },
            ],
            
        ],
    ]); 


   

    ?>


    


</div>
