<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Matriculaedh */

$this->title = 'Nueva Matricula';
$this->params['breadcrumbs'][] = ['label' => 'Matricula', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="matriculaedh-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'alumnos' => $alumnos,
        'aniolectivos' => $aniolectivos,
        'divisiones' => $divisiones,
    ]) ?>

</div>
