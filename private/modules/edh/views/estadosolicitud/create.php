<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Estadosolicitud */

$this->title = 'Nuevo Estado de solicitud';
$this->params['breadcrumbs'][] = ['label' => 'Estado solicitud', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadosolicitud-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
