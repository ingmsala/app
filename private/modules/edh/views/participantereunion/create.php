<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Participantereunion */

$this->title = 'Create Participantereunion';
$this->params['breadcrumbs'][] = ['label' => 'Participantereunions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participantereunion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
