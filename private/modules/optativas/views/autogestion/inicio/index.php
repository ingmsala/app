<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Autogestión de Espacios Optativos';

?>
<div class="site-login">
    
    <div class="container" style="margin-top: 30px;">

        <div class="row">

            <div class="col-sm-1"></div>
            <div class="col-sm-9">
                <center>
                    <div id="encabezad">
                        <img src="assets/images/logo-encabezado.png" />
                    </div>
                </center>
            </div>
            

        </div>
        
        <div class="row" style="margin-top:20px;">

            <div class="col-sm-1"></div>
            <div class="col-sm-6">
            
                <center><h3><?= Html::encode($this->title) ?></h3></center>
                El estudiante dispone para el cursado del currículo la posibilidad de elegir entre diferentes espacios curriculares que conforman las unidades curriculares optativas.
La práctica de las unidades curriculares optativas son de gran utilidad para que los estudiantes desarrollen su capacidad de decisión, desenvuelvan sus intereses específicos y relacionen las actividades curriculares con la realidad socio cultural.
Las unidades optativas consisten en un acuerdo entre docentes de las diferentes áreas y departamentos, conforme a su
especificidad, sobre un determinado tema teniendo en cuenta los intereses de los alumnos y la realidad socio cultural.

            </div>
            <div class="col-sm-3">

                <div class="well"  style="margin-top:40px;">
                
                
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                    ]); ?>

                        
                        
                        <?= $form->field($model, 'dni')->textInput()->label('Documento del Alumno') ?>
                       
                        <div class="form-group">
                            
                                <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                            
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
             </div>

        
        </div>
    </div>
    
</div>
