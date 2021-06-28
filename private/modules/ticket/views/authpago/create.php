<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Authpago */



?>
<div class="well" style="margin:28px;">



    <?= $this->render('_form', [
        'modelauth' => $modelauth,
        'estados' => $estados,
        'proveedores' => $proveedores,
    ]) ?>

</div>
