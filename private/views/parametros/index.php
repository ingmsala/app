<?php

use app\modules\curriculares\models\Aniolectivo;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParametrosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parametros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parametros-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Parametros', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descripcion',
            [
                'label' => 'Estado',
                'value' => function($model){
                    if($model->id == 1){
                        try {
                            $anio = Aniolectivo::findOne($model->estado);
                            return 'Publicado el horario '.$anio->nombre;
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                        return 'No publicado';
                    }
                    return $model->estado;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
