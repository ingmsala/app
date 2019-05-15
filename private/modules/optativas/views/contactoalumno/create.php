<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Contactoalumno */

$this->title = 'Create Contactoalumno';
$this->params['breadcrumbs'][] = ['label' => 'Contactoalumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contactoalumno-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
