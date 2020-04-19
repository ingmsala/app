<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Semana */

$this->title = 'Nuevo Semana';
$this->params['breadcrumbs'][] = ['label' => 'Semanas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semana-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'aniolectivo' => $aniolectivo,
        'publicado' => $publicado,
    ]) ?>

</div>
