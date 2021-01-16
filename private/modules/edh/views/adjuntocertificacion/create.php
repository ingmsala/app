<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Adjuntocertificacion */

$this->title = 'Create Adjuntocertificacion';
$this->params['breadcrumbs'][] = ['label' => 'Adjuntocertificacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adjuntocertificacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
