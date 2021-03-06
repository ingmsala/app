<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="assets/images/favicon2.ico" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('Autogestión de Estudiantes') ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
 
        NavBar::begin([
            'brandLabel' => '<img src="assets/images/escudo.png" style="display:inline; vertical-align: middle; height:35px;"><span id="brandspan-optativas">Cronograma de Clases 2021</span>',
            //'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-default-personal navbar-fixed-top',
                
            ],
            'brandOptions' => []
        ]);

       
        echo Nav::widget([
            'encodeLabels' => false,
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                        
                
                ['label' => '<center><span class="glyphicon glyphicon-home"></span><br />'.'Divisiones</center>',
                            
                    'url' => ['/horariogenerico/horariogeneric/menudivipublic'],
                    '<div class="dropdown-divider"></div>',
                ],
                
                

                    
                
            ],
        ]);
NavBar::end();
?>
    <div class="container">
            

            
            <div class="col-md-12">
                
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Colegio Nacional de Monserrat <?= date('Y') ?></p>

        
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
