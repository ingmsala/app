<?php

use app\modules\solicitudprevios\models\Detallesolicitudext;
use kartik\date\DatePicker;
use kartik\detail\DetailView;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\time\TimePicker;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->title = $turno->nombre;

$this->params['sidebar'] = [
    'visible' => false,
    
];

/* @var $this yii\web\View */
/* @var $model app\models\Mesaexamen */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
        $breadcrumbs = [];
        $breadcrumbs [] = ['label' => $turno->nombre];
        //$breadcrumbs [] = $this->title;

    ?>


    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => '< Volver', 'url' => ['/turnoexamen']],
        'links' => $breadcrumbs,
    ]) ?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalcasoupdate',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>

<div class="mesaexamen-form">

<h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/turnoexamen/view', [
            'model' => $turno,
    ]) ?>
<?php
    if(count($materiasdisponibles)>0){
?>
    <?php $form = ActiveForm::begin([
    'id' => 'login-form', 
    'type' => ActiveForm::TYPE_HORIZONTAL,
    
]); ?>

    <?= $form->field($modelAxM, 'actividad')->checkboxList($materiasdisponibles); ?>

    <center><div class="form-group">
        <?= Html::submitButton('Generar mesa', ['class' => 'btn btn-success']) ?>
    </div></center>

    <?php ActiveForm::end(); ?>

    <?php
    }
