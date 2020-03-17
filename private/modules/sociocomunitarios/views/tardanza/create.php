<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Tardanza */

$this->title = 'Nuevo Tardanza';
$this->params['breadcrumbs'][] = ['label' => 'Tardanzas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tardanza-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
