<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
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
    <link rel="shortcut icon" href="assets/images/favicon1.ico" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('Autogestión de Espacios Optativos') ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php

        NavBar::begin([
            'brandLabel' => '<img src="assets/images/logo-encabezado.png" style="display:inline; vertical-align: middle; height:35px;"><span id="brandspan-autogestion">Autogestión de Espacios Optativos</span>',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-default-autogestion navbar-fixed-top',
                'style' => !isset($_SESSION['dni']) ? 'visibility: hidden' : '',
            ],
            'brandOptions' => []
        ]);
        echo Nav::widget([
            'encodeLabels' => false,
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                        
 
                
                    [
                        'label' => '<span class="glyphicon glyphicon-calendar"></span><div>Agenda de Clases</div>', 
                        'url' => ['autogestion/agenda/index'],
                    ],

                    [
                        'label' => '<span class="glyphicon glyphicon-education"></span><div>Cursadas</div>', 
                        'url' => ['autogestion/inicio/view'],
                    ],

                    [
                        'label' => '<span class="glyphicon glyphicon-check"></span><div>Preinscripciones</div>', 
                        'url' => ['autogestion/preinscripcion'],
                    ],

                    ['label' => '<span class="glyphicon glyphicon-user"></span><br>'.$_SESSION["dni"].'',
                        
                        'items' => [
                                                                                   
                            [
                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                'url' => ['/optativas/autogestion/inicio'],
                                'linkOptions' => ['data-method' => 'post'],
                            
                    
                            ],
                            '<div class="dropdown-divider"></div>',
                            
                         ],
                    ]


                    
                
            ],
        ]);
NavBar::end();
?>
    <div class="container optativas">
            

            <div id="content" class="col-sm-1">
                <div class="row">
                    
                </div>
                <div class="row" style="margin-top: 50px;" id="submenu">
                    <?php

                       echo isset($this->params['submenu']) ? $this->params['submenu'] : '';

                     ?>
                </div>
                    

            </div>
            <div class="col-sm-9">
                
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
