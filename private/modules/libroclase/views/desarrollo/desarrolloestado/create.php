<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\desarrollo\Desarrolloestado */

$this->title = 'Create Desarrolloestado';
$this->params['breadcrumbs'][] = ['label' => 'Desarrolloestados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="desarrolloestado-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
