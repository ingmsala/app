<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\spinner\Spinner;
use app\models\NotificacionSearch;
use app\config\Globales;
use yii\bootstrap\Modal;
use yii\helpers\Url;

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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

     <?php 
        Modal::begin([
            'header' => "<h2 id='modalHeader'>Notificaciones</h2>",
            'id' => 'modalLarge',
            'size' => 'modal-lg',
            'options' => [
                'tabindex' => false,
            ],
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false] 
        ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>
    
    <?php 

$this->registerJs(
            "$(function() {
               $('#modalButton22 a').click(function(e) {
               e.preventDefault();
               $('.button__badge').hide();
               $('#modalLarge').modal('show')
                 .find('.modal-content')
                 .load($(this).attr('href'));
                 document.getElementById('modalHeader').innerHTML ='Notificaciones';
              });
             });", 
        yii\web\View::POS_HEAD, 'login-modal');

 ?>
    
        <?php 
        
try {
        /*$visi = 'inline';
    if (Yii::$app->user->identity->role == Globales::US_SUPER)
            $tiponovedad = 0;
        elseif(Yii::$app->user->identity->role == Globales::US_SECRETARIA)
            $tiponovedad = 1;
        elseif(Yii::$app->user->identity->role == Globales::US_SACADEMICA)
            $tiponovedad = 2;
        elseif(Yii::$app->user->identity->role == Globales::US_NOVEDADES)
            $tiponovedad = 3;
        else{
            $tiponovedad = 4;
            $visi = 'none';
        }*/
        $ns = new NotificacionSearch(); 
        $cantnot = $ns::providerXuser()->cantidad;
        if($cantnot>0){
            $visi = 'inline';
        }else{
            $visi = 'none';
        }
} catch (Exception $e) {
        $cantnot = 0;
        $visi = 'none';
}
        



