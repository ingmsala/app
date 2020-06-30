<?php

use kartik\form\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pasividaddj */

?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'>Percepción de pasividades (Jubilaciones, Pensiones, Retiros, etc.)</h2>",
            'id' => 'modalpasividad',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>
    
<div class="pasividaddj-view">

    <p>
        
        <div class="pull-right"><?= Html::button('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['value' => Url::to('index.php?r=pasividaddj/create&dj='.$dj), 'class' => 'btn btn-default btn-block', 'id' => 'amodalpasividad']) ?></div>
        
    </div>
    </p>
     
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'regimen',
            'causa',
            'caja',
            [
                'label' => 'Desde que fecha',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model['fecha'], 'dd/MM/yyyy');
                },

            ],
            //'importe',
            [
                'label' => 'Percibe',
                'value' => function($model){
                    if($model->percibe == 1)
                        return 'Percibo';
                    else
                        return 'Suspendido';
                },

            ],
            
        ],
    ]) ?>


</div>
