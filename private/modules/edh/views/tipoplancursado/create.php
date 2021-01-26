<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Tipoplancursado */

$this->title = 'Create Tipoplancursado';
$this->params['breadcrumbs'][] = ['label' => 'Tipoplancursados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipoplancursado-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
