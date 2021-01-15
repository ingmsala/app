<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Informeprofesional */

$this->title = 'Create Informeprofesional';
$this->params['breadcrumbs'][] = ['label' => 'Informeprofesionals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informeprofesional-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
