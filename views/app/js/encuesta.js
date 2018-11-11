var ec, gDivBase, contBtn = 0;
var page = (function () {
	var initialize = function () {
		gDivBase = __('respuestas').firstElementChild.cloneNode(true);
		fade(__('btnTerminar'));
	}
	return {
        init: initialize
    }
})();

page.init();	

function iniEncuesta() {
	var nomEn, divEc;
	nomEn = __('nom_encuesta').value;
	if(nomEn != ""){
		form = 'name=' + nomEn + '&proceso=init';
  		connect = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  		connect.onreadystatechange = function() {
	    if(connect.readyState == 4 && connect.status == 200) {
	      if(connect.responseText == 1) {
	        ec = new Encuesta(nomEn);
			divEc = __('iniEnc');
			fade(divEc);
			unfade(__('iniPreg'));
			__('title_encuesta').innerHTML = nomEn.toUpperCase();

	      } else {
	        __('title_aviso_enc').innerHTML = connect.responseText;
	      }
	    } else if(connect.readyState != 4) {
	      result = '<div class="alert alert-dismissible alert-warning">';
	      result += '<button type="button" class="close" data-dismiss="alert">x</button>';
	      result += '<h4>Procesando...</h4>';
	      result += '<p><strong>Estamos comprobando la disponibilidad del nombre de la encuesta....</strong></p>';
	      result += '</div>';
	      __('title_aviso_enc').innerHTML = result;
	    }
	  }
	  connect.open('POST','ajax.php?mode=encuesta',true);
	  connect.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	  connect.send(form);
	}
}

function goPregunta() {
	var preg = new Pregunta(__('txtPreg').innerHTML);
	var divRes = __('respuestas');
	for(var i = 0; i < divRes.children.length; i++){
		var lb = divRes.children[i].lastElementChild;
		if(lb.innerHTML != ""){
			preg.addRes(lb.innerHTML);
		}
	}
	preg.setTipo();
	ec.addPreg(preg);
	form = 'proceso=addPreg&datos=' + JSON.stringify(preg);
  		connect = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  		connect.onreadystatechange = function() {
	    if(connect.readyState == 4 && connect.status == 200) {
	      if(connect.responseText == 1) {
	        inicializarPreg();

	      } else {
	        __('title_aviso_preg').innerHTML = connect.responseText;
	      }
	    } else if(connect.readyState != 4) {
	      result = '<div class="alert alert-dismissible alert-warning">';
	      result += '<button type="button" class="close" data-dismiss="alert">x</button>';
	      result += '<h4>Procesando...</h4>';
	      result += '<p><strong>Estamos guardando la nueva pregunta espere un momento....</strong></p>';
	      result += '</div>';
	      __('title_aviso_preg').innerHTML = result;
	    }
	  }
	  connect.open('POST','ajax.php?mode=encuesta',true);
	  connect.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	  connect.send(form);
}

function runScriptinit(e) {

  if(e.keyCode == 13) {
    iniEncuesta();
  }
}

function runScriptNewPreg(e) {
	var divPreg, preg, i;
	i = ec.preguntas.length + 1;
	__('txtPreg').innerHTML = i + '.- ' + e.target.value;	
}

