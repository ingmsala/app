<?php


use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Semana */

$this->title = 'Administrar semana';
$this->params['breadcrumbs'][] = ['label' => 'Semanas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalgenerico',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>

<?php 
    $turnos=ArrayHelper::map($turnos,'id','nombre'); 
    $horas=ArrayHelper::map($horas,'id','nombre'); 

?>
<div class="semana-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div  class="pull-left">
		<?php 
		if($sema != null){
			$sema = $sema->id;
			echo  '<a class = "btn btn-default" href="index.php?r=semana/view&id='.$sema.'"><center><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><br />Semana anterior</center></a>';
		
		}else
		echo  '<a class = "btn btn-default" href="#"><center><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span><br />Semana anterior</center></a>';

			
		
			?>
    </div>

    <div  class="pull-left">
		<?php 
			if($semn != null){
				$semn = $semn->id;
			echo  '<a class = "btn btn-default" href="index.php?r=semana/view&id='.$semn.'"><center><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span><br />Semana siguiente	</center></a>';
		
			}else
			echo  '<a class = "btn btn-default" href="#"><center><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span><br />Semana siguiente	</center></a>';

				?>
    </div> 

    <div class="clearfix"></div>
    <br />

    <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    
                    [
                        'label' => 'Semana',
                        'value' => function($model){
                            date_default_timezone_set('America/Argentina/Buenos_Aires');
                            return Yii::$app->formatter->asDate($model->inicio, 'dd/MM/yyyy').' al '.Yii::$app->formatter->asDate($model->fin, 'dd/MM/yyyy');
                        }
                    ],
                                        
                    [
                        'label' => 'Tipo',
                        'format' => 'raw',
                        'value' => function($model) use ($anio, $turno){

                            try {
                                $lbl = $model->tiposemana0->nombre;
                            } catch (\Throwable $th) {
                                $lbl = 'Cambiar';
                            }
                            
                            

                            return Html::a($lbl, Url::to(['cambiartipo', 'semana' => $model->id]), [
                                'class' => 'btn btn-link',
                                'data' => [
                                    'confirm' => 'Está seguro que desea cambiar el tipo de semana?',
                                    'method' => 'post',
                                ],
                                ]);
                            
                        }
                    ],
                    [
                        'label' => 'Publicada',
                        'format' => 'raw',
                        'value' => function($model) use ($anio, $turno){
                            if($model->publicada == 0){
                                $lbl = 'Publicar';
                                $lbl2 = 'Hacer privado';
                                $est = 'No';
                            }
                            else{
                                $lbl = 'Hacer privado';
                                $lbl2 = 'Publicar';
                                $est = 'Sí';
                            }

                            return '<span class="badge">'.$est.'</span> '.Html::a($lbl, Url::to(['publicar', 'semana' => $model->id]), [
                                'class' => 'btn btn-link',
                                'data' => [
                                    'confirm' => 'Está seguro que desea <b>'.$lbl2.'</b> el horario de la semana?',
                                    'method' => 'post',
                                ],
                                ]);
                            
                        }
                    ],
                ],
            ]) ?>
    

    <ul class="nav nav-tabs">
          <li <?=$p1?>><a data-toggle="tab" href="#admin">Operar por año</a></li>
          <li <?=$p2?>><a data-toggle="tab" href="#detalle">Detalle semanal</a></li>
          <li <?=$p3?>><a data-toggle="tab" href="#masivo">Operar masivamente</a></li>
          <li <?=$p4?>><a data-toggle="tab" href="#copiar">Copiar desde semana</a></li>
          
    </ul>

    <div class="tab-content">
            <div id="admin" class="tab-pane fade <?=$fade1?>">

            

            <?php
            if($edit){

            ?>

            <?php $form = ActiveForm::begin(['method' => 'POST', 'id' => 'form-semana']); ?>

            <?php

            echo FormGrid::widget([
                    
            'model'=>$modelHorareloj,
            'form'=>$form,
            'autoGenerateColumns'=>true,
            'rows'=>[
                [
                    //'contentBefore'=>'<legend class="text-info"><small>1</small></legend>',
                    'attributes'=>[       // 2 column layout
                        'anio'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            
                            'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=>[
                                'data'=>$anios,
                                'options' => [
                                    'placeholder' => 'Seleccionar...', 
                                    'id' => 'aniolectivo_id', 
                                    'onchange'=>'
                                    
                                        $.get("index.php?r=horariogenerico/horareloj/porsemana&semana='.$modelHorareloj->semana.'&turno="+$( "select#turnos-id" ).val()+"&anio="+$(this).val(), function( data ) {
                                            $( "div#horas-reloj" ).html( data );
                                        
                                        });
                                    
                                    '
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    
                                ],
                            ], 
                        ],
                        'turno'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=>[
                                'data'=>$turnos,
                                'options' => [
                                    'placeholder' => 'Seleccionar...', 
                                    'id' => 'turnos-id', 
                                    'onchange'=>'
                                
                                        
                                        $.get("index.php?r=horariogenerico/horareloj/porsemana&semana='.$modelHorareloj->semana.'&turno="+$(this).val()+"&anio="+$( "select#aniolectivo_id" ).val(), function( data ) {
                                            $( "div#horas-reloj" ).html( data );
                                        
                                        });
                                    
                                    '
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    
                                ],
                            ],
                        ],
                        
                    ]
                ],

                [
                    
                    'attributes'=>[       // 2 column layout
                        
                        'hora'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            
                            'widgetClass'=>'\kartik\select2\Select2', 
                            'options'=>['data'=>$horas,
                            'options' => [
                                'placeholder' => '...',
                                'multiple' => true,
                            ],
                            ], 
                        ],

                    ]
                ],

            ]

            ]);


            ?>




            <div class="form-group">
                <?= Html::submitButton('Generar horas de clases', ['class' => 'btn btn-success', 'data' => [
                    'confirm' => 'Se generarán las horas habilitadas. ¿Desea proceder?',
                ]]) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <?php
            }
            ?>

            <div id="horas-reloj">
            <?php
                echo $this->render('@app/modules/horariogenerico/views/horareloj/_porsemana', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,

                    'anio' => $anio,
                    'turno' => $turno,
                    'semana' => $semana,
                    'fechas' => $fechas,
                ]);
            ?>

            </div>


        </div>
            <div id="detalle" class="tab-pane fade <?=$fade2?>">
                        <?= $this->render('@app/modules/horariogenerico/views/horariogeneric/reportexsemana', [
                        'searchModel' => $searchModelReportexsemana,
                        'dataProvider' => $dataProviderReportexsemana,
                        
                ]) ?>
            </div>
            <div id="masivo" class="tab-pane fade <?=$fade3?>">
                        <?= $renderMasivos; ?>
            </div>
            <div id="copiar" class="tab-pane fade <?=$fade4?>">
                        <?= $renderCopiarDesde; ?>
            </div>
    </div>

    
    
   
    

</div>
