<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Detalleplancursado */

$this->title = 'Create Detalleplancursado';
$this->params['breadcrumbs'][] = ['label' => 'Detalleplancursados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalleplancursado-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
