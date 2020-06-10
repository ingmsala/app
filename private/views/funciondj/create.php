<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Funciondj */

$this->title = 'Nuevo Funciondj';
$this->params['breadcrumbs'][] = ['label' => 'Funciondjs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="funciondj-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'reparticiones' => $reparticiones,
    ]) ?>

</div>
