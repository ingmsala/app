<?php

use app\models\Horariodj;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Actividadnooficial */


?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'>En tareas o actividades no oficiales</h2>",
            'id' => 'modalnooficial',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>
<div class="actividadnooficial-view">

    
<p>
        
        <div class="pull-right"><?= Html::button('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['value' => Url::to('index.php?r=actividadnooficial/create&dj='.$dj), 'class' => 'btn btn-default btn-block', 'id' => 'amodalnooficial']) ?></div>
        
    </div>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'empleador',
            'lugar',
            'sueldo',
            [
                'label' => 'Ingreso',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    return Yii::$app->formatter->asDate($model['ingreso'], 'dd/MM/yyyy');
                },

            ],
            'funcion',
            [
                'label' => 'Horario',
                'value' => function($model){
                    try {
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                    
                        $hj =Horariodj::find()->where(['actividadnooficial' => $model->id])->one();
                        return Yii::$app->formatter->asDate($hj->inicio, 'HH:mm').' a '.Yii::$app->formatter->asDate($hj->fin, 'HH:mm');
                    } catch (\Throwable $th) {
                        return '';
                    }
                    
                },

            ]
            
        ],
    ]) ?>

</div>
