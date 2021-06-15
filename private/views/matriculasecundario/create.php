<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Matriculasecundario */

$this->title = 'Create Matriculasecundario';
$this->params['breadcrumbs'][] = ['label' => 'Matriculasecundarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="matriculasecundario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
