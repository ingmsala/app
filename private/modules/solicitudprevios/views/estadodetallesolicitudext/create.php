<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\solicitudprevios\models\Estadodetallesolicitudext */

$this->title = 'Create Estadodetallesolicitudext';
$this->params['breadcrumbs'][] = ['label' => 'Estadodetallesolicitudexts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadodetallesolicitudext-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
