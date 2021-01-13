<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use kartik\nav\NavX;
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
        $items = [];
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
                            ['label' => 'Docentes teléfonos', 'url' => ['/reporte/telefonos/docentes']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Listado de Horas por Agente', 'url' => ['/reporte/horasdocentes']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Horas de actividades por Cátedra', 'url' => ['/reporte/horasmateriaxcatedra']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Padrones', 'url' => ['/reporte/padrones/padrones']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Tutores', 'url' => ['/estudiantes']],
                            '<div class="dropdown-divider"></div>',
                            

                            [
                                    'label' => 'Horarios',
                                    'itemsOptions'=>['class'=>'dropdown-submenu'],
                                    'submenuOptions'=>['class'=>'dropdown-menu'],
                                    'items' => [
                                        ['label' => 'Horarios de Clase', 'url' => ['/horario/panelprincipal']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Horarios de Trimestrales', 'url' => ['/horarioexamen/panelprincipal', 'col' => 0]],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Coloquios Marzo 2021', 'url' => ['/horarioexamen/panelprincipal',  'col' => 1]],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Horarios Previos', 'url' => ['/turnoexamen']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Administrar Clases Virtuales', 'url' => ['/clasevirtual/panelprincipal']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Cronograma de Clases Virtuales', 'url' => ['/horario/clasesvirtuales']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Diferencia de horas', 'url' => ['/reporte/diferenciahorarioyhoras']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Diferencia Planta Doc. y Horario', 'url' => ['/reporte/diferenciahorario']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Filtro por materia', 'url' => ['/horario/filtropormateria']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Horario completo', 'url' => ['/horario/horariocompleto']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Listado de docentes en horario', 'url' => ['/horario/completodetallado']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Docentes con superposición', 'url' => ['/horario/horassuperpuestas']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Horarios con movilidad deshabilitada', 'url' => ['/horario/deshabilitados']],
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
                                ['label' => 'Cargos', 'url' => ['/cargo']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Condiciones', 'url' => ['/condicion']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Divisiones', 'url' => ['/division']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Agentes', 'url' => ['/agente']],
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
                                ['label' => 'Gestionar Exámenes', 'url' => ['/anioxtrimestral']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Tickets', 'url' => ['/ticket/ticket']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Fonid', 'url' => ['/fonid/fonidadmin']],
                                '<div class="dropdown-divider"></div>',
                                
                                  ['label' => 'Declaraciones Juradas',
                                        'items' => [

                                            ['label' => 'Verificar domicilios (Mapuche)', 'url' => ['/agente/actualizardomicilio']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Lista de Declaraciones', 'url' => ['/declaracionjurada/declaracionesjuradasadmin']],
                                            '<div class="dropdown-divider"></div>',
                                            
                                            
                                        ],


                                ],
                                '<div class="dropdown-divider"></div>',
                                  ['label' => 'Mantenimiento',
                            'items' => [

                                ['label' => 'Tareas', 'url' => ['/tareamantenimiento']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Personal', 'url' => ['/nodocente']],
                                '<div class="dropdown-divider"></div>',
                                
                                
                            ],


                    ],
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
                                ['label' => 'Cronograma', 'url' => 'https://docs.google.com/document/d/169GnNluz9iH7UtIfPBgrzqpsSz2_Tt46_KJZtFmN3_Q/edit?usp=sharing'],
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

                    
                    
                    ['label' => 'E. Curriculares',
                            'items' => [

                                

                                ['label' => 'Optativos',
                                    'itemsOptions'=>['class'=>'dropdown-submenu'],
                                    'submenuOptions'=>['class'=>'dropdown-menu'],
                                    'items' => [
                                

                                        ['label' => 'Home', 'url' => ['/optativas']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Actividades Espaciocurriculares', 'url' => ['/optativas/espaciocurricular']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Matrícula', 'url' => ['/optativas/matricula']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Admisión', 'url' => ['/optativas/admisionoptativa']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Pendientes de inscripción', 'url' => ['/optativas/matricula/pendientes', 'al' => 2]],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Inscriptos por cupos', 'url' => ['/optativas/matricula/inscriptos', 'al' => 2]],
                                        '<div class="dropdown-divider"></div>',
                                
                                    ],
                                ],

                                ['label' => 'Sociocomunitarios',
                                    'itemsOptions'=>['class'=>'dropdown-submenu'],
                                    'submenuOptions'=>['class'=>'dropdown-menu'],
                                    'items' => [

                                        

                                        ['label' => 'Home', 'url' => ['/sociocomunitarios']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Actividades sociocomunitarias', 'url' => ['/sociocomunitarios/espaciocurricular']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Matrícula', 'url' => ['/sociocomunitarios/matricula']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Admisión', 'url' => ['/sociocomunitarios/admisionsociocom']],
                                        '<div class="dropdown-divider"></div>',
                                
                                    ],
                                ],

                                ['label' => 'Administración',
                                    'itemsOptions'=>['class'=>'dropdown-submenu'],
                                    'submenuOptions'=>['class'=>'dropdown-menu'],
                                    'items' => [
                                

                                        
                                        ['label' => 'Preinscripción', 'url' => ['/preinscripcion']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Alumnos', 'url' => ['/curriculares/alumno']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Tipos de clase', 'url' => ['/curriculares/tipoclase']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Año Lectivo', 'url' => ['/curriculares/aniolectivo']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Estado de Matrícula', 'url' => ['/curriculares/estadomatricula']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Interfaz yacaré', 'url' => ['/curriculares/interfazyacare']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Libro de actas', 'url' => ['/curriculares/libroacta']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Escala de notas', 'url' => ['/curriculares/escalanota']],
                                        '<div class="dropdown-divider"></div>',
                                        
                                
                                    ],
                                ],
                            ],

                    ],
                    
                    ['label' => '<span id="button_cont"><i id="glibell" class="glyphicon glyphicon-bell" aria-hidden="true"></i><div style="display:'.$visi.'" class="button__badge">'.$cantnot.'</div></span>', 'url' => ['novedadesparte/panelnovedades']],
                    ['label' => Yii::$app->user->identity->role0->nombre,
                            
                            'items' => [
                                [
                                    'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).' Cambiar rol de usuario',
                                    'url' => ['/rolexuser/cambiar', 'i' => 1],
                                                       
                        
                                ],
                                '<div class="dropdown-divider"></div>',
                                [
                                    'label' => 'Cambiar contraseña',
                                    'url' => ['/user/cambiarpass'],
                                ],
                                '<div class="dropdown-divider"></div>',
                                            ['label' => 'Usuarios', 'url' => ['/user']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Asignar roles', 'url' => ['/rolexuser']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Roles', 'url' => ['/role']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Parametros', 'url' => ['/parametros']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Backup', 'url' => ['/db-manager']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Logs', 'url' => ['/logs']],
                                            '<div class="dropdown-divider"></div>',
                                            
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/cas/auth/logout'],
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
                            ['label' => 'Listado de Horas por Agente', 'url' => ['/reporte/horasdocentes']],
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
                                        ['label' => 'Trimestrales', 'url' => ['/horarioexamen/panelprincipal', 'col' => 0]],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Febrero/Marzo 2021', 'url' => ['/horarioexamen/panelprincipal',  'col' => 1]],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Previas', 'url' => ['/turnoexamen']],
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
                                    /*['label' => 'Estado de Justificación de Inasistencias', 'url' => ['/reporte/parte/estadoinasistenciasdocentes']],*/
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
                                ['label' => 'Agentes', 'url' => ['/agente']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Personal no agente', 'url' => ['/nodocente']],
                                '<div class="dropdown-divider"></div>',                                
                                ['label' => 'Nombramientos de cargo', 'url' => ['/nombramiento']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Espacios Optativos', 'url' => ['/optativas']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Fonid', 'url' => ['/fonid/fonidadmin']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Declaraciones Juradas',
                                        'items' => [

                                            ['label' => 'Verificar domicilios (Mapuche)', 'url' => ['/agente/actualizardomicilio']],
                                            '<div class="dropdown-divider"></div>',
                                            ['label' => 'Lista de Declaraciones', 'url' => ['/declaracionjurada/declaracionesjuradasadmin']],
                                            '<div class="dropdown-divider"></div>',
                                            
                                            
                                        ],


                                ],
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
                    ['label' => Yii::$app->user->identity->role0->nombre,
                            
                            'items' => [
                                            
                                            [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).' Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 1],
                                           
            
                    ],
                    '<div class="dropdown-divider"></div>',
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/cas/auth/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ],
                                            '<div class="dropdown-divider"></div>',
                                
                             ],
                    ],




                ];


            }else if(Yii::$app->user->identity->role == Globales::US_REGENCIA){

                
                $items = [

                    ['label' => 'Cronograma', 'url' => 'https://docs.google.com/document/d/169GnNluz9iH7UtIfPBgrzqpsSz2_Tt46_KJZtFmN3_Q'],

                    ['label' => 'Administración',
                            'items' => [

                                ['label' => 'Gestionar Exámenes', 'url' => ['/anioxtrimestral']],
                                '<div class="dropdown-divider"></div>',
                                [
                                    'label' => 'Espacios Optativos',
                                    'itemsOptions'=>['class'=>'dropdown-submenu'],
                                    'submenuOptions'=>['class'=>'dropdown-menu'],
                                    'items' => [
                                        ['label' => 'Fecha de Inscripción', 'url' => ['/preinscripcion/update', 'id' => 1]],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Pendientes de inscripción', 'url' => ['/optativas/matricula/pendientes', 'al' => 2]],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Inscriptos por cupos', 'url' => ['/optativas/matricula/inscriptos', 'al' => 2]],
                                        '<div class="dropdown-divider"></div>',
                                        
                                        

                                    ],

                                ],
                                ['label' => 'Tutores', 'url' => ['/estudiantes']],
                                        '<div class="dropdown-divider"></div>',
                                ['label' => 'Preceptores', 'url' => ['/reporte/preceptores']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Declaraciones juradas', 'url' => ['/declaracionjurada/declaracionesjuradasadmin']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Contacto Docentes', 'url' => ['/reporte/telefonos/docentes']],
                                '<div class="dropdown-divider"></div>',
                            ],
                    ],
                    
                    ['label' => 'Horarios', 
                            'items' => [
                                
                                ['label' => 'Clases', 'url' => ['horario/panelprincipal']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Trimestrales', 'url' => ['/horarioexamen/panelprincipal', 'col' => 0]],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Coloquios Marzo 2021', 'url' => ['/horarioexamen/panelprincipal',  'col' => 1]],
                                        '<div class="dropdown-divider"></div>',
                                ['label' => 'Febrero/Marzo', 'url' => ['horario/marzo',  'col' => 1]],
                                        '<div class="dropdown-divider"></div>',
                                ['label' => 'Previas', 'url' => ['/turnoexamen']],
                                        '<div class="dropdown-divider"></div>',
                                [
                                    'label' => 'Reportes',
                                    'itemsOptions'=>['class'=>'dropdown-submenu'],
                                    'submenuOptions'=>['class'=>'dropdown-menu'],
                                    'items' => [

                                        ['label' => 'Diferencia de horas', 'url' => ['/reporte/diferenciahorarioyhoras']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Filtro por materia', 'url' => ['/horario/filtropormateria']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Horario completo', 'url' => ['/horario/horariocompleto']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Docentes con superposición', 'url' => ['/horario/horassuperpuestas']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Horarios con movilidad deshabilitada', 'url' => ['/horario/deshabilitados']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Listado de docentes en horario', 'url' => ['/horario/completodetallado']],
                                        '<div class="dropdown-divider"></div>',
                                        

                                    ],

                                ],
                                
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
                                ['label' => 'Ausencia alumnos a trimestrales', 'url' => ['novedadesparte/panelnovedades']],
                                '<div class="dropdown-divider"></div>',
                                [
                                    'label' => 'Reportes',
                                    'itemsOptions'=>['class'=>'dropdown-submenu'],
                                    'submenuOptions'=>['class'=>'dropdown-menu'],
                                    'items' => [
                                        ['label' => 'Horas sin dictar por Docentes', 'url' => ['/reporte/parte/faltasdocentes']],
                                        '<div class="dropdown-divider"></div>',
                                    
                                    ],

                                ],
                                
                            ],
                    ],
                    
                    ['label' => '<span id="button_cont"><i id="glibell" class="glyphicon glyphicon-bell" aria-hidden="true"></i><div style="display:'.$visi.'" class="button__badge">'.$cantnot.'</div></span>', 'url' => ['novedadesparte/panelnovedades']],
                    ['label' => Yii::$app->user->identity->role0->nombre,
                            
                            'items' => [
                                            
                                            [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).' Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 1],
                                           
            
                    ],
                    '<div class="dropdown-divider"></div>',
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/cas/auth/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ],
                                            '<div class="dropdown-divider"></div>',
                                
                             ],
                    ],




                ];


            }else if(Yii::$app->user->identity->role == Globales::US_SACADEMICA){

                
                $items = [

                    ['label' => 'Cronograma', 'url' => 'https://docs.google.com/document/d/169GnNluz9iH7UtIfPBgrzqpsSz2_Tt46_KJZtFmN3_Q'],
                        
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
                    
                    ['label' => Yii::$app->user->identity->role0->nombre,
                            
                            'items' => [
                                            
                                            [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).' Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 1],
                                           
            
                    ],
                    '<div class="dropdown-divider"></div>',
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/cas/auth/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ],
                                            '<div class="dropdown-divider"></div>',
                                
                             ],
                    ],




                ];


            }else if(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){

                
                $items = [

                    ['label' => 'Cronograma', 'url' => 'https://docs.google.com/document/d/169GnNluz9iH7UtIfPBgrzqpsSz2_Tt46_KJZtFmN3_Q'],

                    ['label' => 'Reportes', 
                            'items' => [
                                
                                ['label' => 'Tutores', 'url' => ['/estudiantes']],
                                        '<div class="dropdown-divider"></div>',
                                
                                
                            ],
                    ],
                    
                    ['label' => 'Horarios', 
                            'items' => [
                                
                                ['label' => 'Clases', 'url' => ['horario/panelprincipal']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Trimestrales', 'url' => ['/horarioexamen/panelprincipal', 'col' => 0]],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Febrero/Marzo 2021', 'url' => ['/horarioexamen/panelprincipal',  'col' => 1]],
                                        '<div class="dropdown-divider"></div>',
                                ['label' => 'Previas', 'url' => ['/horario/pdfprevios']],
                                        '<div class="dropdown-divider"></div>', 
                                
                                
                            ],
                    ],
                    
                        
                    ['label' => ' Parte Docente', 
                            'items' => [
                                
                                ['label' => 'Parte docente', 'url' => ['/parte']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Reporte - Ausencia a trimestrales', 'url' => ['novedadesparte/panelnovedadesprec']],
                            ],
                    ],

                    ['label' => '<div id="notinews"><span id="button_cont"><i id="glibell" class="glyphicon glyphicon-bell" aria-hidden="true"></i><div style="display:'.$visi.'" class="button__badge">'.$cantnot.'</div></span></div>', 
                    'url' => ['novedadesparte/notificacionesnuevas'], 
                    'options' => ['id' => 'modalButton22'],
                    ],                   
                    
                    ['label' => Yii::$app->user->identity->role0->nombre,
                            
                            'items' => [
                                            
                                            [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).' Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 1],
                                           
            
                    ],
                    '<div class="dropdown-divider"></div>',
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/cas/auth/logout'],
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
                            ['label' => 'Contacto Docentes', 'url' => ['/reporte/telefonos/docentes']],
                                '<div class="dropdown-divider"></div>',
                            ['label' => 'Listado de Horas por Agente', 'url' => ['/reporte/horasdocentes']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Horas de actividades por Cátedra', 'url' => ['/reporte/horasmateriaxcatedra']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Padrones', 'url' => ['/reporte/padrones/padrones']],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Diferencia Planta Doc. y Horario', 'url' => ['/reporte/diferenciahorario']],
                            '<div class="dropdown-divider"></div>',
                            

                            [
                                    'label' => 'Horarios',
                                    'itemsOptions'=>['class'=>'dropdown-submenu'],
                                    'submenuOptions'=>['class'=>'dropdown-menu'],
                                    'items' => [
                                        ['label' => 'Clases', 'url' => ['horario/panelprincipal']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Trimestrales', 'url' => ['/horarioexamen/panelprincipal', 'col' => 0]],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Febrero/Marzo 2021', 'url' => ['/horarioexamen/panelprincipal',  'col' => 1]],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Previas', 'url' => ['/turnoexamen']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Diferencia de horas', 'url' => ['/reporte/diferenciahorarioyhoras']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Filtro por materia', 'url' => ['/horario/filtropormateria']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Horario completo', 'url' => ['/horario/horariocompleto']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Docentes con superposición', 'url' => ['/horario/horassuperpuestas']],
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
                                    /*['label' => 'Estado de Justificación de Inasistencias', 'url' => ['/reporte/parte/estadoinasistenciasdocentes']],*/
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
                                ['label' => 'Nombramientos de cargo', 'url' => ['/nombramiento']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Espacios Optativos', 'url' => ['/optativas']],
                                '<div class="dropdown-divider"></div>',
                                  ['label' => 'Mantenimiento',
                                    'items' => [

                                        ['label' => 'Tareas', 'url' => ['/tareamantenimiento']],
                                        '<div class="dropdown-divider"></div>',
                                        ['label' => 'Personal', 'url' => ['/nodocente']],
                                        '<div class="dropdown-divider"></div>',
                                
                                
                            ],


                    ],
                                
                            ],


                    ],

                    ['label' => 'Cronograma', 'url' => 'https://docs.google.com/document/d/169GnNluz9iH7UtIfPBgrzqpsSz2_Tt46_KJZtFmN3_Q'],
                    
                    ['label' => 'Parte Docente', 
                            'items' => [
                                
                                ['label' => 'Parte docente', 'url' => ['/parte']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Control de Secretaría', 'url' => ['parte/controlsecretaria']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Panel de Novedades ', 'url' => ['novedadesparte/panelnovedades']],
                                '<div class="dropdown-divider"></div>',
                                
                            ],
                    ],
                    
                    ['label' => '<span id="button_cont"><i id="glibell" class="glyphicon glyphicon-bell" aria-hidden="true"></i><div style="display:'.$visi.'" class="button__badge">'.$cantnot.'</div></span>', 'url' => ['novedadesparte/panelnovedades']],

                    ['label' => Yii::$app->user->identity->role0->nombre,
                            
                            'items' => [
                                            
                                            [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).' Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 1],
                                           
            
                    ],
                    '<div class="dropdown-divider"></div>',
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/cas/auth/logout'],
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
                    
                    ['label' => Yii::$app->user->identity->role0->nombre,
                            
                            'items' => [
                                            
                                            [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).' Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 1],
                                           
            
                    ],
                    '<div class="dropdown-divider"></div>',
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/cas/auth/logout'],
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
                    
                    
                    ['label' => Yii::$app->user->identity->role0->nombre,
                            
                            'items' => [
                                            
                                            [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).' Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 1],
                                           
            
                    ],
                    '<div class="dropdown-divider"></div>',
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/cas/auth/logout'],
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
                            'url' => ['/curriculares'],
                    ],
                    
                    
                    ['label' => Yii::$app->user->identity->role0->nombre,
                            
                            'items' => [
                                            
                                           
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/cas/auth/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ],
                                            '<div class="dropdown-divider"></div>',
                                
                             ],
                    ],




                ];


            }else if(Yii::$app->user->identity->role == Globales::US_NOVEDADES){

                
                $items = [

                    ['label' => 'Mantenimiento',
                            'items' => [

                                ['label' => 'Tareas', 'url' => ['/tareamantenimiento']],
                                '<div class="dropdown-divider"></div>',
                                ['label' => 'Personal', 'url' => ['/nodocente']],
                                '<div class="dropdown-divider"></div>',
                                
                                
                            ],


                    ],
                        
                   ['label' => 'Panel de Novedades', 'url' => ['novedadesparte/panelnovedades']],
                          
                          ['label' => '<span id="button_cont"><i id="glibell" class="glyphicon glyphicon-bell" aria-hidden="true"></i><div style="display:'.$visi.'" class="button__badge">'.$cantnot.'</div></span>', 'url' => ['novedadesparte/panelnovedades']],      
                    
                    
                    ['label' => Yii::$app->user->identity->role0->nombre,
                            
                            'items' => [
                                            
                                            [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).' Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 1],
                                           
            
                    ],
                    '<div class="dropdown-divider"></div>',
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/cas/auth/logout'],
                                                'linkOptions' => ['data-method' => 'post'],
                                            
                                    
                                            ],
                                            '<div class="dropdown-divider"></div>',
                                
                             ],
                    ],




                ];


            }elseif(Yii::$app->user->identity->role == Globales::US_MANTENIMIENTO){

                
                $items = [

                    ['label' => 'Mantenimiento',
                            'items' => [

                                ['label' => 'Tareas', 'url' => ['/tareamantenimiento']],
                                '<div class="dropdown-divider"></div>',
                                
                                
                                
                            ],


                    ],
                        
                                       
                    
                    ['label' => Yii::$app->user->identity->role0->nombre,
                            
                            'items' => [
                                            
                                            [
                        'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-refresh']).' Cambiar rol de usuario',
                        'url' => ['/rolexuser/cambiar', 'i' => 1],
                                           
            
                    ],
                    '<div class="dropdown-divider"></div>',
                                
                                            [
                                                'label' => Html::tag('span', '', ['class'=>'glyphicon glyphicon-log-out']).' Cerrar sesión',
                                                'url' => ['/cas/auth/logout'],
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
        echo NavX::widget([
            'encodeLabels' => false,
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $items,
            //'activateParents' => true,
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
