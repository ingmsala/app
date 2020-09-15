<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Turnoexamen */

$this->title = 'Nuevo Turnoexamen';
$this->params['breadcrumbs'][] = ['label' => 'Turnoexamens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turnoexamen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
