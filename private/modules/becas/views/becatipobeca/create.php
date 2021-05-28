<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becatipobeca */

$this->title = 'Create Becatipobeca';
$this->params['breadcrumbs'][] = ['label' => 'Becatipobecas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="becatipobeca-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