function runScriptNewRes(e) {
	if (e.target.value == '') {return false;}
	var tipo, divTip;
	tipo = __('tipoRes').value;
	switch(tipo){
		case '1':
		case '2':
			createRes(e);
		break;
		case '3':
			createResDrag(e);
		break;
		default:
		break;
	};

	if(e.keyCode == 13) {
		__('respuestas').appendChild(gDivBase.cloneNode(true));
		e.target.value = '';
		if (contBtn == 0){
			unfade(__('btnAgregar'));		
		}			
		contBtn++;
		createLabel(__('respuestas').children);
	}
}
function createResDrag(e) {
	var divRes, element;
	divRes = __('lstResDrag');
	element = divRes.lastElementChild;
	element.innerHTML = e.target.value;
	createRes(e);
}
function createRes(e) {
	var divRes, element, elementInput, elementLabel;
	divRes = __('respuestas');
	element = divRes.lastElementChild;
	elementInput = element.firstElementChild;
	elementLabel = element.lastElementChild;
	elementInput.id = "res." + (ec.preguntas.length + 1) + "." + (contBtn + 1);
	elementInput.setAttribute('name', "res." + (ec.preguntas.length + 1));
	elementLabel.setAttribute('for', "res." + (ec.preguntas.length + 1) + "." + (contBtn + 1));
	elementLabel.innerHTML = e.target.value;
}
function replaceTip(list, name) {
	var lenghtList = list.length;
	for (var i = 0; i < lenghtList; i++) {
		list[i].className = name;
		list[i].firstElementChild.type = name;
	}
}
function runScriptChangeTipo(e) {
	var name, listRes = __('respuestas').children;
	switch(e.target.value){
		case '1':
			name = 'radio';
			replaceTip(listRes, name);
			replaceTip([gDivBase], name);
			fade(__('divDrag'));
			unfade(__('respuestas'));
		break;
		case '2':
			name = 'checkbox';
			replaceTip(listRes, name);
			replaceTip([gDivBase], name);
			fade(__('divDrag'));
			unfade(__('respuestas'));
		break;
		case '3':
			fade(__('respuestas'));
			unfade(__('divDrag'));
			createLabel(listRes);
		break;
		default:
		break;
	}
	//gDivBase.className = 'checkbox';
	//alert('cambio');
}

function createLabel(list) {
	var lenghtList = list.length;
	var lst = __('lstResDrag');
	while(lst.hasChildNodes()){
		lst.removeChild(lst.firstChild);	
	}

	for (var i = 0; i < lenghtList; i++) {
		var lb = document.createElement('label');
		lb.className = 'list-group-item label';
		lb.style['color'] = 'black';
		lb.innerHTML = list[i].lastElementChild.innerHTML;
		lst.appendChild(lb);
	}
}
function function_name(argument) {
	var connect, form, response, result, nomEn;
	nomEn = __('nom_encuesta').value;
	//sesion = __('session_login').checked ? true : false;
	form = 'nomEnc=' + nomEn;
	connect = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	connect.onreadystatechange = function() {
		if(connect.readyState == 4 && connect.status == 200) {
		  if(connect.responseText == 1) {
		    result = '<div class="alert alert-dismissible alert-success">';
		    result += '<h4>Conectado!</h4>';
		    result += '<p><strong>Estamos redireccionandote...</strong></p>';
		    result += '</div>';
		    __('title_aviso_enc').innerHTML = result;
		    //location.reload();
		  } else {
		    __('title_aviso_enc').innerHTML = connect.responseText;
		  }
		} 
	}
	connect.open('POST','ajax.php?mode=encuesta',true);
	connect.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	connect.send(form);
}

function inicializarPreg() {
	var res = __('respuestas');
	__('txtPreg').innerHTML = '';
	__('tipoRes').value = '1';
	__('preg').value = '';
	__('res').value = '';
	__('title_aviso_preg').innerHTML = '';
	contBtn = 0;
	fade(__('btnAgregar'));
	while ( res.firstChild ){
		res.removeChild(res.firstChild );
	}
	fade(__('divDrag'));
	unfade(__('respuestas'));
	res.appendChild(gDivBase.cloneNode(true));
	unfade(__('btnTerminar'));
}

class Encuesta {
	constructor(name){
		this.name = name;
		this.preguntas = [];
		this.tipo ='';
	}
	addPreg(preg){
		var i = this.preguntas.length;
		preg.cont = i + 1;
		this.preguntas.push(preg);
	}
}

var verEncuesta = function () {
	var connect, form, response, result, nomEn;
	nomEn = __('nom_encuesta').value;
	//sesion = __('session_login').checked ? true : false;
	window.location="?view=encuesta&action=ver&encuesta="+nomEn;
}
class Pregunta {
	constructor(preg){
		this.preg = preg;
		this.tipo = 0;
		this.respuestas = [];
		this.cont = 0;
	}
	addRes(val){
		var res = new Respuesta(val);
		var i = this.respuestas.length;
		res.cont = i + 1;
		this.respuestas.push(res);
	}
	setTipo(){
		this.tipo = __('tipoRes').value;
	}
}
class Respuesta {
	constructor(res){
		this.res = res;
		this.cont = 0;
	}
}


