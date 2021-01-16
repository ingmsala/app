<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Autogestión de Espacios Curriculares';

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
                La plataforma incluye a los distintos espacios optativos y los proyectos sociocomunitarios correspondientes al plan de estudios 2018 del Colegio Nacional de Monserrat. Consulta de agenda de clases, horarios, resumen de cursado e historial académico.
                En las fechas debidamente comunicadas en esta plataforma se realizará la inscripcion a dichos espacio de manera autogestiva.
                Los alumnos ingresan con su número de documento.

            </div>
            <div class="col-sm-3">

                <div class="well"  style="margin-top:40px;">
                
                
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                    ]); ?>

                        
                        
                        <?= $form->field($model, 'documento')->textInput()->label('Documento del Estudiante') ?>
                       
                        <div class="form-group">
                            
                                <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                            
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
             </div>

        
        </div>
    </div>
    
</div>
