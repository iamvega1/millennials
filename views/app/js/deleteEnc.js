$(document).ready(function() {
	$('#tblListEnc tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
        	$('.btnConfig').addClass('disabled');
            $(this).removeClass('selected');
        }
        else {
            tblEnc.$('tr.selected').removeClass('selected');
            $('.btnConfig').removeClass('disabled');
            $(this).removeClass('odd');
            $(this).addClass('selected');
        }
    });
	var divFilter = $('#tblListEnc_filter');
	divFilter.css({
	'display': 'flex',
	'justify-content': 'space-between'
	});
	var html = '<button type="button" data-toggle="modal" data-target="#deleteComprobar" class="btn btnConfig disabled" style="border-radius: 7px;"><span class="glyphicon glyphicon-remove"></span>Eliminar</button>';
	var div = document.createElement('div');
	div.innerHTML = html;
	divFilter.prepend(div);
});

var deleteEnc = function (element) {
	var enc = tblEnc.row('.selected').data()[0];
	if(enc != '') {  
		    
		form = 'encuesta=' + enc;
		connect = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

		connect.onreadystatechange = function(){
		  if(connect.readyState == 4 && connect.status == 200) {
		    if(connect.responseText == 1) {
		      result = '<div class="alert alert-dismissible alert-success">';
		      result += ' <button type="button" class="close" data-dismiss="alert">x</button>';
		      result += '<h4>Estatus del proceso!</h4>';
		      result += '<p><strong>Se completo la solicitud</strong></p>';
		      result += '</div>';
		      __('_messages_info_enc_').innerHTML = result;
		      tblEnc.row('.selected').remove().draw( false );
		      $('.btnConfig').addClass('disabled');
		    } else {
		      __('_messages_info_enc_').innerHTML = connect.responseText;
		    }  
		  } else if(connect.readyState != 4) {
		    result = '<div class="alert alert-dismissible alert-warning">';
		    result += '<button type="button" class="close" data-dismiss="alert">x</button>';
		    result += '<h4>Estatus del proceso</h4>';
		    result += '<p><strong>Estamos Procesando tu solicitud....</strong></p>';
		    result += '</div>';
		    __('_messages_info_enc_').innerHTML = result;
		  }
		}
		connect.open('POST','ajax.php?mode=encDelete',true);
		connect.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		connect.send(form);	
	}
}