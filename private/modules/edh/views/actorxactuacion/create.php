<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Actorxactuacion */

$this->title = 'Create Actorxactuacion';
$this->params['breadcrumbs'][] = ['label' => 'Actorxactuacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actorxactuacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