?>

    <?php

    if($mesas->getTotalCount()>0){
        echo '<h3>Mesas: Revisión superposición interna</h3>';
    }
     $max = 0;
     //var_dump($mesas->getModels());
     
     foreach ($mesas->getModels() as $mesa) {

        $salida = '<ul>';
        $superposision = false;
        if($mesa->fecha != null && $mesa->hora != null){
            if($mesa->repetidos == "Sin inscripciones"){
                $salida = "Sin inscripciones";
                $tipopanel = DetailView::TYPE_DEFAULT;
            }else{
                foreach ($mesa->repetidos as $key => $detalle) {
                    # code...
                    $det = Detallesolicitudext::findOne($key);
                    $salida .= '<li>'.$det->solicitud0->apellido.', '.$det->solicitud0->nombre.'</li>';
        
                    //$mesas = array_column($detalle,'0');
                    $salida .= '<ul>';
                    foreach ($detalle as $mesaX) {
                        //return var_dump($mesa);
                        try {
                            $salida .= '<li>Mesa #'.$mesaX->id.'</li>';
                            $superposision = true;
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                            
                        
                    }
                    $salida .= '</ul>';
                }
                $salida .= '</ul>';

                if($superposision){
                    $tipopanel = DetailView::TYPE_DANGER;
                }else{
                    $tipopanel = DetailView::TYPE_SUCCESS;
                    $salida = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                }
            }
        }

        $salida2 = '<ul>';
        $superposision2 = false;
        
        foreach ($mesa->repetidosinternos as $key => $detalle2) {
            # code...
            $det2 = Detallesolicitudext::findOne($key);
            $salida2 .= '<li>'.$det2->solicitud0->apellido.', '.$det2->solicitud0->nombre.'</li>';

            //$mesas = array_column($detalle,'0');
            $salida2 .= '<ul>';
            foreach ($detalle2 as $actividadX2) {
                //return var_dump($mesa);
                try {
                    $salida2 .= '<li>'.$actividadX2->actividad0->nombre.'</li>';
                    $superposision2 = true;
                    
                } catch (\Throwable $th) {
                    //throw $th;
                }
                    
                
            }
            $salida2 .= '</ul>';
        }

        if($mesa->fecha == null || $mesa->hora == null){
            $tipopanel = DetailView::TYPE_PRIMARY;
        }

        if($superposision2){
            $tipopanel = DetailView::TYPE_DANGER;
        }
        

        
                        

         //if(count($mesa->actividads)+count($mesa->repetidos)>$max)
            //$max = count($mesa->actividads)+count($mesa->repetidos);
        echo '<div class="col-md-2">';
        //echo use 
        //echo var_dump($mesa->id);


        
        echo DetailView::widget([
            'model'=>$mesa,
            'condensed'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'enableEditMode' => false,
            'panel'=>[
                'heading'=>'Mesa #'.$mesa->id,
                'headingOptions' => [
                    'template' => '',
                ],
                'type'=>$tipopanel,
            ],
            'attributes'=>[
                [
                    'columns' => [
                        [
                            'label'=>'Fecha y hora',
                            'format'=>'raw',
                            'value' => function($model) use($mesa){
                                if($mesa->fecha == null){
                                    return Html::button('Modificar mesa', ['value' => Url::to(['update', 'id' => $mesa->id]), 'title' => 'Modificar mesa de examen'.' #'.$mesa->id, 'class' => 'btn btn-link amodalcasoupdate']);
                                }
                                date_default_timezone_set('America/Argentina/Buenos_Aires');
                                $fecha = Yii::$app->formatter->asDate($mesa->fecha, 'dd/MM/yyyy');

                                if($mesa->hora != null){
                                    $hora = explode(':', $mesa->hora);
                                    $salida = $fecha.' - '.$hora[0].':'.$hora[1].'hs.';
                                }else{
                                    $salida = $fecha;
                                }

                                if($mesa->fecha<$mesa->turnoexamen0->desde || $mesa->fecha>$mesa->turnoexamen0->hasta)
                                    $salida = $salida.' <span style="color:red" class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>';

                                
                                
                                return Html::button($salida, ['value' => Url::to(['update', 'id' => $mesa->id]), 'title' => 'Modificar mesa de examen'.' #'.$mesa->id, 'class' => 'btn btn-link amodalcasoupdate']);
                            }
                            
                        ],
                        
                    ],
                ],
                //'turnohorario',
                [
                    'label' => 'Materias',
                    'format' => 'raw',
                    'value' => function($model) use ($mesa, $solicitudesTodas){
                        //return var_dump($solicitudesTodas);
                        $salida = '<ul>';
                        foreach ($mesa->actividads as $actividad) {
                            try {
                                $salida .= '<li>'.$actividad->nombre.'<b> - Inscriptos: '.Html::button($solicitudesTodas[$actividad->id], ['value' => Url::to(['/solicitudprevios/detallesolicitudext/pormateria', 'turno' => $mesa->turnoexamen, 'actividad' => $actividad->id]), 'title' => 'Inscriptos en la materia '.$actividad->nombre, 'class' => 'btn btn-link amodalcasoupdate']).'</b></li>';
                            } catch (\Throwable $th) {
                                $salida .= '<li>'.$actividad->nombre.'</li>';
                            }
                            
                        }
                        $salida .= '</ul>';
                        return $salida;
                    }
                ],
                /*[
                    'label' => 'Superposición'.'<br /> <center><span style="color:red" class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span></center>',
                    'format' => 'raw',
                    'visible' => $superposision,
                    'value' => function($model) use ($salida){
                        return $salida;
                        //return var_dump($mesa->repetidos);
                        

                        /*$salida = '<ul>';
                        foreach ($mesa->repetidos as $actividad) {
                            try {
                                $salida .= '<li>'.$actividad->apellido.', '.$actividad->nombre.' ('.$actividad->mail.')</li>';
                            } catch (\Throwable $th) {
                                //throw $th;
                            }
                            
                        }
                        $salida .= '</ul>';
                        return $salida;
                    }
                ]*/
                [
                    'label' => '<center>Superposición interna'.'<br /><span style="color:red" class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span></center>',
                    'format' => 'raw',
                    'visible' => $superposision2,
                    'value' => function($model) use ($salida2){
                        return $salida2;
                        
                    }
                ],
            ]
        ]);
        echo '</div>';
    }

    ?>

    <div class="clearfix"></div>
    <?php
        echo Html::a('Siguiente >', Url::to(['paso3', 'turno' => $turno->id]), ['class' => 'btn btn-primary pull-right']);
    ?>

</div>
