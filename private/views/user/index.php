<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            'id',
            'username',
            [
                'label' => 'Usuario',
                'value' => function($model){
                    if ($model->agente0 != null)
                        return $model->agente0['apellido'].', '.$model->agente0['nombre'];
                    return '';
                },
            ],
            'role0.nombre',
            
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
