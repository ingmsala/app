<?php

use kartik\form\ActiveForm;
use kartik\grid\GridView;
use softark\duallistbox\DualListbox;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Participantereunion */



?>
<div class="participantereunion-create">

<?php $form = ActiveForm::begin(); ?>

    <?php

        $options = [
            'multiple' => true,
            'size' => 15,
        ];

        

        /*$items = ArrayHelper::map(Agente::find()->all(), 'documento', function($model){
            $nom = Nombramiento::find()->where(['agente' => $model->id])->one();
            try {
                return $model->apellido.', '.$model->nombre.'('.$nom->division0->nombre.')';
            } catch (\Throwable $th) {
                return $model->apellido.', '.$model->nombre;
            }
            
        });
        $selection = [];*/
        echo $form->field($model, 'participantes[]')->widget(DualListbox::className(),[
            
            'items' => $items,
            'options' => $options,
            'clientOptions' => [
                'selectedListLabel' => 'Participantes',
                    'nonSelectedListLabel' => 'Personas a invitar',
                    'infoText' => null,
                    'moveOnSelect' => false,
                    //'nonSelectedFilter' => 'Sala',
                    //'filterOnValues' => true
                    //'showFilterInputs' => false,
                    'filterPlaceHolder' => ''
            ],
        ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    


</div>
