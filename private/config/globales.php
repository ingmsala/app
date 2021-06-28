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
	const US_AGENTE = 8;
	const US_PRECEPTOR = 9;
	const US_JUNTA = 10;
	const US_NOVEDADES = 11;
	const US_SACADEMICA = 12;
	const US_COORDINACION = 13;
	const US_SREI = 14;
	const US_HORARIO = 16;
	const US_MANTENIMIENTO = 17;
	const US_NODOCENTE = 18;
	const US_CAE_ADMIN = 19;
	const US_PSC = 20;
	const US_CRON_ANIV = 21;
	const US_GABPSICO = 22;
	const US_VICEACAD = 23;
	const US_DESPACHO = 24;
	const US_CONSULTA_HORARIO = 25;
	const US_CONSULTORIO_MEDICO = 26;
	const US_ABM_AGENTE = 27;
	const US_BECAS = 28;
	const US_SECECONOMICA = 29;
	const US_DIRECCION = 30;
	
	
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

	
	const authttemas = ['msala@unc.edu.ar', 'msala', 'mariano.ferrero@unc.edu.ar', 'carlos.cima@unc.edu.ar', 'fbarros@unc.edu.ar', 'manuarias1@unc.edu.ar', 'ornellabiazzutti@unc.edu.ar', 'cesar.romero@unc.edu.ar', 'sebastian.angilello@unc.edu.ar', 'cecilia.rivero@unc.edu.ar', 'ruben.vargas@unc.edu.ar', 'carlospatoco@unc.edu.ar', 'ernesto.morales@unc.edu.ar', 'miguel.torti@unc.edu.ar', 'mfragueiro@unc.edu.ar', 'sebastian.suarez@unc.edu.ar', 'mariaf.diaz.gavier@unc.edu.ar'];
	const mones = [];
	//const psc = ['msala@unc.edu.ar', 'sandragezmet@unc.edu.ar', 'florencia.leyba@unc.edu.ar', 'florencia.baca@unc.edu.ar', 'rocio.lopez.arzuaga@unc.edu.ar', 'laura.mayorga@unc.edu.ar', 'natalia.diez@unc.edu.ar'];
	//const mones = ['msala@unc.edu.ar', 'gabriela.helale@unc.edu.ar', 'hernan.moya@unc.edu.ar', 'gustavo.carranza@unc.edu.ar', 'nicolas.esparza@unc.edu.ar', 'scenturion@unc.edu.ar'];
	const MAIL2 = 'msala@unc.edu.ar';
	const MAIL = 'info.monserrat@cnm.unc.edu.ar';
	const MAIL3 = 'monserratsistema@gmail.com';
	const PASS_MAIL = 'cdcbwfavjxhlhdgg';
	const PASS_MAIL4 = 'wxljupjiflnhrnbl';
	const PASS_MAIL3 = 'ykecgrklrguvvwgh';
	const PASS_MAIL2 = 'qlztstfribdxemkf';

	const LAYOUT_MAIN = 1;
	const LAYOUT_SOCIOCOMUNITARIOS = 2;
	const LAYOUT_PERSONAL = 3;
	const LAYOUT_ACTIVAR = 4;

	
	public function getLayout($role){
        if(in_array($role, [$this::US_SUPER, $this::US_SECRETARIA, $this::US_REGENCIA, $this::US_PRECEPTORIA, $this::US_CONSULTA, $this::US_DESPACHO,$this::US_CONSULTORIO_MEDICO,$this::US_BECAS, $this::US_SECECONOMICA, $this::US_DIRECCION]))
            return '@app/views/layouts/main';
        elseif(in_array($role, [$this::US_AGENTE, $this::US_PRECEPTOR, $this::US_NODOCENTE]))
            return '@app/views/layouts/mainpersonal';
        elseif(in_array($role, [$this::US_HORARIO]))
            return '@app/views/layouts/mainvacio';
        elseif($role == 0)
            return '@app/views/layouts/mainprint';
        else{
            return '@app/views/layouts/mainactivar';
        }
    }
}




 ?>