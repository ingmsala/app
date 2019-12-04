<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Nodocente */

$this->title = 'Nuevo Nodocente';
$this->params['breadcrumbs'][] = ['label' => 'Nodocentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nodocente-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'generos' => $generos,
    ]) ?>

</div>
