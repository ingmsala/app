<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\config\Globales;

/* @var $this yii\web\View */
/* @var $model app\models\Hora */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Exámenes previos - Septiembre 2020';



?>
<div>
        
<style type="text/css">
	table.tableizer-table {
		font-size: 12px;
		border: 1px solid #CCC; 
		font-family: Arial, Helvetica, sans-serif;
	} 
	.tableizer-table td {
		padding: 4px;
		margin: 3px;
		border: 1px solid #CCC;
	}
	.tableizer-table th {
		background-color: #104E8B; 
		color: #FFF;
		font-weight: bold;
	}
</style>
<table class="tableizer-table">
<thead><tr class="tableizer-firstrow"><th>FECHA</th><th>ASIGNATURA</th><th>HORARIO</th><th>TRIBUNAL</th></tr></thead><tbody>
 <tr><td>29-sep</td><td>LENGUA Y LITERATURA CASTELLANAS I</td><td>8.00</td><td>ACOSTA, FERNÁNDEZ, V., , FURLAN, TIMOSSI, VOLOJ</td></tr>
 <tr><td>29-sep</td><td>MATEMÁTICA I</td><td>9.00</td><td>TOLEDO - MENOYO- GIMENEZ - YUSZCZYK- ROMERO</td></tr>
 <tr><td>&nbsp;</td><td>MATEMÁTICA III</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>29-sep</td><td>LENGUA Y CULTURA LATINAS I</td><td>13.30</td><td>ROBLEDO, SPINASSI, DIAZ, RUIZ DE LOS LLANOS, S'D'AVILA</td></tr>
 <tr><td>&nbsp;</td><td>LENGUA Y CULTURA LATINAS II</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>29-sep</td><td>GEOGRAFÍA III</td><td>14.00</td><td>CANDELA-FLORES- PEREYRA- BAROFFIO</td></tr>
 <tr><td>&nbsp;</td><td>GEOGRAFÍA IV</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>29-sep</td><td>QUÍMICA I</td><td>14.30</td><td>GUERRERO, NIEVAS,  DI TOFINO, BALANZINO, LAVANDERA</td></tr>
 <tr><td>&nbsp;</td><td>QUÍMICA II</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>01-oct</td><td>LENGUA Y LITERATURA CASTELLANAS II</td><td>8.00</td><td>DELICIA, CACHAGUA, TARBINE, VILLAFAÑE, CARINI</td></tr>
 <tr><td>&nbsp;</td><td>LENGUA Y LITERATURA III</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>&nbsp;</td><td>LENGUA Y LITERATURA V</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>01-oct</td><td>LENGUA Y CULTURA LATINAS III (3 A, B, C, D)</td><td>9.00</td><td>S. D' AVILA, MANCINI, GALÁN, BRICCA, ROBLEDO</td></tr>
 <tr><td>01-oct</td><td>LENGUA Y CULTURA LATINAS III (3 E, F, G, H)</td><td>13.30</td><td>DIAZ, SPINASSI, RIVERO, AGÜERO,</td></tr>
 <tr><td>01-oct</td><td>HISTORIA I</td><td>14.00</td><td>GONZALEZ ACHAVAL, GARCÍA MONTAÑO, SEVERI, FERRINO, DAMIANI</td></tr>
 <tr><td>&nbsp;</td><td>HISTORIA III</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>&nbsp;</td><td>HISTORIA IV</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>&nbsp;</td><td>HISTORIA V</td><td>14.00</td><td>SARTORI, FLORES, GARCIA, OLCESE</td></tr>
 <tr><td>&nbsp;</td><td>HISTORIA VI</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>01-oct</td><td>ESTADÍSTICA Y PROBABILIDADES</td><td>14.30</td><td>LEONETTO, PISONI, YUSZCZYK, MENOYO, GIGENA</td></tr>
 <tr><td>02-oct</td><td>MATEMÁTICA II</td><td>8.00</td><td>LEONETTO - MANZANO- SOSA YUSZCZYK - GIMENEZ</td></tr>
 <tr><td>02-oct</td><td>LENGUA Y CULTURA LATINAS IV (4 A, B, C, D)</td><td>9.00</td><td>RIVERO, SPINASSI,DIAZ, GALAN, S. D' AVILA</td></tr>
 <tr><td>02-oct</td><td>FRANCÉS I</td><td>13.30</td><td>BENAVIDES, GEBAUER, CUEVAS, GATI, FUENTE</td></tr>
 <tr><td>&nbsp;</td><td>FRANCÉS II</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>02-oct</td><td>GEOMETRÍA</td><td>14.00</td><td>ANGELONI, DIPIERRI, TOLEDO, MENOYO, LEONETTO</td></tr>
 <tr><td>02-oct</td><td>LENGUA Y CULTURA LATINAS IV (4 E, F, G, H)</td><td>14.30</td><td>DIAZ, MANCINI, SPINASSI, GALAN, RIVERO</td></tr>
 <tr><td>05-oct</td><td>MATEMÁTICA IV ( 4 A, B, C, D)</td><td>8.00</td><td>ANGELONI, MANZANO, MENOYO, TOLEDO</td></tr>
 <tr><td>05-oct</td><td>MATEMÁTICA IV (4 E, F, G, H)</td><td>8.00</td><td>GUERRA, YUSZCZYK,PISONI, GIGENA</td></tr>
 <tr><td>05-oct</td><td>LENGUA Y CULTURA GRIEGAS I    </td><td>13.30</td><td>YANTORNO, AGÜERO, PALMISANO, BRUSCO, FERRERO, CARLA</td></tr>
 <tr><td>05-oct</td><td>TRIGONOMETRÍA</td><td>14.00</td><td>GOMEZ, GIGENA, ANGELONI, DIPIERRI, HERRERA</td></tr>
 <tr><td>05-oct</td><td>METODOLOGÍA DE LA INVESTIGACIÓN</td><td>14.30</td><td>GOMEZ, SUAREZ, MONTOYA,  VILARÓ</td></tr>
 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>05-oct</td><td>GEOGRAFÍA V</td><td>15.00</td><td>PERALTA - CAEIRO - ZANGHI- BAROFFIO</td></tr>
 <tr><td>06-oct</td><td>ÁLGEBRA</td><td>8.00</td><td>TOLEDO, GIGENA,HERRERA, GUERRA, YUSZCZYK</td></tr>
 <tr><td>06-oct</td><td>LENGUA Y CULTURA GRIEGAS II</td><td>9.00</td><td>SPINASSI, GALAN, DIAZ, AGÜERO, RIVERO</td></tr>
 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>06-oct</td><td>LENGUA Y CULTURA LATINAS V</td><td>9.00</td><td>MANCINI -PALMISANO,  S'D'AVILA - BRICCA - FERRERO, CARLA</td></tr>
 <tr><td>06-oct</td><td>INGLÉS IV</td><td>13.30</td><td>CORNET, BIAZZUTTI, VACA NARVAJA, ALTAMIRANO, DE MONTE</td></tr>
 <tr><td>06-oct</td><td>FORMACIÓN ÉTICA Y CIUDADANA I</td><td>14.00</td><td>TABORDA, RIVERO, BARROS, RAHAL,GARCIA</td></tr>
 <tr><td>&nbsp;</td><td>FORMACIÓN ÉTICA Y CIUDADANA II</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>&nbsp;</td><td>FORMACIÓN ÉTICA Y CÍVICA III</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>07-oct</td><td>FÍSICA I (6A, B, C)</td><td>8.00</td><td>YADAROLA, MARTINEZ, TOLEDO, GIGENA, SCARAFIA</td></tr>
 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>07-oct</td><td>LENGUA Y LITERATURA IV</td><td>9.00</td><td>TARBINE, TEOBALDI, D., CARINI, VOLOJ.</td></tr>
 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>07-oct</td><td>CIENCIAS DE LA VIDA Y DE LA TIERRA</td><td>14.00</td><td>FERRERO, C., BALANZINO,  DIAZ GAVIER, DEMMEL, MALDONADO</td></tr>
 <tr><td>&nbsp;</td><td>CIENCIAS NATURALES III</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>&nbsp;</td><td>BIOLOGÍA II</td><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>07-oct</td><td>FÍSICA I (D, E,F)</td><td>14.30</td><td>YADAROLA, GIGENA, MARTINEZ, TOLEDO,  LEONETTO</td></tr>
</tbody></table>

        
</div>