<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DetalleparteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notificaciones';

?>





<div class="detalleparte-index">
	<div style="float: right;">
		<?php 

			(Yii::$app->session->has('urlorigen')) ? $anterior = Yii::$app->session->get('urlorigen') : $anterior = 'index';
			Yii::$app->session->remove('urlorigen');
		?>
		<?= Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>', $anterior, ['class' => 'btn btn-default']) ?>
	</div>
<div class="clearfix"></div>
<h3><?= Html::encode($this->title) ?></h3>
<?php Pjax::begin(['id' => 'test', 'timeout' => 5000]); ?>

    <?= 

GridView::widget([
        'id' => 'grid',
        'dataProvider' => $dataProvider,
        'summary'=> "",
        //'filterModel' => $searchModel,
        'columns' => [
            
           [
                'format' => 'raw',
                'label' => '',
                //'attribute' => 'estadonovedad0.nombre',
                'value' => function($model){
                    $itemsc = [];
                    
                    $formatter = \Yii::$app->formatter;
       
                    foreach($model->estadoxnovedads as $estadoxnovedad){
                        
                        $itemsc[] = [$formatter->asDate($estadoxnovedad->fecha, 'dd/MM/yyyy'), $estadoxnovedad->estadonovedad0->nombre];
                        
                    }
                    
                    return Html::ul($itemsc, ['item' => function($item) {
                        //var_dump($item);
                                ($item[1]=='Activo') ? $boots='warning' : $boots='success';
                                return 
                                        Html::tag('li', 
                                        $item[0].' - '.$item[1], ['class' => 'list-group-item list-group-item-'.$boots]);
                        }
                    , 'class' => "nav nav-pills nav-stacked"]);                  
                    //var_dump($itemsc);
                    //return implode(' // ', $itemsc);
                    //return $model->alumno0->dni;
                }
            ],
           [   
                'label' => 'Fecha',
                'attribute' => 'parte0.fecha',
               
                'value' => function($model){
                    //var_dump($model);
                    $formatter = \Yii::$app->formatter;
                    return $formatter->asDate($model->parte0->fecha, 'dd/MM/yyyy');
                    
                }
            ],
            [

                'label' => 'Preceptoria',
                'attribute' => 'parte0.preceptoria0.nombre',

            ],

            [

                'label' => 'Tipo de Novedad',
                'attribute' => 'tiponovedad0.nombre',
            ],

                       
            'descripcion:ntext',
            
            

            [
                'format' => 'raw',
                'label' => 'Tiempo respuesta',
                //'attribute' => 'estadonovedad0.nombre',
                'value' => function($model){
                        $itemsc = [];
                        $max=-1;
                        $c=0;
       
                        foreach($model->estadoxnovedads as $estadoxnovedad){
                            if($c==0){
                                $max = $estadoxnovedad->estadonovedad;
                                $date1 = new DateTime($estadoxnovedad->fecha);
                            }
                            if ($max>=$estadoxnovedad->estadonovedad){
                                $max=$max;
                                $date2 = new DateTime(date("Y-m-d"));
                            }else{
                                $max=$estadoxnovedad->estadonovedad;
                                $date2 = new DateTime($estadoxnovedad->fecha);
                            }
                            $c=$c+1;
                        }
                        //return $max;
                        
                        $diff = $date1->diff($date2);
                        $dias = 'días';
                        if($diff->days>15)
                            $color='red';
                        elseif($diff->days>5)
                            $color='orange';
                        elseif($diff->days==1){
                            $color='green';
                             $dias = 'día';
                        }
                        else
                            $color='green';
                        // will output 2 days
                        //return $diff->days . ' días';
                        //if ($max ==  1)
                        return '<center><span style="color:'.$color.';">'.$diff->days.' '.$dias.'</span></center>';
                  
                },
            ],
            

            
            

            
        ],
        'pjax' => true,
]);



Pjax::end();
    
 ?>

 
</div>