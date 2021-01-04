<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Grupotrabajoticket */

$this->title = 'Modificar agente';

$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="grupotrabajoticket-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'agentes' => $agentes,
        'areas' => $areas,
    ]) ?>

</div>
