<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NovedadesestudianteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Becas';


?>

<script>
    $(document).ready(function(){
        $('#modal').modal('show').find('#modalHeader').html('Información importante');
        $("#modal").modal('show');
        
    });
</script>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modal',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo '<div id="modalContent">
        La solicitud de beca se compone de 3 pasos:<br /><br />
        <ul>
        <li>Paso 1: Completar los datos del estudiante y del tutor solicitante</li>
        <li>Paso 2: Completar los datos de <b>todas</b> las personas -menores y mayores - que conviven con el/la estudiante</li>
        <li>Paso 3: Revisar los datos y presionar el botón <b>"Enviar Solicitud"</b> al final de la pantalla del paso 3</li>
        </ul>

        <div class="alert alert-warning" role="alert">El formulario tiene caracter de declaración jurada, es necesario que complete hasta el final el mismo para que pueda ser evaluada por el Área de Becas del Colegio</div>
        
        
        <button type="button" class="btn btn-success pull-right" data-dismiss="modal" aria-hidden="true">Aceptar</button>
        <div class="clearfix"></div>
        </div>';
        Modal::end();
    ?>

<div class="becas-index">

<?php 
        $breadcrumbs = [];
        $breadcrumbs [] = [
            'label' => 'Paso 2: Grupo familiar',
            //'url' => ['grupofamiliar'],
            'template' => "<li><span class=\"becapasoinactivo\">{link}</span></li>\n"
        ];
        $breadcrumbs [] = [
            'label' => 'Paso 3: Finalizar y enviar',
            //'url' => ['finalizar'],
            'template' => "<li><span class=\"becapasoinactivo\">{link}</span></li>\n"
        ];
        //$breadcrumbs [] = $this->title;

    ?>


    <?= Breadcrumbs::widget([
        'options' => ['class' => 'breadcrumb breadcrumbsbeca'],
        'homeLink' => ['label' => 'Paso 1: Solicitud', 'url' => ['index'], 'template' => "<li><b><u>{link}</u></b></li>\n",],
        'links' => $breadcrumbs,
    ]) ?>

<h1>Solicitud de becas</h1>


            <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); ?>

                <div class="panel panel-default">
                    <div class="panel-heading">Estudiante</div>
                    <div class="panel-body">
                        <?php 

                            echo $this->render('/becaalumno/create',[

                                'model' => $modelalumno,
                                'ocupaciones' => $ocupaciones,
                                'nivelestudio' => $nivelestudio,
                                'ayudasestatal' => $ayudasestatal,
                                'modelocupacionesx' => $modelocupacionesx,
                                'modelayudax' => $modelayudax,
                                'form' => $form,

                            ]) 

                        ?>
                    </div>
                </div>
            



                <div class="panel panel-default">
                    <div class="panel-heading">Solicitante</div>
                    <div class="panel-body">
                        <?php 

                            echo $this->render('/becasolicitante/create',[

                                'model' => $modelsolicitante,
                                'ocupaciones' => $ocupaciones,
                                'nivelestudio' => $nivelestudio,
                                'ayudasestatal' => $ayudasestatal,
                                'modelocupacionesx' => $modelocupacionesx,
                                'modelayudax' => $modelayudax,
                                'parentescos' => $parentescos,
                                'form' => $form,

                            ]) 

                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="pull-right">
                        <?= Html::submitButton('Siguiente >', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            
</div>