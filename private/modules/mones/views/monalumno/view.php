<?php

use kartik\detail\DetailView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\mones\models\Monalumno */

$this->title = $model->apellido.', '.$model->nombre;

?>
<div class="monalumno-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <h3><?= Html::encode("Carreras") ?></h3>

<?php
    foreach ($carreras as $carrera) {
  

        echo '<div class="col-md-4">';

        echo DetailView::widget([
            'model'=>$carrera,
            'condensed'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'enableEditMode' => false,
            'panel'=>[
                'heading'=>$carrera->nombre,
                'headingOptions' => [
                    'template' => '',
                ],
                'type'=>DetailView::TYPE_DEFAULT ,
            ],
            'attributes'=>[
                [
                    'label'=>'Acción',
                    'format' =>'raw',
                    'value' =>function() use ($model, $carrera) {
                        return Html::a(
                            '<span class="btn btn-primary"><span class="glyphicon glyphicon-education"></span> Ver historial académico</span>',
                            '?r=mones/monacademica/index&doc='.$model->documento.'&car='.$carrera->id);
                    }
                ]
            
            ]
        ]);
        echo '</div>';
    }

?>

</div>
