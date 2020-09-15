<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Modalidadclase */

$this->title = 'Nuevo Modalidadclase';
$this->params['breadcrumbs'][] = ['label' => 'Modalidadclases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modalidadclase-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>