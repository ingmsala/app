<?php

use app\modules\horarioespecial\models\Detallemodulo;
use app\modules\horarioespecial\models\Horarioclaseespecial;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalpasividad',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>


<?php
    


    if(Yii::$app->params['devicedetect']['isMobile']){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
            
        $models = $provider->getModels();
        
        foreach ($models as $model) {
            $i = 0;
            //$fechaok = Yii::$app->formatter->asDate($modelok['fecha'], 'dd/MM/yyyy');
            echo '<div class="col-md-4">';
            echo DetailView::widget([
                'model'=>$model,
                'condensed'=>true,
                'hover'=>true,
                'mode'=>DetailView::MODE_VIEW,
                'enableEditMode' => false,
                'panel'=>[
                    'heading'=>$model->grupodivision0->habilitacionce0->division0->nombre,
                    'headingOptions' => [
                        'template' => '',
                    ],
                    'type'=>DetailView::TYPE_DEFAULT,
                ],
                'attributes'=>[
                    //['class' => 'yii\grid\SerialColumn'],
        
                    //'id',
                           
                    [
                        'label' => 'Fecha',
                        //'attribute' => 'fecha',
                        'format' => 'raw',
                        'value' => function() use($model){
                            date_default_timezone_set('America/Argentina/Buenos_Aires');
                           if ($model->grupodivision0->habilitacionce0->fecha == date('Y-m-d')){
                                return Yii::$app->formatter->asDate($model->grupodivision0->habilitacionce0->fecha, 'dd/MM/yyyy').' (HOY)';
                           } 
                           return Yii::$app->formatter->asDate($model->grupodivision0->habilitacionce0->fecha, 'dd/MM/yyyy');
                        }
                    ],
                    
                    [
                        'label' => 'Módulo',
                        'value' => function() use($model){
                            return $model->moduloclase0->nombre;
                        }
                        
                    ],
                    [
                        'label' => 'Horario',
                        
                        'value' => function() use($model){
                            $arr = Horarioclaseespecial::find()
                                        ->joinWith(['detallemodulos'])
                                        ->where(['detallemodulo.grupodivision' => $model->grupodivision])
                                        ->andWhere((['detallemodulo.moduloclase' => $model->moduloclase]))
                                        ->all();
                            $inicio = ArrayHelper::getColumn($arr,'inicio');
                            $fin = ArrayHelper::getColumn($arr,'fin');
                            $cant = count($arr);
                            
                            return min($inicio).' a '.max($fin).' - Dividido en '.$cant.' grupos de curso';
                            
                        }
                    ],
        
                    [
                        'label' => 'Disponibilidad',
                        'format' => 'raw',
                        'value' => function() use($model){
                            
                            //return $cantocup;
                            
                            /*CAMBIAR DOCENTE*/
                            
                            
                                $detalles1 = Detallemodulo::find()
                                        ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                                        ->where(['habilitacionce' => $model->grupodivision0->habilitacionce])
                                        ->andWhere(['moduloclase' => $model->moduloclase])
                                        ->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                                        //->andWhere(['is', 'detallecatedra', null])
                                        ->all();
                                //return var_dump($detallesotromod);
                                //$detalles1= count($detalles1);
                                if(count($detalles1)>0)  
                                    return 'Inscripto';
                                
                                $detalles1 = Detallemodulo::find()
                                        ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                                        ->where(['habilitacionce.fecha' => $model->grupodivision0->habilitacionce0->fecha])
                                        ->andWhere(['<>', 'habilitacionce.division', $model->grupodivision0->habilitacionce0->division])
                                        ->andWhere(['moduloclase' => $model->moduloclase])
                                        ->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                                        //->andWhere(['is', 'detallecatedra', null])
                                        ->all();
                                if(count($detalles1)>0)  
                                    return 'No puede anotarse, ya está en otra división en este módulo';   
                                
                                $detalles1 = Detallemodulo::find()
                                        ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                                        ->where(['habilitacionce' => $model->grupodivision0->habilitacionce])
                                        //->andWhere(['<>', 'habilitacionce.division', $model->grupodivision0->habilitacionce0->division])
                                        ->andWhere(['<>', 'moduloclase', $model->moduloclase])
                                        ->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                                        //->andWhere(['is', 'detallecatedra', null])
                                        ->all();
                                
                                if(count($detalles1)>0)  
                                    return 'No puede anotarse en más de un módulo en esta división';
        
                                $detalles1 = Detallemodulo::find()
                                        ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                                        ->where(['habilitacionce' => $model->grupodivision0->habilitacionce])
                                        //->andWhere(['<>', 'habilitacionce.division', $model->grupodivision0->habilitacionce0->division])
                                        ->andWhere(['moduloclase' => $model->moduloclase])
                                        //->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                                        ->andWhere(['is', 'detallecatedra', null])
                                        ->all();
        
                                if(count($detalles1)>=3)  
                                    return '';
                                
        
                                return 'Cupo completo';
                            
                            
                            
                        }
                    ],
                    [
                        'label' => 'Acciones',
                        'format' => 'raw',
                        'value' => function() use($model){
        
        
                            $detalles1 = Detallemodulo::find()
                                        ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                                        ->where(['habilitacionce' => $model->grupodivision0->habilitacionce])
                                        ->andWhere(['moduloclase' => $model->moduloclase])
                                        ->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                                        //->andWhere(['is', 'detallecatedra', null])
                                        ->all();
                                //return var_dump($detallesotromod);
                                //$detalles1= count($detalles1);
                            if(count($detalles1)>0)  
                                return Html::button('Ver aulas', ['value' => Url::to('index.php?r=horarioespecial/detallemodulo/detalleaulas&id='.$model->id), 'class' => 'btn btn-info amodalhorariojs']);
        
                            
                            $detalles1 = Detallemodulo::find()
                                    ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                                    ->where(['habilitacionce.fecha' => $model->grupodivision0->habilitacionce0->fecha])
                                    ->andWhere(['<>', 'habilitacionce.division', $model->grupodivision0->habilitacionce0->division])
                                    ->andWhere(['moduloclase' => $model->moduloclase])
                                    ->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                                    //->andWhere(['is', 'detallecatedra', null])
                                    ->all();
                            if(count($detalles1)>0)  
                                return '';   
                            
                            $detalles1 = Detallemodulo::find()
                                    ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                                    ->where(['habilitacionce' => $model->grupodivision0->habilitacionce])
                                    //->andWhere(['<>', 'habilitacionce.division', $model->grupodivision0->habilitacionce0->division])
                                    ->andWhere(['<>', 'moduloclase', $model->moduloclase])
                                    ->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                                    //->andWhere(['is', 'detallecatedra', null])
                                    ->all();
                            
                            if(count($detalles1)>0)  
                                return '';
        
                            $detalles1 = Detallemodulo::find()
                                    ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                                    ->where(['habilitacionce' => $model->grupodivision0->habilitacionce])
                                    //->andWhere(['<>', 'habilitacionce.division', $model->grupodivision0->habilitacionce0->division])
                                    ->andWhere(['moduloclase' => $model->moduloclase])
                                    //->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                                    ->andWhere(['is', 'detallecatedra', null])
                                    ->all();
        
                            if(count($detalles1)>=3) 
                                return Html::button('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Anotarse', ['value' => Url::to('index.php?r=horarioespecial/detallemodulo/asignardocentemodulos&id='.$model->id), 'class' => 'btn btn-success amodalhorariojs']);
                            
                            return '';
        
                            
                            
                            
                        }
                    ],
                    
                    
                ]
            ]);
            echo '</div>';
        }
        echo '<div class="clearfix"></div>'; 
        
       } else{

        echo GridView::widget([
        'dataProvider' => $provider,
        //'filterModel' => $searchModel,
        'responsiveWrap' => false,

        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'label' => 'División',
                'group' => true,
                'attribute' => 'grupodivision0.habilitacionce0.division0.nombre',
            ],

            [
                'label' => 'Fecha',
                //'attribute' => 'fecha',
                'format' => 'raw',
                'value' => function($model){
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                   if ($model->grupodivision0->habilitacionce0->fecha == date('Y-m-d')){
                        return Yii::$app->formatter->asDate($model->grupodivision0->habilitacionce0->fecha, 'dd/MM/yyyy').' (HOY)';
                   } 
                   return Yii::$app->formatter->asDate($model->grupodivision0->habilitacionce0->fecha, 'dd/MM/yyyy');
                }
            ],
            
            [
                'label' => 'Módulo',
                'group' => true,
                'attribute' => 'moduloclase0.nombre',
            ],
            [
                'label' => 'Horario',
                
                'value' => function($model){
                    $arr = Horarioclaseespecial::find()
                                ->joinWith(['detallemodulos'])
                                ->where(['detallemodulo.grupodivision' => $model->grupodivision])
                                ->andWhere((['detallemodulo.moduloclase' => $model->moduloclase]))
                                ->all();
                    $inicio = ArrayHelper::getColumn($arr,'inicio');
                    $fin = ArrayHelper::getColumn($arr,'fin');
                    $cant = count($arr);
                    
                    return min($inicio).' a '.max($fin).' - Dividido en '.$cant.' grupos de curso';
                    
                }
            ],

            [
                'label' => 'Disponibilidad',
                'format' => 'raw',
                'value' => function($model){
                    
                    //return $cantocup;
                    
                    /*CAMBIAR DOCENTE*/
                    
                    
                        $detalles1 = Detallemodulo::find()
                                ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                                ->where(['habilitacionce' => $model->grupodivision0->habilitacionce])
                                ->andWhere(['moduloclase' => $model->moduloclase])
                                ->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                                //->andWhere(['is', 'detallecatedra', null])
                                ->all();
                        //return var_dump($detallesotromod);
                        //$detalles1= count($detalles1);
                        if(count($detalles1)>0)  
                            return 'Inscripto';
                        
                        $detalles1 = Detallemodulo::find()
                                ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                                ->where(['habilitacionce.fecha' => $model->grupodivision0->habilitacionce0->fecha])
                                ->andWhere(['<>', 'habilitacionce.division', $model->grupodivision0->habilitacionce0->division])
                                ->andWhere(['moduloclase' => $model->moduloclase])
                                ->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                                //->andWhere(['is', 'detallecatedra', null])
                                ->all();
                        if(count($detalles1)>0)  
                            return 'No puede anotarse, ya está en otra división en este módulo';   
                        
                        $detalles1 = Detallemodulo::find()
                                ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                                ->where(['habilitacionce' => $model->grupodivision0->habilitacionce])
                                //->andWhere(['<>', 'habilitacionce.division', $model->grupodivision0->habilitacionce0->division])
                                ->andWhere(['<>', 'moduloclase', $model->moduloclase])
                                ->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                                //->andWhere(['is', 'detallecatedra', null])
                                ->all();
                        
                        if(count($detalles1)>0)  
                            return 'No puede anotarse en más de un módulo en esta división';

                        $detalles1 = Detallemodulo::find()
                                ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                                ->where(['habilitacionce' => $model->grupodivision0->habilitacionce])
                                //->andWhere(['<>', 'habilitacionce.division', $model->grupodivision0->habilitacionce0->division])
                                ->andWhere(['moduloclase' => $model->moduloclase])
                                //->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                                ->andWhere(['is', 'detallecatedra', null])
                                ->all();

                        if(count($detalles1)>=3)  
                            return '';
                        

                        return 'Cupo completo';
                    
                    
                    
                }
            ],
            [
                'label' => 'Acciones',
                'format' => 'raw',
                'value' => function($model){


                    $detalles1 = Detallemodulo::find()
                                ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                                ->where(['habilitacionce' => $model->grupodivision0->habilitacionce])
                                ->andWhere(['moduloclase' => $model->moduloclase])
                                ->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                                //->andWhere(['is', 'detallecatedra', null])
                                ->all();
                        //return var_dump($detallesotromod);
                        //$detalles1= count($detalles1);
                    if(count($detalles1)>0)  
                        return Html::button('Ver aulas', ['value' => Url::to('index.php?r=horarioespecial/detallemodulo/detalleaulas&id='.$model->id), 'class' => 'btn btn-info amodalhorariojs']);

                    
                    $detalles1 = Detallemodulo::find()
                            ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                            ->where(['habilitacionce.fecha' => $model->grupodivision0->habilitacionce0->fecha])
                            ->andWhere(['<>', 'habilitacionce.division', $model->grupodivision0->habilitacionce0->division])
                            ->andWhere(['moduloclase' => $model->moduloclase])
                            ->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                            //->andWhere(['is', 'detallecatedra', null])
                            ->all();
                    if(count($detalles1)>0)  
                        return '';   
                    
                    $detalles1 = Detallemodulo::find()
                            ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                            ->where(['habilitacionce' => $model->grupodivision0->habilitacionce])
                            //->andWhere(['<>', 'habilitacionce.division', $model->grupodivision0->habilitacionce0->division])
                            ->andWhere(['<>', 'moduloclase', $model->moduloclase])
                            ->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                            //->andWhere(['is', 'detallecatedra', null])
                            ->all();
                    
                    if(count($detalles1)>0)  
                        return '';

                    $detalles1 = Detallemodulo::find()
                            ->joinWith(['grupodivision0.habilitacionce0', 'grupodivision0.habilitacionce0.division0', 'detallecatedra0.docente0'])
                            ->where(['habilitacionce' => $model->grupodivision0->habilitacionce])
                            //->andWhere(['<>', 'habilitacionce.division', $model->grupodivision0->habilitacionce0->division])
                            ->andWhere(['moduloclase' => $model->moduloclase])
                            //->andWhere(['=', 'docente.mail', 'ignacio.ortiz.moran@unc.edu.ar'])
                            ->andWhere(['is', 'detallecatedra', null])
                            ->all();

                    if(count($detalles1)>=3) 
                        return Html::button('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Anotarse', ['value' => Url::to('index.php?r=horarioespecial/detallemodulo/asignardocentemodulos&id='.$model->id), 'class' => 'btn btn-success amodalhorariojs']);
                    
                    return '';

                    
                    
                    
                }
            ],
            
            
        ],
    ]); 
    
       }
    ?>