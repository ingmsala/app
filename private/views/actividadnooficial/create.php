<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Actividadnooficial */

$this->title = 'Nuevo Actividadnooficial';
$this->params['breadcrumbs'][] = ['label' => 'Actividadnooficials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actividadnooficial-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelhorario' => $modelhorario,
        
        
    ]) ?>

</div>
