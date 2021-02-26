<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mesaexamen */

$this->title = 'Modificar Mesaexamen: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mesaexamens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="mesaexamen-update">

    <?php
        if($origen == 'noajax'){
            echo '<h1>'.Html::encode($this->title).'</h1>';
        }
    ?>
<div class="pull-right">
<?= Html::a('Eliminar', ['delete', 'id' => $model->id, 'or'=>$or], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar el elemento?',
                'method' => 'post',
            ],
        ]) ?>
  </div>
  <div class="clearfix"></div>  
    <?= $this->render('_form', [
        'model' => $model,
        'turnosexamen' => $turnosexamen,
        'espacios' => $espacios,
        'docentes' => $docentes,
        'actividades' => $actividades,
        'actividadesxmesa' => $actividadesxmesa,
        'tribunal' => $tribunal,
        'doce' => $doce,
        'or' => 'u',
    ]) ?>

</div>
