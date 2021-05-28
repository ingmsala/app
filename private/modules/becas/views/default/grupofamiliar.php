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

<div class="becas-grupofliar">

<?php 
        $breadcrumbs = [];
        $breadcrumbs [] = [
            'label' => 'Paso 2: Grupo familiar',
            'url' => ['grupofamiliar', 's' => $token],
            'template' => "<li><b><u>{link}</u></b></li>\n"
        ];
        $breadcrumbs [] = [
            'label' => 'Paso 3: Finalizar y enviar',
            'url' => ['finalizar', 's' => $token],
            'template' => "<li><span class=\"becapasoinactivo\">{link}</span></li>\n"
        ];
        //$breadcrumbs [] = $this->title;

    ?>


    <?= Breadcrumbs::widget([
        'options' => ['class' => 'breadcrumb breadcrumbsbeca'],
        'homeLink' => [
                'label' => 'Paso 1: Solicitud', 'url' => ['solicitud', 's' => $token], 
                'template' => "<li><span class=\"becapasoinactivo\">{link}</span></li>\n"
        
        ],
        'links' => $breadcrumbs,
    ]) ?>

<h1>Grupo familiar conviviente con el/la estudiante</h1>

<p class="novisible">En esta sección se deben agregar y consignar los datos de todas aquellas personas, sean mayores o menores, que conviven con el/la estudiante (sin incluirlo/la)</p>

<?php
    if($edit)
        echo '<center>'.Html::button('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar conviviente', ['value' => Url::to(['/becas/becaconviviente/create', 's' => $token]), 'title' => 'Agregar conviviente', 'class' => 'btn btn-info amodalgenerico']).'</center>';
?>

<?= $echosalida ?>      
<div class="pull-right" style="margin-top:20px;">

<?= Html::a('< Anterior', ['solicitud', 's' => $token ], ['class' => 'btn btn-success']) ?>
<div class="pull-right">&nbsp;</div>
<?= Html::a('Siguiente >', ['finalizar', 's' => $token], ['class' => 'btn btn-success']) ?>

</div>
</div>