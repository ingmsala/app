<?php

use kartik\file\FileInput;
use kartik\form\ActiveForm;
use kartik\grid\GridView;
use kartik\markdown\MarkdownEditor;
use kartik\select2\Select2;
use yii\bootstrap\Dropdown;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $creadores=ArrayHelper::map($creadores,'id', function($model) {
            return $model['apellido'].', '.$model['nombre'];}
        );
?>
<?php $prioridades =ArrayHelper::map($prioridades,'id', 'nombre');
$clasificaciones =ArrayHelper::map($clasificaciones,'id', 'nombre');

$customToolbar = [
    [
        'buttons' => [
            MarkdownEditor::BTN_BOLD => ['icon'=>'bold', 'title' => 'Bold'],
            MarkdownEditor::BTN_ITALIC => ['icon'=>'italic', 'title' => 'Italic'],
        ]
    ],
    [
        

        'buttons' => [
            // use a custom icon image
            MarkdownEditor::BTN_INDENT_L => [
                'icon' => 'indent-left',
                'encodeLabel'=>false,
                'title' => 'URL/Link'
            ],
            // use another icon framewrok
            MarkdownEditor::BTN_INDENT_R => [
                'icon' => 'indent-right',
                'label' => '<span class="icon icon-image"></span>',
                'encodeLabel'=>false,
                'title' => 'Image'
            ],
        ],
    ],

    [


        'buttons' => [
            // use a custom icon image
            MarkdownEditor::BTN_UL => [
                'icon' => 'list',
                'encodeLabel'=>false,
                'title' => 'URL/Link'
            ],
            // use another icon framewrok
            MarkdownEditor::BTN_OL => [
                'icon' => 'list-alt',
                'label' => '<span class="icon icon-image"></span>',
                'encodeLabel'=>false,
                'title' => 'Image'
            ],
        ],
    ],
];

$customFooterButtons = [
    [
        'buttons' => [
            MarkdownEditor::BTN_PREVIEW => [
                'icon' => 'search',
                'label' => 'Previa',
                'title' => 'Vista previa',
            ],
        ]
    ],
    
];

?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalgenerico',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>

    

<div class="ticket-form">

    <?php 
    
    
    $form = ActiveForm::begin([
          'options'=>['enctype'=>'multipart/form-data']]); 

    ?>

    <?= $form->field($model, 'asunto')->textInput(['maxlength' => true]) ?>

    <?php
    if($authpagovisible)
        echo Html::button('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Orden de pago', ['value' => Url::to(['/ticket/authpago/create']), 'title' => 'Nueva Orden de Pago', 'class' => 'btn btn-info btn-sm pull-right amodalgenerico']);
    ?>
<div class="clearfix"></div>
        
    <div id="authapago">
        <?php
        
        if($modelauth->estado!=null)
        echo $this->renderAjax('/authpago/view', [
            'model' => $modelauth,
            'updatehabilitado' => 2,
        ]);
    ?>
    </div>

    <?= $form->field($model, 'descripcion')->widget(
        MarkdownEditor::classname(), 
        [
            'height' => 150,
            'encodeLabels' => false,
            'showExport' => false,
            //'showPreview' => false,
            //'footer' => false,
            'footerMessage' => '',
            'toolbar' => $customToolbar,
            'footerButtons' => $customFooterButtons,
            'options' => ['class' => 'kv-md-preview'],
        ]
    )

    ?>

    <?= 

        $form->field($modelasignacion, 'agente')->widget(Select2::classname(), [
            'data' => $asignaciones,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);

    ?>
    

    <?= 

        $form->field($model, 'prioridadticket')->widget(Select2::classname(), [
            'data' => $prioridades,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);

    ?>
    
    <?php

        echo '<label class="control-label">Adjuntar</label>';
        echo FileInput::widget([
            'model' => $modelajuntos,
            'attribute' => 'image[]',
            'options' => ['multiple' => true],
            'pluginOptions' => [
                'overwriteInitial'=>false,
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false
            ],
        ]);

    ?>
    <br />    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php

        if($origen == 'update'){
            echo '<label class="control-label">Archivos adjuntados</label>';
            echo $this->render('/adjuntoticket/index', [
                'searchModel' => $searchModelAdjuntos,
                'dataProvider' => $dataProviderAdjuntos,
               
            ]);


        }

    ?>

    

    

</div>