?>

    <div class="wrap">
        <?php
        if(!Yii::$app->user->isGuest){
            if(Yii::$app->user->identity->role == Globales::US_SUPER){
                $items = [
                        ['label' => 'Reportes',
                            'items' => [
                        /* ['label' => 'Horas Catedra Secundario', 'url' => ['#']],
                            '<div class="dropdown-divider"></div>',
                        ['label' => 'Horas Catedra Pregrado', 'url' => ['#']],
                            '<div class="dropdown-divider"></div>',
                        ['label' => 'Cargos', 'url' => ['#']],
                            '<div class="dropdown-divider"></div>',
                        ['label' => 'Jefe de Preceptores', 'url' => ['#']],
                            '<div class="dropdown-divider"></div>',
                        */
                            ['label' => 'Preceptores', 'url' => ['/reporte/preceptores']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Listado de Horas por Docente', 'url' => ['/reporte/horasdocentes']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Horas de actividades por Cátedra', 'url' => ['/reporte/horasmateriaxcatedra']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Padrones', 'url' => ['/reporte/padrones/padrones']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Diferencia Planta Doc. y Horario', 'url' => ['/reporte/diferenciahorario']],
                            '<div class="dropdown-divider"></div>',

                            [
                                'label' => 'Parte Docente',
                                'itemsOptions'=>['class'=>'dropdown-submenu'],
                                'submenuOptions'=>['class'=>'dropdown-menu'],
                                'items' => [

                                    ['label' => 'Faltas por mes y año', 'url' => ['/reporte/parte/faltasxmes']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Horas sin dictar por Docentes', 'url' => ['/reporte/parte/faltasdocentes']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Evolucion Faltas por año', 'url' => ['/reporte/parte/faltasxmeses']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Cantidad de Faltas por Turno', 'url' => ['/reporte/parte/faltasxmesesxturno']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Comparación por Turno en un año', 'url' => ['/reporte/parte/faltasxanioxturnototal']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Estado de Justificación de Inasistencias', 'url' => ['/reporte/parte/estadoinasistenciasdocentes']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Distribución de faltas por rango de días', 'url' => ['/reporte/parte/distribuciondediasxmes']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Distribución de faltas por día y hora', 'url' => ['/reporte/parte/distribuciondediasyhoras']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Distribución de faltas por división', 'url' => ['/reporte/parte/faltasxdivision']],
                                    '<div class="dropdown-divider"></div>',

                                ],

                            ],
                            '<div class="dropdown-divider"></div>',    




                        ],
                    ],
                    ['label' => 'Administración',
                            'items' => [

                                ['label' => 'Actividades', 'url' => ['/actividad']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Cátedras', 'url' => ['/catedra']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Cargos', 'url' => ['/cargo']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Condiciones', 'url' => ['/condicion']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Divisiones', 'url' => ['/division']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Docentes', 'url' => ['/docente']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Géneros', 'url' => ['/genero']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Nombramientos de cargo', 'url' => ['/nombramiento']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Plan de estudio', 'url' => ['/plan']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Propuestas Formativas', 'url' => ['/propuesta']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Situacion de Revista', 'url' => ['/revista']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Tipo de Actividad', 'url' => ['/actividadtipo']],
                                ['label' => 'Notificaciones', 'url' => ['/notificacion']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Horarios', 'url' => ['/horario/panelprincipal']],
                                '<div class="dropdown-divider"></div>',
                            ],


                    ],
                    ['label' => 'Parte Docente', 
                            'items' => [
                                
                                ['label' => 'Parte docente', 'url' => ['/parte']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Control de Regencia', 'url' => ['parte/controlregencia']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Control de Secretaría', 'url' => ['parte/controlsecretaria']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Avisos de Inasistencias', 'url' => ['/avisoinasistencia']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Panel de Novedades', 'url' => ['novedadesparte/panelnovedades']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Reporte - Ausencia a trimestrales', 'url' => ['novedadesparte/panelnovedadeshist']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Cronograma de Actividades', 'url' => 'https://docs.google.com/document/d/169GnNluz9iH7UtIfPBgrzqpsSz2_Tt46_KJZtFmN3_Q/edit?usp=sharing'],
                                '<div class="dropdown-divider"></div>',
                                
                            ],
                    ],
                    ['label' => 'Control de Acceso',
                            'items' => [

                                ['label' => 'Visitas', 'url' => ['/panelacceso/acceso']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Visitantes', 'url' => ['/panelacceso/visitante']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Areas', 'url' => ['/panelacceso/area']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Tarjetas', 'url' => ['/panelacceso/tarjeta']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Restringidos', 'url' => ['/panelacceso/restriccion']],
                                '<div class="dropdown-divider"></div>',
                            ],


                    ],
                    ['label' => 'Optativas',
                            'items' => [

                                ['label' => 'Home', 'url' => ['/optativas']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Preinscripción', 'url' => ['/optativas/preinscripcion']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Matrícula', 'url' => ['/optativas/matricula']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Actividades Optativas', 'url' => ['/optativas/optativa']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Alumnos', 'url' => ['/optativas/alumno']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Tipos de clase', 'url' => ['/optativas/tipoclase']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Año Lectivo', 'url' => ['/optativas/aniolectivo']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Estado de Matrícula', 'url' => ['/optativas/estadomatricula']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Interfaz yacaré', 'url' => ['/optativas/interfazyacare']],
                                '<div class="dropdown-divider"></div>',
                                
                            ],
                    ],
                    ['label' => '<span id="button_cont"><i id="glibell" class="glyphicon glyphicon-bell" aria-hidden="true"></i><div style="display:'.$visi.'" class="button__badge">'.$cantnot.'</div></span>', 'url' => ['novedadesparte/panelnovedades']],
                    ['label' => 'Usuario: '.Yii::$app->user->identity->username,
                            
                            'items' => [
                                            ['label' => 'Usuarios', 'url' => ['/user']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Roles', 'url' => ['/role']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Backup', 'url' => ['/db-manager']],
                                            '<div class="dropdown-divider"></div>',

                                            [
                                                'label' => 'Cambiar contraseña',
                                                'url' => ['/user/cambiarpass'],
                                            ],
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/site/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ],
                                            '<div class="dropdown-divider"></div>',
                                
                             ],
                    ],




                ];
            }else if(Yii::$app->user->identity->role == Globales::US_SECRETARIA){

                
                $items = [
                        ['label' => 'Reportes',
                            'items' => [
                        
                            ['label' => 'Preceptores', 'url' => ['/reporte/preceptores']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Listado de Horas por Docente', 'url' => ['/reporte/horasdocentes']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Horas de actividades por Cátedra', 'url' => ['/reporte/horasmateriaxcatedra']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Padrones', 'url' => ['/reporte/padrones/padrones']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Diferencia Planta Doc. y Horario', 'url' => ['/reporte/diferenciahorario']],
                            '<div class="dropdown-divider"></div>',

                            ['label' => 'Horarios', 
                                    'itemsOptions'=>['class'=>'dropdown-submenu'],
                                    'submenuOptions'=>['class'=>'dropdown-menu'],
                                    'items' => [
                                        
                                        ['label' => 'Clases', 'url' => ['horario/panelprincipal']],
                                        '<div class="dropdown-divider"></div>',
                                        
                                        
                                    ],
                            ],

                            [
                                'label' => 'Parte Docente',
                                'itemsOptions'=>['class'=>'dropdown-submenu'],
                                'submenuOptions'=>['class'=>'dropdown-menu'],
                                'items' => [

                                    ['label' => 'Faltas por mes y año', 'url' => ['/reporte/parte/faltasxmes']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Horas sin dictar por Docentes', 'url' => ['/reporte/parte/faltasdocentes']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Evolucion Faltas por año', 'url' => ['/reporte/parte/faltasxmeses']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Cantidad de Faltas por Turno', 'url' => ['/reporte/parte/faltasxmesesxturno']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Comparación por Turno en un año', 'url' => ['/reporte/parte/faltasxanioxturnototal']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Estado de Justificación de Inasistencias', 'url' => ['/reporte/parte/estadoinasistenciasdocentes']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Distribución de faltas por rango de días', 'url' => ['/reporte/parte/distribuciondediasxmes']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Distribución de faltas por día y hora', 'url' => ['/reporte/parte/distribuciondediasyhoras']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Distribución de faltas por división', 'url' => ['/reporte/parte/faltasxdivision']],
                                    '<div class="dropdown-divider"></div>',

                                ],

                            ],
                            '<div class="dropdown-divider"></div>',    




                        ],
                    ],
                    ['label' => 'Administración',
                            'items' => [

                                ['label' => 'Actividades', 'url' => ['/actividad']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Cátedras', 'url' => ['/catedra']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Divisiones', 'url' => ['/division']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Docentes', 'url' => ['/docente']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Nombramientos de cargo', 'url' => ['/nombramiento']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Espacios Optativos', 'url' => ['/optativas']],
                                '<div class="dropdown-divider"></div>',
                                                                
                            ],


                    ],
                    ['label' => 'Parte Docente', 
                            'items' => [
                                
                                ['label' => 'Parte docente', 'url' => ['/parte']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Control de Secretaría', 'url' => ['parte/controlsecretaria']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Panel de Novedades', 'url' => ['novedadesparte/panelnovedades']],
                                '<div class="dropdown-divider"></div>',

                                
                            ],
                    ],
                    
                    ['label' => '<span id="button_cont"><i id="glibell" class="glyphicon glyphicon-bell" aria-hidden="true"></i><div style="display:'.$visi.'" class="button__badge">'.$cantnot.'</div></span>', 'url' => ['novedadesparte/panelnovedades']],
                    ['label' => 'Usuario: '.Yii::$app->user->identity->username,
                            
                            'items' => [
                                            
                                            [
                                                'label' => 'Cambiar contraseña',
                                                'url' => ['/user/cambiarpass'],
                                            ],
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/site/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ],
                                            '<div class="dropdown-divider"></div>',
                                
                             ],
                    ],




                ];


            }else if(Yii::$app->user->identity->role == Globales::US_REGENCIA){

                
                $items = [

                    ['label' => 'Cronograma de Actividades', 'url' => 'https://docs.google.com/document/d/169GnNluz9iH7UtIfPBgrzqpsSz2_Tt46_KJZtFmN3_Q'],
                    
                    ['label' => 'Horarios', 
                            'items' => [
                                
                                ['label' => 'Clases', 'url' => ['horario/panelprincipal']],
                                '<div class="dropdown-divider"></div>',
                                
                                
                            ],
                    ],

                    ['label' => 'Parte Docente', 
                            'items' => [
                                
                                ['label' => 'Parte docente', 'url' => ['/parte']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Control de Regencia', 'url' => ['parte/controlregencia']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Avisos de Inasistencias', 'url' => ['/avisoinasistencia']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Panel de Novedades', 'url' => ['novedadesparte/panelnovedades']],
                                '<div class="dropdown-divider"></div>',
                                
                            ],
                    ],
                    
                    ['label' => '<span id="button_cont"><i id="glibell" class="glyphicon glyphicon-bell" aria-hidden="true"></i><div style="display:'.$visi.'" class="button__badge">'.$cantnot.'</div></span>', 'url' => ['novedadesparte/panelnovedades']],
                    ['label' => 'Usuario: '.Yii::$app->user->identity->username,
                            
                            'items' => [
                                            
                                            [
                                                'label' => 'Cambiar contraseña',
                                                'url' => ['/user/cambiarpass'],
                                            ],
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/site/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ],
                                            '<div class="dropdown-divider"></div>',
                                
                             ],
                    ],




                ];


            }else if(Yii::$app->user->identity->role == Globales::US_SACADEMICA){

                
                $items = [

                    ['label' => 'Cronograma de Actividades', 'url' => 'https://docs.google.com/document/d/169GnNluz9iH7UtIfPBgrzqpsSz2_Tt46_KJZtFmN3_Q'],
                        
                    ['label' => 'Administración', 
                            'items' => [
                                
                                ['label' => 'Parte docente', 'url' => ['/parte']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Control de Sec. Académica', 'url' => ['parte/controlacademica']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Panel de Novedades', 'url' => ['novedadesparte/panelnovedades']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Imprimir certificados', 'url' => ['/']],
                                '<div class="dropdown-divider"></div>',
                                
                            ],
                    ],
                    
                    ['label' => '<span id="button_cont"><i id="glibell" class="glyphicon glyphicon-bell" aria-hidden="true"></i><div style="display:'.$visi.'" class="button__badge">'.$cantnot.'</div></span>', 'url' => ['novedadesparte/panelnovedades']],
                    
                    ['label' => 'Usuario: '.Yii::$app->user->identity->username,
                            
                            'items' => [
                                            
                                            [
                                                'label' => 'Cambiar contraseña',
                                                'url' => ['/user/cambiarpass'],
                                            ],
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/site/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ],
                                            '<div class="dropdown-divider"></div>',
                                
                             ],
                    ],




                ];


            }else if(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){

                
                $items = [

                    ['label' => 'Cronograma de Actividades', 'url' => 'https://docs.google.com/document/d/169GnNluz9iH7UtIfPBgrzqpsSz2_Tt46_KJZtFmN3_Q'],

                    ['label' => 'Horarios', 
                            'items' => [
                                
                                ['label' => 'Clases', 'url' => ['horario/panelprincipal']],
                                '<div class="dropdown-divider"></div>',
                                
                                
                            ],
                    ],
                        
                    ['label' => ' Parte Docente', 
                            'items' => [
                                
                                ['label' => 'Parte docente', 'url' => ['/parte']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Reporte - Ausencia a trimestrales', 'url' => ['novedadesparte/panelnovedadeshist']],
                            ],
                    ],

                    ['label' => '<div id="notinews"><span id="button_cont"><i id="glibell" class="glyphicon glyphicon-bell" aria-hidden="true"></i><div style="display:'.$visi.'" class="button__badge">'.$cantnot.'</div></span></div>', 
                    'url' => ['novedadesparte/notificacionesnuevas'], 
                    'options' => ['id' => 'modalButton22'],
                    ],                   
                    
                    ['label' => 'Usuario: '.Yii::$app->user->identity->username,
                            
                            'items' => [
                                            
                                            [
                                                'label' => 'Cambiar contraseña',
                                                'url' => ['/user/cambiarpass'],
                                            ],
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/site/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ],
                                            '<div class="dropdown-divider"></div>',
                                
                             ],
                    ],




                ];


            }
            else if(Yii::$app->user->identity->role == Globales::US_CONSULTA){

                
                $items = [
                        ['label' => 'Reportes',
                            'items' => [
                        
                            ['label' => 'Preceptores', 'url' => ['/reporte/preceptores']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Listado de Horas por Docente', 'url' => ['/reporte/horasdocentes']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Horas de actividades por Cátedra', 'url' => ['/reporte/horasmateriaxcatedra']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Padrones', 'url' => ['/reporte/padrones/padrones']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Diferencia Planta Doc. y Horario', 'url' => ['/reporte/diferenciahorario']],
                            '<div class="dropdown-divider"></div>',

                            [
                                'label' => 'Parte Docente',
                                'itemsOptions'=>['class'=>'dropdown-submenu'],
                                'submenuOptions'=>['class'=>'dropdown-menu'],
                                'items' => [

                                    ['label' => 'Faltas por mes y año', 'url' => ['/reporte/parte/faltasxmes']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Horas sin dictar por Docentes', 'url' => ['/reporte/parte/faltasdocentes']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Evolucion Faltas por año', 'url' => ['/reporte/parte/faltasxmeses']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Cantidad de Faltas por Turno', 'url' => ['/reporte/parte/faltasxmesesxturno']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Comparación por Turno en un año', 'url' => ['/reporte/parte/faltasxanioxturnototal']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Estado de Justificación de Inasistencias', 'url' => ['/reporte/parte/estadoinasistenciasdocentes']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Distribución de faltas por rango de días', 'url' => ['/reporte/parte/distribuciondediasxmes']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Distribución de faltas por día y hora', 'url' => ['/reporte/parte/distribuciondediasyhoras']],
                                    '<div class="dropdown-divider"></div>',
                                    ['label' => 'Distribución de faltas por división', 'url' => ['/reporte/parte/faltasxdivision']],
                                    '<div class="dropdown-divider"></div>',

                                ],

                            ],
                            '<div class="dropdown-divider"></div>',    




                        ],
                    ],
                    ['label' => 'Administración',
                            'items' => [

                                ['label' => 'Cátedras', 'url' => ['/catedra']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Docentes', 'url' => ['/docente']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Nombramientos de cargo', 'url' => ['/nombramiento']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Espacios Optativos', 'url' => ['/optativas']],
                                '<div class="dropdown-divider"></div>',
                                
                            ],


                    ],

                    ['label' => 'Cronograma de Actividades', 'url' => 'https://docs.google.com/document/d/169GnNluz9iH7UtIfPBgrzqpsSz2_Tt46_KJZtFmN3_Q'],
                    
                    ['label' => 'Parte Docente', 
                            'items' => [
                                
                                ['label' => 'Parte docente', 'url' => ['/parte']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Control de Secretaría', 'url' => ['parte/controlsecretaria']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Panel de Novedades '.$cantnot, 'url' => ['novedadesparte/panelnovedades']],
                                '<div class="dropdown-divider"></div>',
                                
                            ],
                    ],
                    
                    ['label' => '<span id="button_cont"><i id="glibell" class="glyphicon glyphicon-bell" aria-hidden="true"></i><div style="display:'.$visi.'" class="button__badge">'.$cantnot.'</div></span>', 'url' => ['novedadesparte/panelnovedades']],

                    ['label' => 'Usuario: '.Yii::$app->user->identity->username,
                            
                            'items' => [
                                            
                                            [
                                                'label' => 'Cambiar contraseña',
                                                'url' => ['/user/cambiarpass'],
                                            ],
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/site/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ],
                                            '<div class="dropdown-divider"></div>',
                                
                             ],
                    ],




                ];


            }else if(Yii::$app->user->identity->role == Globales::US_INGRESO){
                $items = [
                        
                    ['label' => 'Control de Acceso',
                            'items' => [

                                ['label' => 'Visitas', 'url' => ['/panelacceso/acceso']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Visitantes', 'url' => ['/panelacceso/visitante']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Tarjetas', 'url' => ['/panelacceso/tarjeta']],
                                '<div class="dropdown-divider"></div>',
                                
                            ],


                    ],
                    
                    ['label' => 'Usuario: '.Yii::$app->user->identity->username,
                            
                            'items' => [
                                            
                                            [
                                                'label' => 'Cambiar contraseña',
                                                'url' => ['/user/cambiarpass'],
                                            ],
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/site/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ],
                                            '<div class="dropdown-divider"></div>',
                                
                             ],
                    ],




                ];
            }else if(Yii::$app->user->identity->role == Globales::US_JUNTA){

                
                $items = [
                        
                   [
                            'label' => 'Padrones', 
                            'url' => ['/reporte/padrones/padrones'],
                    ],
                    
                    
                    ['label' => 'Usuario: '.Yii::$app->user->identity->username,
                            
                            'items' => [
                                            
                                            [
                                                'label' => 'Cambiar contraseña',
                                                'url' => ['/user/cambiarpass'],
                                            ],
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/site/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ],
                                            '<div class="dropdown-divider"></div>',
                                
                             ],
                    ],




                ];


            }else if(Yii::$app->user->identity->role == Globales::US_COORDINACION){

                
                $items = [
                        
                   [
                            'label' => 'Espacios Optativos', 
                            'url' => ['/optativas'],
                    ],
                    
                    
                    ['label' => 'Usuario: '.Yii::$app->user->identity->username,
                            
                            'items' => [
                                            
                                           
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/site/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ],
                                            '<div class="dropdown-divider"></div>',
                                
                             ],
                    ],




                ];


            }else if(Yii::$app->user->identity->role == Globales::US_NOVEDADES){

                
                $items = [
                        
                   ['label' => 'Panel de Novedades', 'url' => ['novedadesparte/panelnovedades']],
                          
                          ['label' => '<span id="button_cont"><i id="glibell" class="glyphicon glyphicon-bell" aria-hidden="true"></i><div style="display:'.$visi.'" class="button__badge">'.$cantnot.'</div></span>', 'url' => ['novedadesparte/panelnovedades']],      
                    
                    
                    ['label' => 'Usuario: '.Yii::$app->user->identity->username,
                            
                            'items' => [
                                            
                                            [
                                                'label' => 'Cambiar contraseña',
                                                'url' => ['/user/cambiarpass'],
                                            ],
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/site/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ],
                                            '<div class="dropdown-divider"></div>',
                                
                             ],
                    ],




                ];


            }


        }else{
            $items = [];
        }

        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-default navbar-fixed-top',
                'style' => (Yii::$app->user->isGuest or in_array (Yii::$app->user->identity->role, [8])) ? 'visibility: hidden' : '',
            ],
        ]);
        echo Nav::widget([
            'encodeLabels' => false,
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $items
        ]);
NavBar::end();
?>



<div class="container">

    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?= Alert::widget() ?>
    <?= $content ?>
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
