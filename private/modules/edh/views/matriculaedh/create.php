<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Matriculaedh */

$this->title = 'Create Matriculaedh';
$this->params['breadcrumbs'][] = ['label' => 'Matriculaedhs', 'url' => ['index']];
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
