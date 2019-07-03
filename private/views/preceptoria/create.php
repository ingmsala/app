<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Preceptoria */

$this->title = 'Create Preceptoria';
$this->params['breadcrumbs'][] = ['label' => 'Preceptorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preceptoria-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'turnos' => $turnos,
    ]) ?>

</div>
