<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Grupotrabajoticket */

$this->title = 'Agregar agente';
$this->params['breadcrumbs'][] = ['label' => 'Grupotrabajotickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupotrabajoticket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'agentes' => $agentes,
        'areas' => $areas,
    ]) ?>

</div>
