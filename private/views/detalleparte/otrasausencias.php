<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>
<div class="otrasausencias">
            <h4>Otras ausencia del día</h4>
                <?= GridView::widget([
                    'dataProvider' => $dataProviderOtras,
                    
                    'summary'=> "",
                    'columns' => [
                        
                       ['class' => 'yii\grid\SerialColumn'],
                        [   
                            'label' => 'Docente',
                            'value' => function($model){
                                return $model->docente0->apellido.', '.$model->docente0->nombre;
                            }
                            
                        ],

                      
                        
                        
                    ],
                ]); ?>
        
</div>
