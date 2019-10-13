<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Anioxtrimestral */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Anioxtrimestrals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anioxtrimestral-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php 

        echo $this->render('horarioexamen/index', [
            'anioxtrim' => $model->id,
        ]);
    

    ?>

</div>
