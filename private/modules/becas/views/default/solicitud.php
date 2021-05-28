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

<div id="becas-index">

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
            'template' => "<li><span class=\"becapasoinactivo\">{link}</span></li>\n"
        ];
        //$breadcrumbs [] = $this->title;

    ?>


    <?= Breadcrumbs::widget([
        'options' => ['class' => 'breadcrumb breadcrumbsbeca'],
        'homeLink' => ['label' => 'Paso 1: Solicitud', 'url' => ['index'], 'template' => "<li><b><u>{link}</u></b></li>\n",],
        'links' => $breadcrumbs,
    ]) ?>

<h1>Solicitud de becas</h1>

    <?= $echosalida ?>      
    <div class="pull-right" style="margin-top:20px;">

    
    <?= Html::a('Siguiente >', ['grupofamiliar', 's' => $token], ['class' => 'btn btn-success']) ?>

    </div>

</div>