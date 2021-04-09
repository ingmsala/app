<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Clasediaria */

$this->title = 'Modificar Clase diaria';
?>

<?php 
        $breadcrumbs = [];
        $breadcrumbs [] = ['label' => ''];
        //$breadcrumbs [] = $this->title;

    ?>


    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => '< Volver', 'url' => ['catedra', 'cat' => $catedra->id]],
        'links' => $breadcrumbs,
    ]) ?>

<div class="clasediaria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form',
     [
        'model' => $model,
        'modelhxc' => $modelhxc,
        'modelidadesclase' => $modelidadesclase,
        'unidades' => $unidades,
        'horas' => $horas,
        'actividad' => $catedra->actividad,
        'imputstemas' => $imputstemas,
        'tiposcurricula' => $tiposcurricula,
        'horasaj' => $horasaj,
        'divselecc' => $divselecc,

    ]) ?>

</div>
