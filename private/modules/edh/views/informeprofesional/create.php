<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Informeprofesional */


?>
<div class="informeprofesional-create">



    <?= $this->render('_form', [
        'model' => $model,
        'areas' => $areas,
        'origen' => 'create',
    ]) ?>

</div>
