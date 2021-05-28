<?php

use yii\helpers\Html;


?>
<div class="becaconviviente-create">

    <?= $this->render('_form', [
        'model' => $model,
        'ocupaciones' => $ocupaciones,
        'nivelestudio' => $nivelestudio,
        'ayudasestatal' => $ayudasestatal,
        
        'parentescos' => $parentescos,
    ]) ?>

</div>
