<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Falta */

$this->title = 'Create Falta';
$this->params['breadcrumbs'][] = ['label' => 'Faltas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="falta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
