<?php

use app\modules\becas\models\Becapersona;
use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="becasolicitante-view">

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'cuil',
            'mail', 
            'domicilio',
            'telefono',      
            [
                'label' => 'Fecha de nacimiento',
                'value' => function($model){
                    return Yii::$app->formatter->asDate($model->fechanac, 'dd/MM/yyyy');
                }
            ],
            [
                'label' => 'Nivel de estudio',
                'attribute' => 'nivelestudio0.nombre',
            ],
            
            [
                'label' => 'Situación ocupacional',
                'format' => 'raw',
                'value' => function($model){
                    $salida = '<ul>';
                    $persona = Becapersona::findOne($model->persona);
                    foreach ($persona->becaocupacionpersonas as $oxp) {
                        $salida .= '<li>'.$oxp->ocupacion0->nombre.'</li>';
                    }
                    $salida .= '</ul>';
                    return $salida;
                }
            ],
            [
                'label' => 'Ayuda económica estatal',
                'format' => 'raw',
                'value' => function($model){
                    $salida = '<ul>';
                    $persona = Becapersona::findOne($model->persona);
                    foreach ($persona->becaayudapersonas as $oxp) {
                        $salida .= '<li>'.$oxp->ayuda0->nombre.'</li>';
                    }
                    $salida .= '</ul>';
                    return $salida;
                }
            ],
            [
                'label' => 'Negativa de Anses',
                'format' => 'raw',
                'value' => function($model){
                    try {
                        $delete = Html::a('×', ['/becas/becanegativaanses/delete', 'id' => $model->negativaanses, 'origen' => 's', 'pers' => $model->id], [
                            'class' => 'novisible',
                            'style' => 'color:white;text-decoration: none;',
                            'data' => [
                                'confirm' => 'Este proceso borra el archivo cargado. Está seguro que desea proceder?',
                                'method' => 'post',
                            ],
                        ]);
                        return '<span class="label label-default">'.$model->negativaanses0->nombre.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$delete.'</span>';
                    } catch (\Throwable $th) {
                        return 'No presenta';
                    }
                    return '<span class="label label-default">'.$model->negativaanses0->nombre.'</span>';
                }
            ],
            
            
        ],
    ]) ?>

</div>
