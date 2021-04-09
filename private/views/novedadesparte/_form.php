<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;


/* @var $this yii\web\View */
/* @var $model app\models\Novedadesparte */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $listtiponovedades=ArrayHelper::map($tiponovedades,'id','nombre'); ?>
<?php $listCursos=ArrayHelper::map($cursos,'id','nombre'); ?>
<?php $listAlumnos=ArrayHelper::map($alumnos,'id',function($alumno){
    return $alumno->apellido.', '.$alumno->nombre;
}); ?>
<?php $listpreceptores=ArrayHelper::map($preceptores,'id',function($model){
	return $model->apellido.', '.$model->nombre;
}); ?>

<div class="novedadesparte-form">
    <?= Html::csrfMetaTags() ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= 

        $form->field($model, 'tiponovedad')->widget(Select2::classname(), [
            'data' => $listtiponovedades,
            'options' => ['placeholder' => 'Seleccionar...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'pluginEvents' => [
                'select2:select' => 'function() {
                    if ($(this).val()==1 || $(this).val()==5 || $(this).val()==6 || $(this).val()==9) {
                           $( "#divpreceptor" ).show();
                           $( "#divedilicias" ).hide();
                           $( "#ausencias" ).hide();
                          
                        }else{
                            
                           $( "#divpreceptor" ).hide();
                            $( "#divedilicias" ).hide();
                           if ($(this).val()==2 || $(this).val()==3){
                               
                                $( "#ausencias" ).hide();
                                $( "#divedilicias" ).show();
                           }
                           if ($(this).val()==7){
                                $( "#ausencias" ).show();
                                
                           }
                        }
                        
                }',
            ]
        ]);

    ?>
    <div id="divpreceptor" <?php if($model->agente!=null) echo 'style="display: block; "'; else echo 'style="display: none; "'; ?>>
        
    
    <?= 
                                
                                $form->field($model, 'agente')->widget(Select2::classname(), [
                                    'data' => $listpreceptores,
                                    'options' => ['placeholder' => 'Seleccionar...', 'multiple' => true,],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Agente');

                            ?>
    </div>
    <div id="divedilicias" <?php if(in_array($model->tiponovedad, [2,3])) echo 'style="display: block; "'; else echo 'style="display: none; "'; ?>>
    <div class="row">
        <div class="col-lg-6">
                    <?= Html::label('N° Aula o Nombre del espacio', 'aulaoespacio') ?>
                    <?= Html::textInput('aulaoespacio', null, ['class' => 'form-control']) ?>   
        </div> 
        <div class="col-lg-6">
                   <?= Html::label('Banco', 'banco') ?>
                    <?= Html::textInput('banco', null, ['class' => 'form-control']) ?>     
        </div>         
    </div>   
    
    </div>

    <div id="ausencias" <?php if(in_array($model->tiponovedad, [7])) echo 'style="display: block; "'; else echo 'style="display: none; "'; ?>>
    <div class="row">
        <div class="col-lg-6">
                    <?= Html::label('Curso', 'curso') ?>
                    <?= Html::dropDownList('curso', '', $listCursos, ['prompt'=> 'Seleccionar...', 'class' => 'form-control', 'id' => 'division_id']); ?>   
        </div> 
        <div class="col-lg-6">
                   <?= Html::label('Alumno/a', 'alumno') ?>
                   <?= Select2::widget([
                        'name' => 'alumno',
                        'id' => 'alumno',
                        'options' => ['placeholder' => 'Seleccionar...'],
                        'data' => $listAlumnos,
                        
                    ]); ?>
                    
                    
                         
        </div>
        
    </div>  
    <div class="row">
        <div class="col-lg-12">
            <br />
            <?= Html::label('Materia/s', 'catedra-id') ?>
                                <?php echo DepDrop::widget([
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'name' => 'catedra',
                                    
                                    'options' => ['id'=>'catedra-id', 'multiple' => true],
                                    'pluginOptions' => [
                                       'depends'  => ['division_id'],
                                       'placeholder' => 'Seleccionar 1 o 2 materias',
                                       'url' => Url::to(['/catedra/catxdivi'])
                                    ]
                                ]);  ?>
            <br />
        </div>
    </div> 
    
    </div>
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>
    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
