function __(id) {
  return document.getElementById(id) == null ? document.getElementsByClassName(id) : document.getElementById(id);
}
function clonarNodo(original) {
 //var original=document.getElementById("nodo_original");
 var nuevo=original.cloneNode(true);
 //nuevo.id=indice;
 //destino=document.getElementById("nodo_destino");
 //destino.appendChild(nuevo);
 return nuevo;
}
function fade(element) {
    var op = 1;  // initial opacity
    var timer = setInterval(function () {
        if (op <= 0.1){
            clearInterval(timer);
            element.style.display = 'none';
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op -= op * 0.1;
    }, 30);
}
function unfade(element) {
    var op = 0.1;  // initial opacity
    element.style.display = 'block';
    var timer = setInterval(function () {
        if (op >= 1){
            clearInterval(timer);
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op += op * 0.1;
    }, 50);
}