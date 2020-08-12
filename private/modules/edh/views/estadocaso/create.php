<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Estadocaso */

$this->title = 'Nuevo Estadocaso';
$this->params['breadcrumbs'][] = ['label' => 'Estadocasos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadocaso-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
