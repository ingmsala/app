<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\sociocomunitarios\models\Presentacionactpsc */

$this->title = 'Create Presentacionactpsc';
$this->params['breadcrumbs'][] = ['label' => 'Presentacionactpscs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Presentacionactpsc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
