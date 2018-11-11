function goReg() {
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
        connect.open('POST','ajax.php?mode=reg',true);
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
 
function runScriptReg(e) {
  if(e.keyCode == 13) {
    goReg();
  }
}
