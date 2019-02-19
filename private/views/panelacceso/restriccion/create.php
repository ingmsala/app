<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Restriccion */

$this->title = 'Create Restriccion';
$this->params['breadcrumbs'][] = ['label' => 'Restriccions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restriccion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
