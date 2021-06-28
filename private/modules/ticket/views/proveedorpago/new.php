<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Proveedorpago */

$this->title = 'Nuevo proveedor';
?>
<?php 
        $breadcrumbs = [];
        $breadcrumbs [] = ['label' => $this->title];
        //$breadcrumbs [] = $this->title;

    ?>


    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => '< Volver', 'url' => ['index']],
        'links' => $breadcrumbs,
    ]) ?>
<div class="proveedorpago-create">
<h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
