<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\solicitudprevios\models\Adjuntosolicitudext */

$this->title = 'Create Adjuntosolicitudext';
$this->params['breadcrumbs'][] = ['label' => 'Adjuntosolicitudexts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adjuntosolicitudext-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
