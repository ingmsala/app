<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Hora */

$this->title = 'Create Hora';
$this->params['breadcrumbs'][] = ['label' => 'Horas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hora-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
