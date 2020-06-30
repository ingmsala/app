<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Funciondj */

$this->title = 'Nuevo Funciondj';
$this->params['breadcrumbs'][] = ['label' => 'Funciondjs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="funciondj-create">

    <?= $this->render('_form', [
        'model' => $model,
        'reparticiones' => $reparticiones,
    ]) ?>

</div>
