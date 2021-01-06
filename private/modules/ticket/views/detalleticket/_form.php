<?php

use kartik\file\FileInput;
use kartik\markdown\MarkdownEditor;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Detalleticket */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $estados = ArrayHelper::map($estados,'id', 'nombre');

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

<div class="detalleticket-form">

    <?php $form = ActiveForm::begin([
          'options'=>['enctype'=>'multipart/form-data']]); ?>

    

    <?= 

        $form->field($modelasignacion, 'agente')->widget(Select2::classname(), [
            'data' => $asignaciones,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);

    ?>


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

        $form->field($model, 'estadoticket')->widget(Select2::classname(), [
            'data' => $estados,
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
                'showPreview' => false,
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

</div>
