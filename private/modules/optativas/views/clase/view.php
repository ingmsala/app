<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Clase */
date_default_timezone_set('America/Argentina/Buenos_Aires');
$this->title = Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy').' - Comisión: '.$model->comision0->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Clases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clase-view">

    <h2><?= Html::encode($this->title) ?></h2>

   <?= $this->render('/matricula/_alumnosxcomision', [
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        'clase' => $model->id,
        'inasistenciasdeldia' => $inasistenciasdeldia,
        'alumnosdecomsion' => $alumnosdecomsion,
        
    ]) ?>

</div>
