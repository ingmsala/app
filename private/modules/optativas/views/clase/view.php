<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Clase */
date_default_timezone_set('America/Argentina/Buenos_Aires');
$this->title = Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy').' - Comisión: '.$model->comision0->nombre;

?>
<div class="clase-view">

    <h2><?= Html::encode($this->title) ?></h2>

   <?= $this->render('/matricula/_alumnosxcomision', [
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        'clase' => $model->id,
        'inasistenciasdeldia' => $inasistenciasdeldia,
        'alumnosdecomision' => $alumnosdecomision,
        'alumnosdecomisionprueba' => $alumnosdecomisionprueba,
        'listtardanzasdeldia' => $listtardanzasdeldia,
        'echodiv' => $echodiv,
        
    ]) ?>

    
</div>
