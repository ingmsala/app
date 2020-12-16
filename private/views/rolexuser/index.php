<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolexuserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles por usuario';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rolexuser-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo rol', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

                        
            [
                'label' => "Usuario",
                'attribute' => 'nameusername',
                'value' => function($model){
                    return $model->user0->username;
                }
            ],
            'role0.nombre',
            'subrole',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
