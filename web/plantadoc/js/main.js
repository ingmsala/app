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





