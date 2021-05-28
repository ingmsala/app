<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NovedadesestudianteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Becas';


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

<div class="becas-index">

<?php 
        $breadcrumbs = [];
        $breadcrumbs [] = [
            'label' => 'Paso 2: Grupo familiar',
            'url' => ['grupofamiliar', 's' => $token],
            'template' => "<li><span class=\"becapasoinactivo\">{link}</span></li>\n"
        ];
        $breadcrumbs [] = [
            'label' => 'Paso 3: Finalizar y enviar',
            'url' => ['finalizar', 's' => $token],
            'template' => "<li><b><u>{link}</u></b></li>\n"
        ];
        //$breadcrumbs [] = $this->title;

    ?>


    <?= Breadcrumbs::widget([
        'options' => ['class' => 'breadcrumb breadcrumbsbeca novisible'],
        'homeLink' => [
                'label' => 'Paso 1: Solicitud', 'url' => ['solicitud', 's' => $token], 
                'template' => "<li><span class=\"becapasoinactivo\">{link}</span></li>\n"
        
        ],
        'links' => $breadcrumbs,
    ]) ?>

<h1>Solicitud de becas</h1>

    <?= $echosalidasol ?>
    <div class="salto"></div>
    <h2>Grupo familiar conviviente con el/la estudiante</h2>  
    <?= $echosalidaflia ?>   
    <div style="margin-top:20px; border: 0.5px solid #ccc; padding:1%;border-radius: 5px;">
    La presente infromación tiene carácter de DECLARACIÓN JURADA.-<br>

    

				LUGAR Y FECHA: Córdoba, <?php
					date_default_timezone_set('America/Argentina/Buenos_Aires');
					$meses = [ '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12=> 'Diciembre',];
					setlocale(LC_TIME, "es_ES");
					echo Yii::$app->formatter->asDate(date('Y-m-d'), 'dd').' de '.$meses[date('m')].' de '.strftime("%Y");
				?>
				
			
    </div>   
    <div class="pull-right" style="margin-top:20px;">

    
    

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'action' =>Url::to(['/becas/default/finalizaryenviar', 's' =>$token])]) ?>
            
            <div class="form-group">
                
                <div class="pull-right"><?= ($solicitud->estado <=2 || $solicitud->convocatoria0->becaconvocatoriaestado == 2) ? Html::submitButton('Aceptar y enviar', ['class' => 'btn btn-primary', 'data-confirm' => 'Está seguro que desea finalizar el trámite y enviarlo?']) : '' ?></div>
                <div class="pull-right">&nbsp;</div>
                <div class="pull-right">
                    <?= Html::a('< Anterior', ['grupofamiliar', 's' => $token], ['class' => 'btn btn-success']) ?>
                </div>
                
            </div>
    <?php ActiveForm::end(); ?>

    </div>

</div>