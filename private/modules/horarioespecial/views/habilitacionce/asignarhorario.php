<?php

use yii\bootstrap\Modal;

Modal::begin([
            'header' => "<h2 id='modalHeader'></h2>",
            'id' => 'modalpasividad',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>

<?php
    echo $echodiv;
?>