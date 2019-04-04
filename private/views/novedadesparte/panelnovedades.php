<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DetalleparteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parte Docente - Panel de Novedades';

?>


<div class="detalleparte-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modal',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>


<?php Pjax::begin(['id' => 'test', 'timeout' => 5000]); ?>

    <?= 

GridView::widget([
        'id' => 'grid',
        'dataProvider' => $dataProvider,

        

        //'filterModel' => $searchModel,
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
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
            
            
            [
                'label' => 'Preceptor',
                'value' => function($model){
                    if($model->docente0 != null)
                        return $model->docente0['apellido'].', '.$model->docente0['nombre'];
                    else
                        return '';
                }
            ],
            
            
            'descripcion:ntext',
            [

                'label' => 'Estado',
                'attribute' => 'estadonovedad0.nombre',
            ],

            

            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{savesec}',
                                
                'buttons' => [
                    'savesec' => function($url, $model, $key){

                        //return Html::a('<span class="glyphicon glyphicon-floppy-disk"></span>', '?r=estadoinasistenciaxparte/create&detallecatedra='.$model->id);
                        //return Html::a('<span class="glyphicon glyphicon-ok"></span>',false,['class' => 'btn btn-success']);
                        return Html::a('Listo', '?r=novedadesparte/nuevoestado&id='.$model['id'], ['class' => 'btn btn-success btn-sm',
                            'data' => [
                            'confirm' => 'Desea marcar la novedad como Procesada y que se quite de esta lista?',
                            'method' => 'post',
                             ]
                            
                            ]);
                        
                         
                    },
                    
                ]

            ],

            
        ],
        'pjax' => true,
]);



Pjax::end();
    
 ?>
</div>
