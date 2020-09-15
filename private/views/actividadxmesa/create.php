<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Actividadxmesa */

$this->title = 'Nuevo Actividadxmesa';
$this->params['breadcrumbs'][] = ['label' => 'Actividadxmesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actividadxmesa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
