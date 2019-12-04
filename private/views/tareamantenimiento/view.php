<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tareamantenimiento */

$this->title = 'Tarea';

?>
<div class="tareamantenimiento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p style="display: <?php if ($bm) echo 'block'; else echo 'none'; ?>">
       <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
       <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
           'class' => 'btn btn-danger',
           'data' => [
               'confirm' => 'Está seguro que desea eliminar el elemento?',
               'method' => 'post',
           ],
       ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                   if ($model['fecha'] == date('Y-m-d')){
                        return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy').' (HOY)';
                   } 
                   return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                }
            ],
            'descripcion:ntext',
            
            [
                'label' => 'Responsable',
                'attribute' => function($model){
                    try {
                        return $model->responsable0->apellido.', '.$model->responsable0->nombre;
                    } catch (Exception $e) {
                        return 'Area Mantenimiento';
                    }
                    
                }
            ],

            
            [
                'label' => 'Estado',
                'attribute' => 'estadotarea0.nombre',
            ],
            [
                'label' => 'Prioridad',
                'attribute' => 'prioridadtarea0.nombre',
            ],
            
        ],
    ]) ?>

   
    <div>
        <?= 
            $this->render('/actividadesmantenimiento/index', [
                
                'dataProvider' => $providerActividades,
                'tarea' => $tarea,
                'estado' => $estado,
                'modeltarea' => $model,
            ]); 
        ?>
    </div>

</div>
