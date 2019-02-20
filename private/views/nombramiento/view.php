<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Nombramiento */
$this->title = "Nombramiento";
$this->params['breadcrumbs'][] = ['label' => 'Nombramientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nombramiento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Modificar', ['value' => Url::to('index.php?r=nombramiento/update&id='.$model->id),
                                'class' => 'modalaNombramiento btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro de querer eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Docente',
                'attribute' => 'docente',
                'value' => function($model){

                   return $model->docente0->apellido.', '.$model->docente0->nombre;
                }
            ],
            [
                'label' => 'Condición',
                'attribute' => 'condicion',
                'value' => function($model){

                   return $model->condicion0->nombre;
                }
            ],
            'nombre',
            [
                'label' => 'Cargo',
                'attribute' => 'cargo',
                'value' => function($model){

                   return $model->cargo.' - '.$model->cargo0->nombre;
                }
            ],
            [
                'label' => 'Revista',
                'attribute' => 'revista',
                'value' => function($model){

                   return $model->revista0->nombre;
                }
            ],
            'horas',
            
            
            [
                'label' => 'Division',
                'attribute' => 'division',
                'value' => function($model){

                    try{
                        $divi = $model->division0->nombre;
                     }catch(\Exception $exception){
                        $divi = '';
                     }

                     return $divi;
                }
            ],
            
        ],
    ]) ?>

    
<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modal',
            'size' => 'modal-lg',
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>

<h3>Suplente</h3>
    <?= Html::button('Agregar Suplente', ['value' => Url::to('index.php?r=nombramiento/asignarsuplente&cargox='.$model->cargo.'&idx='.$model->id), 'class' => 'btn btn-success', 'id'=>'modalButtonNombramiento']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function($model){
            if ($model->condicion0->nombre !='SUPL'){
                return ['class' => 'info'];
            }
            return ['class' => 'warning'];
        },
        'columns' => [
            
            [   
                'label' => 'Condición',
                'attribute' => 'condicion0.nombre'
            ],
            
            [
                'label' => 'Docente',
                'attribute' => 'docente',
                'value' => function($model){

                   return $model->docente0->apellido.', '.$model->docente0->nombre;
                }
            ],
            
            [   
                'label' => 'Revista',
                'attribute' => 'revista0.nombre'
            ],

            'horas',

            [

                'label' => 'Extensión',
                'attribute' => 'extension',
                'value' => function($model){
                     try{
                        $exte = $model->extension0->nombre;
                     }catch(\Exception $exception){
                        $exte = '';
                     }

                   return $exte;
                }
            ],

           // ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewdetcat} {updatedetcat} {deletedetcat}',
                
                'buttons' => [
                    'viewdetcat' => function($url, $model, $key){
                        return $model->id != '' ? Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            '?r=nombramiento/view&id='.$model->id) : '';
                    },
                    'updatedetcat' => function($url, $model, $key){
                        return $model->id != '' ? Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                            ['value' => Url::to('index.php?r=nombramiento/update&id='.$model->id),
                                'class' => 'modalaNombramiento btn btn-link']) : '';


                    },
                    'deletedetcat' => function($url, $suplente, $key){
                        
                        echo $suplente->id;
                        return $suplente->id != '' ? Html::a('<span class="glyphicon glyphicon-trash"></span>', '?r=nombramiento/delete&id='.$suplente->id, 
                            ['data' => [
                            'confirm' => 'Está seguro de querer eliminar este elemento?',
                            'method' => 'post',
                             ]
                            ]) : '';
                    },
                ]

            ],
        ],
    ]); ?>

</div>
