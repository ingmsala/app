<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;
use app\config\Globales;

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
    
    <?php $this->head() ?>
</head>

    <?php $this->beginBody() ?>

<?php 

if(!Yii::$app->user->isGuest){
    if(Yii::$app->user->identity->role == Globales::US_CAE_ADMIN){
        $items = [

            ['label' => '<span class="glyphicon glyphicon-folder-open"></span><br />'.'Caso'.'',
                                        'items' => [

                                            ['label' => 'Nueva solicitud', 'url' => ['/edh/condicionfinal']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Casos', 'url' => ['/edh/estadocaso']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Estado de solicitud', 'url' => ['/edh/estadosolicitud']],
                                            '<div class="dropdown-divider"></div>',
                                            
                                            
                                        ],


            ],

            ['label' => '<span class="glyphicon glyphicon-cog"></span><br />'.'Administrar'.'',
                                        'items' => [

                                            ['label' => 'Condición final', 'url' => ['/edh/condicionfinal']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Estado de casos', 'url' => ['/edh/estadocaso']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Estado de solicitud', 'url' => ['/edh/estadosolicitud']],
                                            '<div class="dropdown-divider"></div>',
                                            
                                            
                                        ],


            ],
                            
            
            
            
            ['label' => '<span class="glyphicon glyphicon-user"></span><br />'.Yii::$app->user->identity->role0->nombre.'',
            
                'items' => [

                    [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).'Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 5],
                    ],
                                            
                    
                    [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                        'url' => ['/edh/login/logout'],
                        'linkOptions' => ['data-method' => 'post'],
                    
            
                    ],
                    '<div class="dropdown-divider"></div>',
                    
                ],
            ]

        ];
    }else{
        $items = [];
    }
}else{
    $items = [];
}
NavBar::begin([
    'brandLabel' => '<img src="assets/images/escudo.png" style="display:inline; vertical-align: middle; height:35px;"><span id="brandspan-optativas">'.'Sistema de Gestión PEDH'.'</span>',
    //'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-default-personal navbar-fixed-top',
        'style' => Yii::$app->user->isGuest ? 'visibility: hidden' : '',
    ],
    'brandOptions' => []
]);
echo Nav::widget([
    'encodeLabels' => false,
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items
]);
NavBar::end();

?>
       
<div class='wrappersonal'>
    <div class="container">
    <?= Alert::widget() ?>
        <div class="row">
            
            <div class="col-md-12">
                <?= $content ?>
            </div>
            
        </div>
    </div>
</div>

    <?php $this->endBody() ?>

</html>
<?php $this->endPage() ?>
