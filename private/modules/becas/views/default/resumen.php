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
        $breadcrumbs [] = ['label' => ''];
        //$breadcrumbs [] = $this->title;

    ?>


    <?= Breadcrumbs::widget([
        'options' => ['class' => 'breadcrumb novisible'],
        'homeLink' => ['label' => '< Volver', 'url' => ['/becas/becasolicitud/index', 'convocatoria' => $solicitud->convocatoria], ],
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

    

    </div>

</div>