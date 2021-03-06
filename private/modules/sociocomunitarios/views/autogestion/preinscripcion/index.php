<?php

use app\modules\curriculares\models\Admisionoptativa;
use app\modules\curriculares\models\Matricula;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\espaciocurriculars\models\Matricula */

$this->title = 'Matriculación '.$aniolectivo.' - '.$instancia;

?>

<div style="width:75%;">
	
	 <?= GridView::widget([
        'dataProvider' => $admision,
        'options' => ['style' => 'font-size:11px;'],
        'responsiveWrap' => false,
        //'filterModel' => $searchModel,
        'toolbar'=>[
                    
                    
                    
                ],

        'panel' => [
            'type' => GridView::TYPE_INFO,
            'heading' => Html::encode('Debe matricularse en:'),
            'footer' => false,
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,
        'columns' => [
            
            
            [
            	'label' => 'Espaciocurricular de ',
            	'value' => function($model){
            		return $model['curso'].'° año';
            	}
            ],

            [
            	'label' => 'Cantidad ',
            	'value' => function($model){
            		return $model['cantidad'];
            	}
            ],

            [
            	'label' => 'Estado',
            	'format' => 'raw',

            	'value' => function($model){
            			$admisionxcurso = Admisionoptativa::find()
                                ->joinWith('aniolectivo0')
                                ->where(['alumno' => $model['alumno']])
                                ->andWhere(['aniolectivo.activo' => 1])
                                ->andWhere(['curso' => $model['curso']])
                                ->all();
                 $admisionxcurso = ArrayHelper::map($admisionxcurso,'id','curso');

                $admision = count($admisionxcurso);
            	$matriculas = $admision - count(Matricula::find()
                                ->joinWith(['comision0.espaciocurricular0.aniolectivo0'])
                                ->where(['alumno' => $model['alumno']])
                                ->andWhere(['aniolectivo.activo' => 1])
                                ->andWhere(['curso' => $model['curso']])
                                ->all());
            	if( $matriculas > 0)
            		return '<span style = "color:red">Pendiente';
            	return '<span style = "color:green">Listo';
            	}
            ],
           
            
        ],
    ]); ?>
</div>
<?= GridView::widget([
        'dataProvider' => $dataProviderEspaciocurricular,
        //'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'summary' => false,
        'striped' => true,
        'hover' => true,
        'condensed' => true,
        'options' => ['style' => 'font-size:11px;'],

        'toolbar'=>[
                    
                    
                    
                ],

        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
            'footer' => false,
            //'beforeOptions' => ['class'=>'kv-panel-before'],
        ],
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

             [
            	'label' => 'Espaciocurricular de ',
            	'group' => true,
            	'value' => function($model){
            		return $model['curso'].'° año';
            	},
            	'group' => true,  // enable grouping,
                'groupedRow' => true,                    // move grouped column to a single grouped row
                'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
            ],

             [
            	'label' => 'Espaciocurricular',
            	'group' => true,
            	'value' => function($model){
            		return $model['actividad'];
            	}
            ],

            [
            	'label' => 'Resumen',
            	//'group' => true,
            	'value' => function($model){
            		return $model['resumen'];
            	}
            ],

            'comision',

             [
            	'label' => 'Horarios',
            	
            	'value' => function($model){
            		return $model['horario'];
            	}
            ],

            [
            	'label' => 'Aula',
            	
            	'value' => function($model){
            		return $model['aula'];
            	}
            ],
            	

            

            [
            	'label' => 'Acción',
            	'format' => 'raw',
            	'value' => function($model) use ($matriculasalumno, $alumno, $estadoinscripcion, $preinscripcion){
                     
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
            		if($estadoinscripcion == 1 || ($estadoinscripcion == 3 && $preinscripcion->inicio <= date('Y-m-d H:i:s') && $preinscripcion->fin >= date('Y-m-d H:i:s')))
            			{
                            if(in_array($model['idcomi'], $matriculasalumno))
                                return "Matriculado";
                            return Html::a('Inscribirse', ['inscripcion', 'c' => $model['idcomi'], 'a' => $alumno], [
                                        'class' => 'btn btn-success btn-sm',
                                        'data' => [
                                            'confirm' => '¿Está seguro de querer inscrbirse en <b>'.$model['actividad'].'</b> comisión <b>'.$model['comision'].'</b>?',
                                            'method' => 'post',
                                ],
                            ]);
                        }else{
                            return '';
                        }
            		
            	}
            ],
            
           


            
        ],
    ]); ?>

