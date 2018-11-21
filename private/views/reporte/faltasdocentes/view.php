<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\web\View;


/* @var $this yii\web\View */
/* @var $model app\models\DetalleCatedra */

$this->title = $model->id;

?>
<div class="detalle-catedra-view">

<?php $this->registerJs("document.getElementById('modalHeader').innerHTML ='".
    'Docente: '.$model->apellido.', '.$model->nombre."';", View::POS_END, 'my-options'); ?>
        
  

    <h3>Detalle Ausencias</h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function($model){
            if ($model->falta !=1){
                return ['class' => 'success'];
            }
            return ['class' => 'danger'];
        },
        'columns' => [
            
            [   
                'label' => 'Fecha',
                'attribute' => 'parte0.fecha',
                'value' => function($model){
                   return Yii::$app->formatter->asDate($model->parte0->fecha, 'dd/MM/yyyy');
                }
                
            ],
            
            [
                'label' => 'Division',
                'attribute' => 'division0.nombre'
            ],
            'hora',
            'llego',
            'retiro',

            [   
                'label' => 'Falta',
                'attribute' => 'falta0.nombre',
                
            ],
            

            
        ],
    ]); ?>

    

</div>