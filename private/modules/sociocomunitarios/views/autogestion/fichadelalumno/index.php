<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Matricula */

$this->title = 'Ficha del alumno';

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
            	'label' => 'Alumno',
            	'value' => function($matricula){
            		return $matricula->alumno0->apellido.', '.$matricula->alumno0->nombre;
            	}
            ],
            [
            	'label' => 'Espacio Optativo',
            	'value' => function($matricula){
            		return $matricula->comision0->espaciocurricular0->actividad0->nombre.'   |   Comisión: '.$matricula->comision0->nombre;
            	}
            ],

            [
            	'label' => 'Profesores/as',
            	'format' => 'raw',
            	'value' => function($matricula){
            		$items = [];
            		$docentes = $matricula->comision0->docentexcomisions;

            		foreach ($docentes as $docente) {
            			if($docente->role == 8)
            				$item[] = [$docente->docente0->apellido, $docente->docente0->nombre];
            		}
            		return Html::ul($item, ['item' => function($item) {
	            			 return 
	                                    Html::tag('li', $item[0].', '.$item[1]);
	            		
            		}]);
            	}
            ],

            [
            	'label' => 'Duración',
            	'value' => function($matricula){
            		return $matricula->comision0->espaciocurricular0->duracion.' horas';
            	}
            ],
            
            'comision0.espaciocurricular0.aniolectivo0.nombre',

            [
            	'label' => 'Estado',
            	'attribute' => 'estadomatricula0.nombre',
            ]
        ],
    ]) ?>

    <h3><?= Html::encode('Asistencia') ?></h3>

        <?= $this->render('/reportes/fichadelalumno/_inasistenciasxalumno', [
            'dataProviderInasistencias' => $dataProviderInasistencias,
            'listClasescomision' => $listClasescomision,
             'echodiv' => $echodiv,
            
        ]) ?>

    <div class="clearfix"></div>

    <h3><?= Html::encode('Evaluación de Seguimiento') ?></h3>

        <?= $this->render('/reportes/fichadelalumno/_seguimientosxalumno', [
            'dataProviderSeguimientos' => $dataProviderSeguimientos,
            
            
        ]) ?>

    

</div>