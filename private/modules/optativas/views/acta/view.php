<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Acta */

$this->title = $model->id;

?>
<div class="acta-view">

    <div class="escalanota-view">

        <?= $this->render('/detalleacta/agregaralumnos', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'dataProviderDetacta' => $dataProviderDetacta,
            'cantsinacta' => $cantsinacta,
            'cantenacta' => $cantenacta,

        ]) ?>

    </div>

</div>
