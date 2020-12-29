<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;
use app\config\Globales;
use app\models\Agente;
use app\models\Docentexdepartamento;

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
        $persona = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        try {
            $depto = Docentexdepartamento::find()->where(['agente' => $persona->id])->count();
        } catch (\Throwable $th) {
            //throw $th;
            $depto = 0;
        }
        
        //$depto = 0;
    ?>

<?php 

if(!Yii::$app->user->isGuest){
    if(Yii::$app->user->identity->role == Globales::US_SUPER){   
        $items = [
                            
            ['label' => '<center><span class="glyphicon glyphicon-time"></span><br />'.'Horarios</center>',
                            
                    'url' => ['/horario/menuopcionespublic'],
                    '<div class="dropdown-divider"></div>',
            ],

            ['label' => '<center><span class="glyphicon glyphicon-modal-window"></span><br />'.'D. Juradas</center>',
                            
                    'url' => ['/declaracionjurada'],
                    '<div class="dropdown-divider"></div>',
            ],

            ['label' => '<center><span class="glyphicon glyphicon-open-file"></span><br />'.'Fonid</center>',
                            
                    'url' => ['/fonid'],
                    '<div class="dropdown-divider"></div>',
            ],
            
            ['label' => '<center><span class="glyphicon glyphicon-education"></span><br />'.'E. Curriculares</center>',
                            
                    'url' => ['/curriculares/menuopciones'],
                    '<div class="dropdown-divider"></div>',
            ],

            ['label' => '<span class="glyphicon glyphicon-user"></span><br />'.Yii::$app->user->identity->role0->nombre.'',
            
                'items' => [

                    [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).'Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 3],
                                           
            
                    ],
                    '<div class="dropdown-divider"></div>',
                    
                                            
                    
                    [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                        'url' => ['/cas/auth/logout'],
                        'linkOptions' => ['data-method' => 'post'],
                    
            
                    ],
                    '<div class="dropdown-divider"></div>',
                    
                ],
            ]

        ];
    }elseif(Yii::$app->user->identity->role == Globales::US_AGENTE){

        if(in_array(Yii::$app->user->identity->username, Globales::authttemas) || $depto>0){
            $ar = ['label' => '<center><span class="glyphicon glyphicon-book"></span><br />'.'Programas</center>',
                            
            'url' => ['/libroclase/programa/actividades'],
            '<div class="dropdown-divider"></div>',
        ]       ;
        }else{
            $ar = '';
        }

        $items = [
                            
            ['label' => '<center><span class="glyphicon glyphicon-time"></span><br />'.'Horarios</center>',
                            
                    'url' => ['/horario/menuopcionespublic'],
                    '<div class="dropdown-divider"></div>',
            ],

            ['label' => '<center><span class="glyphicon glyphicon-modal-window"></span><br />'.'D. Juradas</center>',
                            
                    'url' => ['/declaracionjurada'],
                    '<div class="dropdown-divider"></div>',
            ],

            ['label' => '<center><span class="glyphicon glyphicon-open-file"></span><br />'.'Fonid</center>',
                            
                    'url' => ['/fonid'],
                    '<div class="dropdown-divider"></div>',
            ],
            
            ['label' => '<center><span class="glyphicon glyphicon-education"></span><br />'.'E. Curriculares</center>',
                            
                    'url' => ['/curriculares/menuopciones'],
                    '<div class="dropdown-divider"></div>',
            ],
            $ar,

            

            ['label' => '<span class="glyphicon glyphicon-user"></span><br />'.Yii::$app->user->identity->role0->nombre.'',
            
                'items' => [
                    [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).'Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 3],
                                           
            
                    ],
                    '<div class="dropdown-divider"></div>',                       
                    
                    [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                        'url' => ['/cas/auth/logout'],
                        'linkOptions' => ['data-method' => 'post'],
                    
            
                    ],
                    '<div class="dropdown-divider"></div>',
                    
                ],
            ]

        ];
    
    }elseif(Yii::$app->user->identity->role == Globales::US_PRECEPTOR){
        $items = [
                            
            ['label' => '<center><span class="glyphicon glyphicon-time"></span><br />'.'Horarios</center>',
                            
                    'url' => ['/horario/menuopcionespublic'],
                    '<div class="dropdown-divider"></div>',
            ],

            ['label' => '<span class="glyphicon glyphicon-file"></span><br />'.'Parte',
            
                'items' => [

                    [
                        'label' => 'Parte docente',
                        'url' => ['/parte'],
                                           
            
                    ],
                    '<div class="dropdown-divider"></div>',
                                            
                    
                    [
                        'label' => 'Reporte - Ausencia a trimestrales', 
                        'url' => ['novedadesparte/panelnovedadesprec']
                    ],
                    '<div class="dropdown-divider"></div>',
                    
                ],
            ],

            ['label' => '<center><span class="glyphicon glyphicon-modal-window"></span><br />'.'D. Juradas</center>',
                            
                    'url' => ['/declaracionjurada'],
                    '<div class="dropdown-divider"></div>',
            ],

            ['label' => '<center><span class="glyphicon glyphicon-open-file"></span><br />'.'Fonid</center>',
                            
                    'url' => ['/fonid'],
                    '<div class="dropdown-divider"></div>',
            ],
            
            ['label' => '<center><span class="glyphicon glyphicon-education"></span><br />'.'E. Curriculares</center>',
                            
                    'url' => ['/curriculares/menuopciones'],
                    '<div class="dropdown-divider"></div>',
            ],

            ['label' => '<span class="glyphicon glyphicon-user"></span><br />'.Yii::$app->user->identity->role0->nombre.'',
            
                'items' => [

                    [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).'Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 3],
                                           
            
                    ],
                    '<div class="dropdown-divider"></div>',
                                            
                    
                    [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                        'url' => ['/cas/auth/logout'],
                        'linkOptions' => ['data-method' => 'post'],
                    
            
                    ],
                    '<div class="dropdown-divider"></div>',
                    
                ],
            ]

        ];
    
    }elseif(Yii::$app->user->identity->role == Globales::US_NODOCENTE){
        $items = [
                            
            ['label' => '<center><span class="glyphicon glyphicon-modal-window"></span><br />'.'D. Juradas</center>',
                            
                    'url' => ['/declaracionjurada'],
                    '<div class="dropdown-divider"></div>',
            ],
            
            
            ['label' => '<span class="glyphicon glyphicon-user"></span><br />'.Yii::$app->user->identity->role0->nombre.'',
            
                'items' => [

                    [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).'Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 3],
                                           
            
                    ],
                    '<div class="dropdown-divider"></div>',
                                            
                    
                    [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                        'url' => ['/cas/auth/logout'],
                        'linkOptions' => ['data-method' => 'post'],
                    
            
                    ],
                    '<div class="dropdown-divider"></div>',
                    
                ],
            ]

        ];
    }elseif(Yii::$app->user->identity->role == Globales::US_MANTENIMIENTO){
        $items = [
                            
            ['label' => '<center><span class="glyphicon glyphicon-modal-window"></span><br />'.'Mantenimiento</center>',
                            
                    'url' => ['/tareamantenimiento'],
                    '<div class="dropdown-divider"></div>',
            ],

            ['label' => '<center><span class="glyphicon glyphicon-modal-window"></span><br />'.'D. Juradas</center>',
                            
                    'url' => ['/declaracionjurada'],
                    '<div class="dropdown-divider"></div>',
            ],
            
            
            ['label' => '<span class="glyphicon glyphicon-user"></span><br />'.Yii::$app->user->identity->role0->nombre.'',
            
                'items' => [

                    [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).'Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 3],
                                           
            
                    ],
                    '<div class="dropdown-divider"></div>',
                                            
                    
                    [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                        'url' => ['/cas/auth/logout'],
                        'linkOptions' => ['data-method' => 'post'],
                    
            
                    ],
                    '<div class="dropdown-divider"></div>',
                    
                ],
            ]

        ];
    }
    }else{
        $items = [];
    }

    if(in_array (Yii::$app->user->identity->username, Globales::mones)){
        $it = [['label' => '<center><span class="glyphicon glyphicon-time"></span><br />'.'Mones 2.0</center>',
                            
        'url' => ['/mones/monalumno'],
        '<div class="dropdown-divider"></div>',
        ]];
        array_splice($items,-1,0,$it);
    }
NavBar::begin([
    'brandLabel' => '<img src="assets/images/escudo.png" style="display:inline; vertical-align: middle; height:35px;"><span id="brandspan-optativas">'.$this->title.'</span>',
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
