<?php 

namespace app\config;

class Globales

{

	const US_SUPER = 1;
	const US_ADMIN = 2;
	const US_SECRETARIA = 3;
	const US_REGENCIA = 4;
	const US_PRECEPTORIA = 5;
	const US_CONSULTA = 6;
	const US_INGRESO = 7;
	const US_DOCENTE = 8;
	const US_PRECEPTOR = 9;
	const US_JUNTA = 10;
	const US_NOVEDADES = 11;
	const US_SACADEMICA = 12;
	const US_COORDINACION = 13;
	const US_SREI = 14;
	const US_HORARIO = 16;
	const US_MANTENIMIENTO = 17;
	const US_NODOCENTE = 18;
	
	
	const COND_SUPL = 5;
	
	const TURNO_MAN = 1;
	const TURNO_TAR = 2;
	const TURNO_NOC = 3;
	
	const DOC_ACTIVOS = 1;
	const DOC_INACTIVOS = 2;
	
	const CARGO_PREC = 227;
	const CARGO_JEFE = 223;
	
	const LIC_SINGOCE = 2;
	const LIC_VIGENTE = 1;
	
	const DETCAT_ACTIVO = 1;
	const DETCAT_INACTIVO = 2;
	
	const CAT_INACTIVO = 2;
	
	const FALTA_FALTA = 1;
	const FALTA_COMISION = 2;

	const ESTADOINASIST_PREC = 1;
	const ESTADOINASIST_REGRAT = 2;
	const ESTADOINASIST_REGREC = 3;
	const ESTADOINASIST_SECJUS = 4;
	const ESTADOINASIST_SECCON = 5;

	const PADRON_OTROSDOC = [203, 205, 207, 209, 219, 226, 234, 241, 242];

	const TIPO_NOV_X_USS = [[1,2,3,4,5,6,7],[1,4,5],[6],[2,3],[],[7],[7] ];//super, secret admin, secdoc(certificados), vicegestion, vacio, regentes

	const MAIL = 'monserratsistema@gmail.com';
	const PASS_MAIL = 'Monserrat294';


}



 ?>