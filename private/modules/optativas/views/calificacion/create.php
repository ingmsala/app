<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Calificacion */

$this->title = 'Create Calificacion';
$this->params['breadcrumbs'][] = ['label' => 'Calificacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calificacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
