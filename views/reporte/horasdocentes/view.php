<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\DetalleCatedra */

$this->title = $model->id;

?>
<div class="detalle-catedra-view">


        
    <h2>Docente: <?= $model->apellido.', '.$model->nombre; ?> - Total horas: <span class="label label-info">
        <?= $horasCatedraSinCobrarNom->horas + $horasCatedraSinCobrar->id + $horasCatedraACobrarNom->horas + $horasCatedraACobrar->id ?>
    </span></h2>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-success">
              <div class="panel-heading">
                <h3 class="panel-title">Horas activas a cobrar
                    <span class="label label-success">
                        <?= $horasCatedraACobrarNom->horas + $horasCatedraACobrar->id ?>
                    </span>
                </h3>
              </div>
              <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">Horas Cátedra: <?= $horasCatedraACobrar->id ?></li>
                    <li class="list-group-item">Nombramientos: <?= $horasCatedraACobrarNom->horas ?></li>
                   
                </ul>
              </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-danger">
              <div class="panel-heading">
                <h3 class="panel-title">Horas con Lic s/goce
                    <span class="label label-danger">
                        <?= $horasCatedraSinCobrarNom->horas + $horasCatedraSinCobrar->id ?>
                    </span>
                </h3>
              </div>
              <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">Horas Cátedra: <?= $horasCatedraSinCobrar->id ?></li>
                    <li class="list-group-item">Nombramientos: <?= $horasCatedraSinCobrarNom->horas ?></li>
                    <li class="list-group-item">Total: <?= $horasCatedraSinCobrarNom->horas + $horasCatedraSinCobrar->id ?></li>
                </ul>
              </div>
            </div>
        </div>
    </div>

    <h3>Detalle de Horas</h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        
        'columns' => [
            
            
            'id',
            [
                'label' => 'Revista',
                'attribute' => 'revista0.nombre'
            ],
            [
                'label' => 'Actividad',
                'attribute' => 'catedra0.actividad0.nombre'
            ],
            [
                'label' => 'Division',
                'attribute' => 'catedra0.division0.nombre',
                
            ],

            [
                'label' => 'Horas',
                'attribute' => 'catedra0.actividad0.cantHoras',
                
            ],
            

            
        ],
    ]); ?>

    <h3>Detalle de Nombramientos</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProviderNombramientos,
        'filterModel' => $searchModelNombramientos,
        
        'columns' => [
            
            
            
             'id',
            [
                'label' => 'Revista',
                'attribute' => 'revista0.nombre'
            ],
            [
                'label' => 'Cargo',
                'attribute' => 'cargo0.nombre'
            ],

            [
                'label' => 'Función',
                'attribute' => 'nombre',
                
            ],

            [
                'label' => 'Division',
                'attribute' => 'division0.nombre',
                
            ],

            [
                'label' => 'Horas',
                'attribute' => 'horas',
                
            ],
            

            
        ],
    ]); ?>

</div>