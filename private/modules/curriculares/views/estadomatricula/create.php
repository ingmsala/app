<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Estadomatricula */

$this->title = 'Nuevo Estado de Matrícula';
$this->params['breadcrumbs'][] = ['label' => 'Estado de Matrícula', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadomatricula-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
