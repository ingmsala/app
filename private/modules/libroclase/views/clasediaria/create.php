<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Clasediaria */


$this->params['breadcrumbs'][] = ['label' => 'Clasediarias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <?php 
        $breadcrumbs = [];
        $breadcrumbs [] = ['label' => 'Libro de aula'];
        //$breadcrumbs [] = $this->title;

    ?>


    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => '< Volver', 'url' => ['catedra', 'cat' => $catedra->id]],
        'links' => $breadcrumbs,
    ]) ?>
<div class="clasediaria-create">

    

    <h3><?= Html::encode('Nueva Clase: '.$catedra->division0->nombre.' - '.$catedra->actividad0->nombre) ?></h3>

    <?= $this->render('_form',
     [
        'model' => $model,
        'modelhxc' => $modelhxc,
        'modelidadesclase' => $modelidadesclase,
        'unidades' => $unidades,
        'horas' => $horas,
        'horasaj' => $horasaj,
        'tiposcurricula' => $tiposcurricula,
        'actividad' => $catedra->actividad,

    ]) ?>

</div>
