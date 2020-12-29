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
                            'label' => 'Agente',
                            'value' => function($model){
                                return $model->agente0->apellido.', '.$model->agente0->nombre;
                            }
                            
                        ],

                      
                        
                        
                    ],
                ]); ?>
        
</div>
