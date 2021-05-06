<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\modules\curriculares\models\DocentexcomisionSearch;
use app\modules\curriculares\models\Docentexcomision;
use app\modules\curriculares\models\Matricula;
use app\modules\curriculares\models\Aniolectivo;
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
    <link rel="shortcut icon" href="assets/images/favicon2.ico" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('Gestión de Proyectos Sociocomunitarios') ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        
        if(!Yii::$app->user->isGuest){

            if(Yii::$app->user->identity->role == Globales::US_SUPER){
                $items = [
                                            
                        ['label' => '<span class="glyphicon glyphicon-home"></span><div>Inicio</div>', 'url' => ['/personal/menuprincipal']],
                       
                        ['label' => '<span class="glyphicon glyphicon-book"></span><br>Encuentros', 

                            'items' => [
                                [
                                    'label' => 'Comisión',
                                    'url' => ['/sociocomunitarios/clase', 'cl' => 0],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                [
                                    'label' => 'Agenda',
                                    'url' => ['/sociocomunitarios/clase/claseshoy'],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                

                                
                            
                            ],
                        ],
                        ['label' => '<span class="glyphicon glyphicon-copyright-mark"></span><br>Calificaciones', 

                            'items' => [
                                [
                                    'label' => 'Cargar nota',
                                    'url' => ['/sociocomunitarios/acta/actas', 'cl' => 0],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                [
                                    'label' => 'Cerrar acta',
                                    'url' => ['/sociocomunitarios/acta/actas', 'cl' => 1],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                

                                
                            
                            ],
                        ],
                        ['label' => '<span class="glyphicon glyphicon-folder-open"></span><div>Seguimiento</div>', 'url' => ['/sociocomunitarios/seguimiento']],
                        ['label' => '<span class="glyphicon glyphicon-modal-window"></span><br>Reportes', 

                            'items' => [
                                [
                                    'label' => 'Ficha del Estudiante',
                                    'url' => ['/sociocomunitarios/reportes/fichadelalumno'],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                [
                                    'label' => 'Planilla de Asistencia',
                                    'url' => ['/sociocomunitarios/reportes/planillasistencia'],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                ['label' => 'Listado c/DNI y Fecha de Nacimiento', 'url' => ['/sociocomunitarios/reportes/listadoparasalida']],
                                '<div class="dropdown-divider"></div>',

                                ['label' => 'Datos de Emergencia', 'url' => ['/sociocomunitarios/reportes/listadocontacto']],
                                '<div class="dropdown-divider"></div>',

                                ['label' => 'Mails de tutores', 'url' => ['/sociocomunitarios/reportes/listadomails']],
                                '<div class="dropdown-divider"></div>',

                                ['label' => 'Inasistencias por División', 'url' => ['/sociocomunitarios/reportes/inasistencias']],
                                '<div class="dropdown-divider"></div>',
                                [
                                    'label' => 'Seguimiento por división del secundario',
                                    'url' => ['/sociocomunitarios/reportes/seguimientos'],
                                ],

                                
                            
                            ],



                        ],

                        ['label' => '<span class="glyphicon glyphicon-user"></span><br>'.Yii::$app->user->identity->username.'',
                        
                            'items' => [
                                                           [
                                    'label' => 'Cambiar contraseña',
                                    'url' => ['/user/cambiarpass','i'=>2],
                                ],
                                
                                [
                                    'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                    'url' => ['/cas/auth/logout'],
                                    'linkOptions' => ['data-method' => 'post'],
                                
                        
                                ],
                                '<div class="dropdown-divider"></div>',
                                
                             ],
                        ]
                    
                ];
            }else if(in_array(Yii::$app->user->identity->role, [Globales::US_AGENTE])){
                $items = [
                    
                        ['label' => '<span class="glyphicon glyphicon-home"></span><div>Inicio</div>', 'url' => ['/personal/menuprincipal']],
                        ['label' => '<span class="glyphicon glyphicon-book"></span><div>Clases</div>', 'url' => ['/sociocomunitarios/clase']],
                         ['label' => '<span class="glyphicon glyphicon-copyright-mark"></span><br>Calificaciones', 

                            'items' => [
                                [
                                    'label' => 'Cargar nota',
                                    'url' => ['/sociocomunitarios/acta/actas', 'cl' => 0],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                [
                                    'label' => 'Cerrar acta',
                                    'url' => ['/sociocomunitarios/acta/actas', 'cl' => 1],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                

                                
                            
                            ],
                        ],
                        ['label' => '<span class="glyphicon glyphicon-folder-open"></span><div>Seguimiento</div>', 'url' => ['/sociocomunitarios/seguimiento']],
                        ['label' => '<span class="glyphicon glyphicon-modal-window"></span><br>Reportes', 

                            'items' => [
                                [
                                    'label' => 'Ficha del Estudiante',
                                    'url' => ['/sociocomunitarios/reportes/fichadelalumno'],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                [
                                    'label' => 'Planilla de Asistencia',
                                    'url' => ['/sociocomunitarios/reportes/planillasistencia'],
                                ],
                                [
                                    'label' => 'Seguimiento por división del secundario',
                                    'url' => ['/sociocomunitarios/reportes/seguimientos'],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                

                            
                            ],



                        ],

                        ['label' => '<span class="glyphicon glyphicon-user"></span><br>'.Yii::$app->user->identity->username.'',
                        
                            'items' => [
                                                        
                                
                                [
                                    'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                    'url' => ['/cas/auth/logout'],
                                    'linkOptions' => ['data-method' => 'post'],
                                
                        
                                ],
                                '<div class="dropdown-divider"></div>',
                                
                             ],
                        ]
                    
                ];
            }else if(in_array(Yii::$app->user->identity->role, [Globales::US_PRECEPTOR])){
                $items = [
                    
                        ['label' => '<span class="glyphicon glyphicon-home"></span><div>Inicio</div>', 'url' => ['/personal/menuprincipal']],
                        ['label' => '<span class="glyphicon glyphicon-book"></span><br>Clases', 

                            'items' => [
                                [
                                    'label' => 'Comisión',
                                    'url' => ['/sociocomunitarios/clase', 'cl' => 0],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                [
                                    'label' => 'Agenda',
                                    'url' => ['/sociocomunitarios/clase/claseshoy'],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                

                                
                            
                            ],
                        ],
                        ['label' => '<span class="glyphicon glyphicon-copyright-mark"></span><br>Calificaciones', 

                            'items' => [
                                [
                                    'label' => 'Cargar nota',
                                    'url' => ['/sociocomunitarios/acta/actas', 'cl' => 0],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                [
                                    'label' => 'Cerrar acta',
                                    'url' => ['/sociocomunitarios/acta/actas', 'cl' => 1],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                

                                
                            
                            ],
                        ],
                        ['label' => '<span class="glyphicon glyphicon-folder-open"></span><div>Seguimiento</div>', 'url' => ['/sociocomunitarios/seguimiento']],
                        ['label' => '<span class="glyphicon glyphicon-modal-window"></span><br>Reportes', 

                            'items' => [
                                [
                                    'label' => 'Ficha del Estudiante',
                                    'url' => ['/sociocomunitarios/reportes/fichadelalumno'],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                [
                                    'label' => 'Planilla de Asistencia',
                                    'url' => ['/sociocomunitarios/reportes/planillasistencia'],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                ['label' => 'Datos de Emergencia', 'url' => ['/sociocomunitarios/reportes/listadocontacto']],
                                '<div class="dropdown-divider"></div>',

                                ['label' => 'Mails de tutores', 'url' => ['/sociocomunitarios/reportes/listadomails']],
                                '<div class="dropdown-divider"></div>',

                                ['label' => 'Inasistencias por División', 'url' => ['/sociocomunitarios/reportes/inasistencias']],
                                '<div class="dropdown-divider"></div>',

                            
                            ],



                        ],

                        ['label' => '<span class="glyphicon glyphicon-user"></span><br>'.Yii::$app->user->identity->username.'',
                        
                            'items' => [
                                                           
                                
                                [
                                    'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                    'url' => ['/cas/auth/logout'],
                                    'linkOptions' => ['data-method' => 'post'],
                                
                        
                                ],
                                '<div class="dropdown-divider"></div>',
                                
                             ],
                        ]
                    
                ];
            }else if( in_array (Yii::$app->user->identity->role, [Globales::US_SECRETARIA, Globales::US_CONSULTA, Globales::US_SACADEMICA, Globales::US_PSC])){
                $items = [
                    
                        ['label' => '<span class="glyphicon glyphicon-home"></span><div>Inicio</div>', 'url' => ['/personal/menuprincipal']],
                        ['label' => '<span class="glyphicon glyphicon-book"></span><div>Clases</div>', 'url' => ['/sociocomunitarios/clase']],
                        ['label' => '<span class="glyphicon glyphicon-copyright-mark"></span><br>Calificaciones', 

                            'items' => [
                                [
                                    'label' => 'Cargar nota',
                                    'url' => ['/sociocomunitarios/acta/actas', 'cl' => 0],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                [
                                    'label' => 'Cerrar acta',
                                    'url' => ['/sociocomunitarios/acta/actas', 'cl' => 1],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                

                                
                            
                            ],
                        ],
                        ['label' => '<span class="glyphicon glyphicon-folder-open"></span><div>Seguimiento</div>', 'url' => ['/sociocomunitarios/seguimiento']],
                        ['label' => '<span class="glyphicon glyphicon-modal-window"></span><br>Reportes', 

                            'items' => [
                                [
                                    'label' => 'Ficha del Estudiante',
                                    'url' => ['/sociocomunitarios/reportes/fichadelalumno'],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                [
                                    'label' => 'Planilla de Asistencia',
                                    'url' => ['/sociocomunitarios/reportes/planillasistencia'],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                ['label' => 'Listado c/DNI y Fecha de Nacimiento', 'url' => ['/sociocomunitarios/reportes/listadoparasalida']],
                                '<div class="dropdown-divider"></div>',

                                ['label' => 'Datos de Emergencia', 'url' => ['/sociocomunitarios/reportes/listadocontacto']],
                                '<div class="dropdown-divider"></div>',

                                 ['label' => 'Mails de tutores', 'url' => ['/sociocomunitarios/reportes/listadomails']],
                                '<div class="dropdown-divider"></div>',

                                ['label' => 'Inasistencias por División', 'url' => ['/sociocomunitarios/reportes/inasistencias']],
                                '<div class="dropdown-divider"></div>',

                            
                            ],



                        ],

                        ['label' => '<span class="glyphicon glyphicon-user"></span><br>'.Yii::$app->user->identity->username.'',
                        
                            'items' => [
                                                           [
                                    'label' => 'Cambiar contraseña',
                                    'url' => ['/user/cambiarpass','i'=>2],
                                ],
                                
                                [
                                    'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                    'url' => ['/cas/auth/logout'],
                                    'linkOptions' => ['data-method' => 'post'],
                                
                        
                                ],
                                '<div class="dropdown-divider"></div>',
                                
                             ],
                        ]
                    
                ];
            }else if(Yii::$app->user->identity->role == Globales::US_COORDINACION){
                $items = [
                    
                        ['label' => '<span class="glyphicon glyphicon-home"></span><div>Inicio</div>', 'url' => ['/personal/menuprincipal']],
                        ['label' => '<span class="glyphicon glyphicon-book"></span><div>Clases</div>', 'url' => ['/sociocomunitarios/clase']],
                        ['label' => '<span class="glyphicon glyphicon-copyright-mark"></span><br>Calificaciones', 

                            'items' => [
                                [
                                    'label' => 'Cargar nota',
                                    'url' => ['/sociocomunitarios/acta/actas', 'cl' => 0],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                [
                                    'label' => 'Cerrar acta',
                                    'url' => ['/sociocomunitarios/acta/actas', 'cl' => 1],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                

                                
                            
                            ],
                        ],
                        ['label' => '<span class="glyphicon glyphicon-folder-open"></span><div>Seguimiento</div>', 'url' => ['/sociocomunitarios/seguimiento']],
                        ['label' => '<span class="glyphicon glyphicon-modal-window"></span><br>Reportes', 

                            'items' => [
                                [
                                    'label' => 'Ficha del Estudiante',
                                    'url' => ['/sociocomunitarios/reportes/fichadelalumno'],
                                ],
                            
                                '<div class="dropdown-divider"></div>',

                                [
                                    'label' => 'Planilla de Asistencia',
                                    'url' => ['/sociocomunitarios/reportes/planillasistencia'],
                                ],

                                ['label' => 'Inasistencias por División', 'url' => ['/sociocomunitarios/reportes/inasistencias']],
                                '<div class="dropdown-divider"></div>',
                            
                                '<div class="dropdown-divider"></div>',

                                                            
                            ],



                        ],

                        ['label' => '<span class="glyphicon glyphicon-user"></span><br>'.Yii::$app->user->identity->username.'',
                        
                            'items' => [

                                 [
                                    'label' => 'Perfil Administración',
                                    'url' => ['/horario/menuopciones'],
                                ],
                                                           [
                                    'label' => 'Cambiar contraseña',
                                    'url' => ['/user/cambiarpass','i'=>2],
                                ],
                                
                                [
                                    'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                    'url' => ['/cas/auth/logout'],
                                    'linkOptions' => ['data-method' => 'post'],
                                
                        
                                ],
                                '<div class="dropdown-divider"></div>',
                                
                             ],
                        ]
                    
                ];
            }else if(Yii::$app->user->identity->role == Globales::US_SREI){
                $items = [
                    
                        ['label' => '<span class="glyphicon glyphicon-home"></span><div>Inicio</div>', 'url' => ['/personal/menuprincipal']],

                        ['label' => '<span class="glyphicon glyphicon-book"></span><div>Clases</div>', 'url' => ['/sociocomunitarios/clase']],
                        
                        ['label' => '<span class="glyphicon glyphicon-modal-window"></span><br>Reportes', 

                            'items' => [
                                
                                        ['label' => 'Listado c/DNI y Fecha de Nacimiento', 'url' => ['/sociocomunitarios/reportes/listadoparasalida']],
                                '<div class="dropdown-divider"></div>',

                                ['label' => 'Datos de Emergencia', 'url' => ['/sociocomunitarios/reportes/listadocontacto']],
                                '<div class="dropdown-divider"></div>',

                                 ['label' => 'Mails de tutores', 'url' => ['/sociocomunitarios/reportes/listadomails']],
                                '<div class="dropdown-divider"></div>',
                                                            
                            ],



                        ],

                        ['label' => '<span class="glyphicon glyphicon-user"></span><br>'.Yii::$app->user->identity->username.'',
                        
                            'items' => [
                                                           [
                                    'label' => 'Cambiar contraseña',
                                    'url' => ['/user/cambiarpass','i'=>2],
                                ],
                                
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




            else{
                $items = ['items' => [
                        
                        ['label' => '']
                ]];
            }
        }else{
            $items = [
                        ['label' => '']
                ];
        }

        NavBar::begin([
            'brandLabel' => '<img src="assets/images/escudo.png" style="display:inline; vertical-align: middle; height:35px;"><span id="brandspan-optativas">Gestión de Proyectos Sociocomunitarios</span>',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-default-sociocomunitarios navbar-fixed-top',
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
    <div class="container optativas">
            

            <div id="content" class="col-sm-3">
                <div class="row">
                    <?php $search= new DocentexcomisionSearch() ?>
                    <?php 

                    if(Yii::$app->request->get('r')!='user/cambiarpass'){

                        echo $this->render('/comision/_comisionxdocente',
                            [
                                'dataProvider' => $search->providerxdocente(Yii::$app->user->identity->username,2),
                                'comisiones' => $search->comisionesxdocente(Yii::$app->user->identity->username,2),
                                'model' => new Docentexcomision(),
                                'model2' => new Matricula(),
                                'aniolectivos' => Aniolectivo::find()/*->where(['activo' => 1])*/->orderBy('id DESC')->all(),
                                'anioactivo' => Aniolectivo::find()->where(['activo' => 1])->one(),
                            ]);
                    }
                    ?>
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
