<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Estadonovedad */

$this->title = 'Create Estadonovedad';
$this->params['breadcrumbs'][] = ['label' => 'Estadonovedads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadonovedad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
