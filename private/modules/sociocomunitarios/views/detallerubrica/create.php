<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\sociocomunitarios\models\Detallerubrica */

$this->title = 'Nuevo Detallerubrica';
$this->params['breadcrumbs'][] = ['label' => 'Detallerubricas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detallerubrica-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
