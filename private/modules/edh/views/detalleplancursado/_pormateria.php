<?php

use app\models\Catedra;
use app\modules\edh\models\SeguimientodetplanSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Detalleplancursado */

$searchModelSeguimiento = new SeguimientodetplanSearch();
$dataProviderSeguimiento = $searchModelSeguimiento->porDetalle($model->id);
$docente = new Catedra();
$docente = $docente->docenteHorario($model->catedra, $model->plan0->caso0->matricula0->aniolectivo);

if($model->plan0->tipoplan == 1){
    $col = 8;
    $coli = 4;
    $visible = true;
}else{
    $col = 12;
    $visible = false;
}

\yii\web\YiiAsset::register($this);
?>
<div class="detalleplancursado-view">

    <div class="row">
        <div class="col-md-12">
            <?= 
                '<b>Docente:</b> '.$docente;
            ?>
        </div>
        <br />
        <br />
    </div>
    <div class="btn-group" role="group" aria-label="...">
        <?php if($visible) echo Html::button('<span class="glyphicon glyphicon-list-alt"></span> '.'Ver notas', ['value' => Url::to(['/edh/notaedh/viewlegajo', 'det' =>$model->id]), 'title' => 'Notas de '.$model->catedra0->actividad0->nombre,  'class' => 'btn btn-default amodalplancursado']); ?>
        <?=Html::button('<span class="glyphicon glyphicon-plus"></span> '.'Nuevo seguimiento', ['value' => Url::to(['/edh/seguimientodetplan/create', 'det' =>$model->id]), 'title' => 'Nuevo seguimiento de '.$model->catedra0->actividad0->nombre,  'class' => 'btn btn-default amodalplancursado']); ?>
        <?php if($visible) echo Html::button('<span class="glyphicon glyphicon-tasks"></span> '.'Realizar pronóstico', ['value' => Url::to(['/edh/notaedh/viewlegajo', 'det' =>$model->id]), 'title' => 'Notas de '.$model->catedra0->actividad0->nombre,  'class' => 'btn btn-default amodalplancursado']); ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= 
                $model->descripcion;
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-<?=$col?>">
            <?= $this->render('/seguimientodetplan/index', [
                'model' => $model,
                'det' => $model->id,
                'searchModel' => $searchModelSeguimiento,
                'dataProvider' => $dataProviderSeguimiento,
            ]) ?>
        </div>
        <?php if($visible){ ?>
        <div class="col-md-<?=$coli?>">
            <div class="panel panel-warning">
                <div class="panel-heading">Reporte inferencial</div>
                <div class="panel-body">
                    <ul>
                        <li>Aprobado <span class="label label-success">80%</span></li>
                        <li>Rinde diciembre <span class="label label-warning">15%</span></li>
                        <li>Rinde marzo <span class="label label-danger">5%</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    

</div>
