<?php

use kartik\form\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\sociocomunitarios\models\Rubrica */

$this->title = $model->matricula0->alumno0->apellido.', '.$model->matricula0->alumno0->nombre;

?>
<div class="rubrica-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <div class="pull-right"><?= Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?></div>
         </p>
    <br />
    <br />
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Trimestre',
                'value' => function($model){
                    return $model->trimestre.'° trimestre';
                },
                
            ],
            
            [
                'label' => 'Tipo',
                'attribute' => 'tiposeguimiento0.nombre',
                
            ],
            [
                'label' => 'Fecha',
                'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
                }
            ],
            'descripcion',

            [
                'label' => 'Estado',
                'attribute' => 'estadoseguimiento0.nombre',
                
            ],
        ],
    ]) ?>
<?php Pjax::begin(['id' => 'test', 'timeout' => 5000]); ?>


<?php
        echo GridView::widget([
            'dataProvider' => $provider,
            //'filterModel' => $searchModel,
            'summary' => false,
            'hover' => true,
            'pjax'=>true,
            'responsiveWrap' => false,
            'condensed' => true,
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                'heading' => Html::encode('Rúbrica'),
                'before' => false,
                'footer' => false,
                'after' => false,
            ],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'label' => 'Aspecto a evaluar',
                    'vAlign' => 'middle',
                    'hAlign' => 'center',
                    'format' => 'raw',
                    'attribute' => '0',
                    'value' => function($model){
                        return $model['0'];
                        
                    }
                ],
                [
                    'label' => '',
                    'vAlign' => 'middle',
                    'hAlign' => 'center',
                    'format' => 'raw',
                    'attribute' => '1'
                    /*'value' => function($model){
                        return var_dump($model);
                    }*/
                ],
                
                

                
            ],
        ]);
        
        

?>
<?php Pjax::end(); ?>
</div>
<?php $form = ActiveForm::begin(); ?>
<div class="form-group">
<div class="pull-right"><?= Html::submitButton('Finalizar', ['class' => 'btn btn-success']) ?></div>
    </div>
    <?php ActiveForm::end(); ?>
