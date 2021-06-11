<?php

use kartik\detail\DetailView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Matricula */

$this->title = 'Ficha del estudiante';

?>
<div class="matricula-view">
    <center>
        <div id="encabezado">
            <img src="assets/images/logo-encabezado.png" />
        </div>
    </center>

    <h3><?= Html::encode($this->title) ?></h3>
    
    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            [
            	'label' => 'Estudiante',
            	'value' => $model->alumno0->apellido.', '.$model->alumno0->nombre
            	
            ],
            [
                'columns' => 
                    [
                        [
                            'label' => 'Espacio Curricular',
                            'value' => $model->comision0->espaciocurricular0->actividad0->nombre
                                
                        ],
                        [
                            'label' => 'Comisión',
                            'value' => $model->comision0->nombre
                                
                        ],
                    ]
            ],

            [
            	'label' => 'Docentes',
            	'format' => 'raw',
            	'value' => function() use($model) {
            		$items = [];
            		$docentes = $model->comision0->docentexcomisions;

            		foreach ($docentes as $agente) {
            			if($agente->role == 8)
            				$item[] = [$agente->agente0->apellido, $agente->agente0->nombre];
            		}
            		return Html::ul($item, ['item' => function($item) {
	            			 return 
	                                    Html::tag('li', $item[0].', '.$item[1]);
	            		
            		}]);
            	}
            ],
            [
                'columns' => 
                    [
                        [
                            'label' => 'Acredita',
                            //'attribute'=>'fecha',
                            'value' => $model->comision0->espaciocurricular0->duracion.' horas'
                        ],
                        
                        [
                            'label' => 'Año lectivo',
                            'format' => 'raw',
                            'value' => $model->comision0->espaciocurricular0->aniolectivo0->nombre,
                        ],

                        [
                            'label' => 'Condición',
                            'attribute' => 'id',
                            'value' => $model->estadomatricula0->nombre
                        ],
                    
                    ],
            ],
            
        ],
    ]) ?>

    <h3><?= Html::encode('Asistencia') ?></h3>

        <?= $this->render('/reportes/fichadelalumno/_inasistenciasxalumno', [
            'dataProviderInasistencias' => $dataProviderInasistencias,
            'listClasescomision' => $listClasescomision,
             'echodiv' => $echodiv,
             'dataProvider' => $dataProvider,
             'matricula' => $model->id,
            
        ]) ?>

    <div class="clearfix"></div>

    <h3><?= Html::encode('Actividades') ?></h3>

        <?= $this->render('/reportes/fichadelalumno/_actividadesxalumno', [
            'dataProviderDetalleactividad' => $dataProviderDetalleactividad,
            
        ]) ?>

    <div class="clearfix"></div>

    <h3><?= Html::encode('Evaluación de Seguimiento') ?></h3>

        <?= $this->render('/reportes/fichadelalumno/_seguimientosxalumno', [
            'dataProviderSeguimientos' => $dataProviderSeguimientos,
            
            
        ]) ?>

    

</div>