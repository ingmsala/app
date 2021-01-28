<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Caso */

$this->title = 'Nueva solicitud';
$this->params['breadcrumbs'][] = ['label' => 'Casos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="caso-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelSolicitud' => $modelSolicitud,
        'aniolectivos' => $aniolectivos,
        'areas' => $areas,
    ]) ?>

</div>
