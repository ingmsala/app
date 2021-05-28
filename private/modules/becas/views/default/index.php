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

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modal',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

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