<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Agente */

$this->title = 'Nuevo Agente';
$this->params['breadcrumbs'][] = ['label' => 'Agentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agente-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'generos' => $generos,
        'tipodocumento' => $tipodocumento,
        'tipocargo' => $tipocargo,
        'origen' => 'create',
    ]) ?>

</div>
