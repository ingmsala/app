<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\sociocomunitarios\models\Presentacionactivpsc */

$this->title = 'Create Presentacionactivpsc';
$this->params['breadcrumbs'][] = ['label' => 'Presentacionactivpscs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="presentacionactivpsc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
