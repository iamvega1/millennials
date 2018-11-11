var tblUsers = $('#tblListUsers').DataTable( {
    "scrollX": true,
    "language": {
        "sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "NingÃºn dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Ãšltimo",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}
    }
});

$(document).ready(function() {
	$('#tblListUsers tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
        	$('.btnConfig').addClass('disabled');
            $(this).removeClass('selected');
        }
        else {
            tblUsers.$('tr.selected').removeClass('selected');
            $('.btnConfig').removeClass('disabled');
            $(this).removeClass('odd');
            $(this).addClass('selected');
        }
    });
	var divFilter = $('#tblListUsers_filter');
	divFilter.css({
	'display': 'flex',
	'justify-content': 'space-between'
	});
	var html = '<button id="btnAgregar" onClick="limpiarInputs();" data-toggle="modal" data-target="#AgregarUser" type="button" class="btn" style="border-radius: 7px; margin-right: 10px;"><span class="glyphicon glyphicon-plus"></span>Agregar</button>';
	html += '<button type="button" onClick="editUser(this)" class="btn btnConfig disabled" style="border-radius: 7px; margin-right: 10px;"> <span class="glyphicon glyphicon-edit"></span>Editar</button>';
	html += '<button type="button" data-toggle="modal" data-target="#deleteComprobar" class="btn btnConfig disabled" style="border-radius: 7px;"><span class="glyphicon glyphicon-remove"></span>Eliminar</button>';
	var div = document.createElement('div');
	div.innerHTML = html;
	divFilter.prepend(div);
});

var deleteUser = function (element) {
	var user = tblUsers.row('.selected').data()[0];
	if(user != '') {  
		    
		form = 'user=' + user;
		connect = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

		connect.onreadystatechange = function(){
		  if(connect.readyState == 4 && connect.status == 200) {
		    if(connect.responseText == 1) {
		      result = '<div class="alert alert-dismissible alert-success">';
		      result += ' <button type="button" class="close" data-dismiss="alert">x</button>';
		      result += '<h4>Estatus del proceso!</h4>';
		      result += '<p><strong>Se completo la solicitud</strong></p>';
		      result += '</div>';
		      __('_messages_info_users_').innerHTML = result;
		      tblUsers.row('.selected').remove().draw( false );
		      $('.btnConfig').addClass('disabled');
		    } else {
		      __('_messages_info_users_').innerHTML = connect.responseText;
		    }  
		  } else if(connect.readyState != 4) {
		    result = '<div class="alert alert-dismissible alert-warning">';
		    result += '<button type="button" class="close" data-dismiss="alert">x</button>';
		    result += '<h4>Estatus del proceso</h4>';
		    result += '<p><strong>Estamos Procesando tu solicitud....</strong></p>';
		    result += '</div>';
		    __('_messages_info_users_').innerHTML = result;
		  }
		}
		connect.open('POST','ajax.php?mode=userDelete',true);
		connect.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		connect.send(form);	
	}
}
var editUser = function (element) {
	var dataUser = tblUsers.row('.selected').data();
	$('#btnAgregar').click();
	__('user_reg').value = dataUser[0];
	__('user_reg').disabled = true;
	__('tipoRol').value = dataUser[1] == 'Admin' ? '1' : dataUser[1] == 'Encuestador' ? '2' : '3';
	__('pass_reg').value = dataUser[5];
	__('pass_reg_dos').value = dataUser[5];
	__('user_name_reg').value = dataUser[3];
	__('user_ape_reg').value = dataUser[4];
	__('user_mat_reg').value = dataUser[5];
	__('user_cod_reg').value = dataUser[8];
	__('user_date_reg').value = dataUser[10];
	__('rbtnm').checked = dataUser[9] == 'Hombre' ? true : false;
	__('rbtnh').checked = dataUser[9] == 'Mujer' ? true : false;
	$('#registrarme').hide();
	$('#btnActUser').show();

	//console.log(dataUser);
}
function limpiarInputs() {
	__('user_reg').value = '';
	__('user_reg').disabled = false;
	__('tipoRol').value = '3';
	__('pass_reg').value = '';
	__('pass_reg_dos').value = '';
	__('user_name_reg').value = '';
	__('user_ape_reg').value = '';
	__('user_mat_reg').value = '';
	__('user_cod_reg').value = '';
	__('user_date_reg').value = '';
	__('rbtnm').checked =  false;
	__('rbtnh').checked =  true;
	$('#btnActUser').hide(); // oculto
	$('#registrarme').show(); // muestro
}
var goActualizar = function () {
	var connect, form, response, result, 
	user, pass, pass_dos, name, ape_paterno, 
	ape_materno, cp, fec_nac, sexo, rol;

	user = __('user_reg').value;
	pass = __('pass_reg').value;
	rol = __('tipoRol').length ? __('tipoRol').value : '3';
	pass_dos = __('pass_reg_dos').value;
	name = __('user_name_reg').value;
	ape_paterno = __('user_ape_reg').value;
	ape_materno = __('user_mat_reg').value;
	cp = __('user_cod_reg').value;
	fec_nac = __('user_date_reg').value;
	sexo = __('rbtnm').checked == true ? 1 : 2; //con ID VERIFICAR SI ESTA BIEN DECLARADO!!
	//registrarse = __('registrarse_reg').value;

	if(user != '' && pass != '' && pass_dos != '' && name != '' && 
	ape_paterno != '' && ape_materno != '' && cp != '' &&  fec_nac != '' && sexo != '') {
	  if (pass == pass_dos){
	    
	    form = 'user=' + user + '&pass=' + pass + '&pass_dos=' + pass_dos +'&name=' + name + '&ape_paterno=' + ape_paterno + '&ape_materno=' + ape_materno + '&cp=' + cp + '&fec_nac=' + fec_nac + '&sexo=' + sexo + '&rol=' + rol;
	    connect = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	 
	    connect.onreadystatechange = function(){
	      if(connect.readyState == 4 && connect.status == 200) {
	        if(connect.responseText == 1) {
	          result = '<div class="alert alert-dismissible alert-success">';
	          result += '<h4>Registro completado!</h4>';
	          result += '<p><strong>Estamos redireccionandote...</strong></p>';
	          result += '</div>';
	          __('_messages_info_').innerHTML = result;
	          location.reload();
	        } else {
	          __('_messages_info_').innerHTML = connect.responseText;
	        }  
	      } else if(connect.readyState != 4) {
	        result = '<div class="alert alert-dismissible alert-warning">';
	        result += '<button type="button" class="close" data-dismiss="alert">x</button>';
	        result += '<h4>Procesando...</h4>';
	        result += '<p><strong>Estamos Procesando tu Registro....</strong></p>';
	        result += '</div>';
	        __('_messages_info_').innerHTML = result;
	      }
	    }
	    connect.open('POST','ajax.php?mode=act',true);
	    connect.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	    connect.send(form);
	} else {
	  result = '<div class="alert alert-dismissible alert-danger">';
	  result += '<button type="button" class="close" data-dismiss="alert">x</button>';
	  result += '<p><strong>Las contraseñas no coinciden....</strong></p>';
	  result += '</div>';
	  __('_messages_info_').innerHTML = result;
	}
	} else {
	  result = '<div class="alert alert-dismissible alert-danger">';
	  result += '<button type="button" class="close" data-dismiss="alert">x</button>';
	  result += '<p><strong>Todos los campos deben estar llenos....</strong></p>';
	  result += '</div>';
	  __('_messages_info_').innerHTML = result;
	}
}