<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Matricula */
try{
                        $al = $model->alumno0->apellido.', '.$model->alumno0->nombre.' ('.$model->division0->nombre.')';
                    }catch(\Exception $e){
                        $al = $model->alumno0->apellido.', '.$model->alumno0->nombre;
                    }
$this->title = 'Ficha del alumno: '.$al;

?>
<div class="fichadelalumnotable">
    <center>
        <div id="encabezado">
            <img src="assets/images/logo-encabezado.png" />
        </div>
    </center>

    <h3><?= Html::encode($this->title) ?></h3>
    <div class="pull-right" style="margin-bottom: 10px;">
        <?php echo Html::a('<span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir', Url::to(['print', 'matricula' => $model->id]), ['class' => 'btn btn-default']) ?>
    </div>
    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            
            [
            	'label' => 'Espacio Curricular',
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
            	'label' => 'Condición',
            	'attribute' => 'estadomatricula0.nombre',
            ]
        ],
    ]) ?>

    <h3><?= Html::encode('Ausencia: (~').$porcentajeausencia.'%)' ?></h3>

        <?= $this->render('_inasistenciasxalumno', [
            'dataProviderInasistencias' => $dataProviderInasistencias,
            'listClasescomision' => $listClasescomision,
             'echodiv' => $echodiv,
            
        ]) ?>

    <div class="clearfix"></div>

    <h3><?= Html::encode('Evaluación de Seguimiento') ?></h3>

        <?= $this->render('_seguimientosxalumno', [
            'dataProviderSeguimientos' => $dataProviderSeguimientos,
            
            
        ]) ?>

   
    <div id="firma">
        ....................................
        <br>
        <span>Firma</span>
    </div>

</div>