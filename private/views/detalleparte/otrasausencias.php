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
                        
                        [   
                            'label' => 'División',
                            'attribute' => 'division',
                            'value' => 'division0.nombre'
                        ],
                        [   
                            'label' => 'Hora',
                            'attribute' => 'hora',
                            'value' => 'hora0.nombre'
                        ],
                        [   
                            'label' => 'Apellido',
                            'attribute' => 'docente0.apellido'
                        ],

                        [   
                            'label' => 'Nombre',
                            'attribute' => 'docente0.nombre'
                        ],
                        
                        
                    ],
                ]); ?>
        
</div>
