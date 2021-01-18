<?php

use app\models\Agente;
use app\models\Nombramiento;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\grid\GridView;
use kartik\time\TimePicker;
use softark\duallistbox\DualListbox;
use yii\bootstrap\Alert;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Reunionedh */

$this->title = $model->id;

\yii\web\YiiAsset::register($this);

$this->params['sidebar'] = [
    'visible' => true,
    'model' => $model->caso0,
    'origen' => 'reuniones',
];

$this->registerJs("
           
                     
                $('#infoguardado').fadeIn(1000);
                setTimeout(function() { 
                       $('#infoguardado').fadeOut(1000); 
                }, 3000);");



?>
 <?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader4'>".'Cambiar estado'."</h2>",
            'id' => 'amodalsolicitudstate',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent4'></div>";

        Modal::end();
	?>
<div class="reunionedh-view">

    <?php 
        $breadcrumbs = [];
        $breadcrumbs [] = ['label' => 'Reuniones'];
        //$breadcrumbs [] = $this->title;

    ?>


    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => '< Volver', 'url' => ['index', 'caso' => $model->caso]],
        'links' => $breadcrumbs,
    ]) ?>
    
<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); ?>
    <?php

            echo FormGrid::widget([
            
            'model'=>$model,
            'form'=>$form,
            'autoGenerateColumns'=>true,
            'rows'=>[
                
                [
                    
                    'attributes'=>[       // 2 column layout
                        
                        'fecha'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\date\DatePicker', 
                            'options'=>[
                                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                //'value' => '23-Feb-1982',
                                'readonly' => true,
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'dd/mm/yyyy',
                                    
                                    
                                ],
                            ]
                        ],   
                        'hora'=>[
                            'type'=>Form::INPUT_WIDGET, 
                            'widgetClass'=>'\kartik\time\TimePicker', 
                            'options'=>[
                                
                                    'pluginOptions' => [
                                    'showMeridian' => false,
                                    'minuteStep' => 1,
                                    'defaultTime' => false,
                                    
                                    
                                ],
                            ]
                        ],
                        'lugar'=>['type'=>Form::INPUT_TEXT],   
                    ]
                ],
                [
                    //'contentBefore'=>'<legend class="text-info"><small>2</small></legend>',
                    'attributes'=>[       // 2 column layout
                        
                        'tematica'=>['type'=>Form::INPUT_TEXT],
                        'url'=>['type'=>Form::INPUT_TEXT],   
                    ]
                ],

                [
                    
                    'attributes'=>[       // 2 column layout
                        'parte'=>['type'=>Form::INPUT_TEXTAREA],   
                    ]
                ],
                
            ]

        ]);
    ?>

    

    <div class="form-group">
        <div class="pull-right" >
            <?php
                if (Yii::$app->session->has('success3')){ 
                    echo Alert::widget([
                           'options' => [
                               'class' => 'alert-success',
                               'id'=>"infoguardado",
                           ],
                           'body' => Yii::$app->session->get('success3'),
                       ]);
                       Yii::$app->session->remove('success3');
                }
            ?>
        <?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>


    
    <div class="clearfix"></div>

    <?= Html::button('<span class="glyphicon glyphicon-refresh"></span>', ['value' => Url::to('index.php?r=edh/participantereunion/porreunion&id='.$model->id), 'class' => 'btn btn-info amodalsolicitudstate', 'style' => 'width:auto;']); ?>
    <hr />
    <h4>Participantes</h4>
    <hr />
    <?php

        echo $this->render('/participantereunion/index', [
            'searchModel' => $searchModelParticipantes,
            'dataProvider' => $dataProviderParticipantes,
            
        ]);
        
    ?>

    



</div>
