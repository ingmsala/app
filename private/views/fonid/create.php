<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Fonid */

$this->title = 'Nuevo Fonid';
$this->params['breadcrumbs'][] = ['label' => 'Fonids', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fonid-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => $dataProvider,
        'fonid' => $fonid,
        'docente' => $docente,
    ]) ?>

</div>
