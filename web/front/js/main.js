$(function(){
	$('#modalButton').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
			document.getElementById('modalHeader').innerHTML ='Agregar Docente a Catedra';
	})
});

$(function(){
	$('.modala').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Modificar Docente de Catedra';
	})
});

$(function(){
	$('#modalButtonNombramiento').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Asignar Suplente a Cargo';
	})
});

$(function(){
	$('.modalaNombramiento').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Modificar Nombramiento';
	})
});

$(function(){
	$('#modalaDetalleParte').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Agregar Ausencia';
	})
});


$(function(){
	$('#modalaNovedadesParte').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Agregar Novedad';
	})
});

$(function(){
	$('#modalaModificarNovedad').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Modificar Novedad';
	})
});

$(function(){
	$('.modalafinfe').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Pasar a historial';
	})
});

$(function(){
	$('.modalaReporteHoras').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		
		
	})
});

$(function(){
	$('.modalaReporteFaltasDocentes').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		
		
	})
});

$(document).on('shown.bs.modal', '.modal', function () {
    $(this).find('[autofocus]').focus();
});

$('body').on('click', '#modalButtonIngreso', function(e) {
	$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
			document.getElementById('modalHeader').innerHTML ='Escaneo de DNI';
			
});


$(function(){
	$('#modalButtonEgreso').click(function(){

		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
			document.getElementById('modalHeader').innerHTML ='Escaneo de Credencial';
			
	})
});

$(function(){
	$('.modalRegencia').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
			document.getElementById('modalHeader').innerHTML ='Rectificación';
	})
});

$(function(){
	$('.modalSecretaria').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
			document.getElementById('modalHeader').innerHTML ='Justificación de inasistencia';
	})
});


$(function(){
	$('#nuevoparte').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		document.getElementById('modalHeader').innerHTML ='Nuevo Parte Docente';
	})
});

$('body').on('click', '#abmdivision', function(e) {
	$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
			document.getElementById('modalHeader').innerHTML ='Asignar División';
			
});

$(document).on('click', '#btnCopiar', function () {


		
        var codigoACopiar = document.getElementById('textoACopiar');    //Elemento a copiar

        //Debe estar seleccionado en la página para que surta efecto, así que...
        var seleccion = document.createRange(); //Creo una nueva selección vacía
        seleccion.selectNodeContents(codigoACopiar);    //incluyo el nodo en la selección
        //Antes de añadir el intervalo de selección a la selección actual, elimino otros que pudieran existir (sino no funciona en Edge)
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(seleccion);  //Y la añado a lo seleccionado actualmente
        try {
            var res = document.execCommand('copy'); //Intento el copiado
            if (res)
                exito();
            else
                fracaso();

            mostrarAlerta();
        }
        catch(ex) {
            excepcion();
        }
        window.getSelection().removeRange(seleccion);
   
});

    
///////
// Auxiliares para mostrar y ocultar mensajes
///////
    var divAlerta = document.getElementById('alerta');
    
    function exito() {
        divAlerta.innerText = '¡¡Código copiado!!';
        divAlerta.classList.add('alert-success');
    }

    function fracaso() {
        divAlerta.innerText = '¡¡Ha fallado el copiado al portapapeles!!';
        divAlerta.classList.add('alert-warning');
    }

    function excepcion() {
        divAlerta.innerText = 'Se ha producido un error al copiar al portapaples';
        divAlerta.classList.add('alert-danger');
    }

    function mostrarAlerta() {
        divAlerta.classList.remove('invisible');
        divAlerta.classList.add('visible');
        setTimeout(ocultarAlerta, 1500);
    }

    function ocultarAlerta() {
        divAlerta.innerText = '';
        divAlerta.classList.remove('alert-success', 'alert-warning', 'alert-danger', 'visible');
        divAlerta.classList.add('invisible');
    }





