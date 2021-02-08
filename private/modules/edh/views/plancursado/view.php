<?php

use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Plancursado */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Plancursados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['sidebar'] = [
    'visible' => true,
    'model' => $model->caso0,
    'origen' => 'plan',
];

\yii\web\YiiAsset::register($this);
?>

<?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalplancursado',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
	?>
<div class="plancursado-view">

    <?php 
        $breadcrumbs = [];
        $breadcrumbs [] = ['label' => 'Plan de cursado'];
        //$breadcrumbs [] = $this->title;

    ?>


    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => '< Volver', 'url' => ['index', 'caso' => $model->caso]],
        'links' => $breadcrumbs,
    ]) ?>

   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'descripcion:ntext',
        ],
    ]) ?>

    <?php

    if($dataProvider->getTotalCount()>0){
        $models = $dataProvider->getModels();
        echo '<div class="panel-group" id="accordion">';
        //$ref = 11;
        foreach ($models as $model) {

            $render = $this->render('/detalleplancursado/_pormateria', [
                'model' => $model
            ]);

            if($ref == $model->id)
                $show = 'in';
            else    
                $show = '';
            
            
            echo '<div class="panel panel-default">';
                echo '<div class="panel-heading">';
                echo '<h4 class="panel-title">';
                    echo '<a data-toggle="collapse" data-parent="#accordion" href="#plan'.$model->id.'">';
                    echo $model->catedra0->actividad0->nombre.'</a>';
                    echo '<span class="label label-default pull-right">'.$model->estadodetplan0->nombre.'</span>';
                echo '</h4>';
                echo '</div>';
                echo '<div id="plan'.$model->id.'" class="panel-collapse collapse '.$show.'">';
                    echo '<div class="panel-body">'.$render.'</div>';
                echo '</div>';
            echo '</div>';
            
        }
        echo '</div>';

    }



    ?>


</div>
