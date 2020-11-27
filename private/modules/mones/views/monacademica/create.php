<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\mones\models\Monacademica */

$this->title = 'Nuevo Monacademica';
$this->params['breadcrumbs'][] = ['label' => 'Monacademicas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monacademica-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
