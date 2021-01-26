<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Plancursado */

?>
<div class="plancursado-create">

    
    <?= $this->render('_form', [
        'model' => $model,
        'catedras' => $catedras,
        'modelCatxplan' => $modelCatxplan,
    ]) ?>

</div>
