
//////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////@ISC CHRISTOPHER DELGADILLO RAMIREZ ALV PRRS
////ARCHIVO DE CONFIGURACION DE JAVASCREIPT JQUERY
//////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////SECCION DE LAS VALIDACIONES DE LOS CAMPOS VIA JAVASCRIPT////////////////////////////////////////////////

    var banco = document.getElementById("banco");    
banco.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var centro_trabajo = document.getElementById("centro_trabajo");    
centro_trabajo.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var clave_sp = document.getElementById("clave_sp");    
clave_sp.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var codigo_post = document.getElementById("codigo_post");    
codigo_post.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var cuenta = document.getElementById("cuenta");    
cuenta.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var curp = document.getElementById("curp");    
curp.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var cve_municipio = document.getElementById("cve_municipio");    
cve_municipio.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var cve_nivel = document.getElementById("cve_nivel");    
cve_nivel.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var dt_sp_erroneos = document.getElementById("dt_sp_erroneos");    
dt_sp_erroneos.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var email = document.getElementById("email");    
email.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var error = document.getElementById("error");    
error.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var ley_adscripcion = document.getElementById("ley_adscripcion");    
ley_adscripcion.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var ley_municipio = document.getElementById("ley_municipio");    
ley_municipio.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var ley_puesto = document.getElementById("ley_puesto");    
ley_puesto.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var lugar_pago = document.getElementById("lugar_pago");    
lugar_pago.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var nivel = document.getElementById("nivel");    
nivel.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var nombre = document.getElementById("nombre");    
nombre.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var rfc = document.getElementById("rfc");    
rfc.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var banco = document.getElementById("banco");    
banco.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var centro_trabajo = document.getElementById("centro_trabajo");    
centro_trabajo.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var clave_sp = document.getElementById("clave_sp");    
clave_sp.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var codigo_post = document.getElementById("codigo_post");    
codigo_post.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var cuenta = document.getElementById("cuenta");    
cuenta.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var curp = document.getElementById("curp");    
curp.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var cve_municipio = document.getElementById("cve_municipio");    
cve_municipio.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var cve_nivel = document.getElementById("cve_nivel");    
cve_nivel.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var dt_sp_erroneos = document.getElementById("dt_sp_erroneos");    
dt_sp_erroneos.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var email = document.getElementById("email");    
email.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var error = document.getElementById("error");    
error.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var ley_adscripcion = document.getElementById("ley_adscripcion");    
ley_adscripcion.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var ley_municipio = document.getElementById("ley_municipio");    
ley_municipio.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var ley_puesto = document.getElementById("ley_puesto");    
ley_puesto.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var lugar_pago = document.getElementById("lugar_pago");    
lugar_pago.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var nivel = document.getElementById("nivel");    
nivel.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var nombre = document.getElementById("nombre");    
nombre.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var rfc = document.getElementById("rfc");    
rfc.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
/////////////////////////////////////////////////FIN DE LAS VALIDACIONES////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////SECCCION DEL EVENTO ONCLICK////////////////////////////////////////////////////////////////
$(document).ready(function() {    
        $("#banco").hide();    
        $("#centro_trabajo").hide();    
        $("#clave_sp").hide();    
        $("#codigo_post").hide();    
        $("#cuenta").hide();    
        $("#curp").hide();    
        $("#cve_municipio").hide();    
        $("#cve_nivel").hide();    
        $("#dt_sp_erroneos").hide();    
        $("#email").hide();    
        $("#error").hide();    
        $("#ley_adscripcion").hide();    
        $("#ley_municipio").hide();    
        $("#ley_puesto").hide();    
        $("#lugar_pago").hide();    
        $("#nivel").hide();    
        $("#nombre").hide();    
        $("#rfc").hide();    
        $("#banco").hide();    
        $("#centro_trabajo").hide();    
        $("#clave_sp").hide();    
        $("#codigo_post").hide();    
        $("#cuenta").hide();    
        $("#curp").hide();    
        $("#cve_municipio").hide();    
        $("#cve_nivel").hide();    
        $("#dt_sp_erroneos").hide();    
        $("#email").hide();    
        $("#error").hide();    
        $("#ley_adscripcion").hide();    
        $("#ley_municipio").hide();    
        $("#ley_puesto").hide();    
        $("#lugar_pago").hide();    
        $("#nivel").hide();    
        $("#nombre").hide();    
        $("#rfc").hide();    
        $("#banco").show();    
        $("#centro_trabajo").show();    
        $("#clave_sp").show();    
        $("#codigo_post").show();    
        $("#cuenta").show();    
        $("#curp").show();    
        $("#cve_municipio").show();    
        $("#cve_nivel").show();    
        $("#dt_sp_erroneos").show();    
        $("#email").show();    
        $("#error").show();    
        $("#ley_adscripcion").show();    
        $("#ley_municipio").show();    
        $("#ley_puesto").show();    
        $("#lugar_pago").show();    
        $("#nivel").show();    
        $("#nombre").show();    
        $("#rfc").show();    
        $("#banco").show();    
        $("#centro_trabajo").show();    
        $("#clave_sp").show();    
        $("#codigo_post").show();    
        $("#cuenta").show();    
        $("#curp").show();    
        $("#cve_municipio").show();    
        $("#cve_nivel").show();    
        $("#dt_sp_erroneos").show();    
        $("#email").show();    
        $("#error").show();    
        $("#ley_adscripcion").show();    
        $("#ley_municipio").show();    
        $("#ley_puesto").show();    
        $("#lugar_pago").show();    
        $("#nivel").show();    
        $("#nombre").show();    
        $("#rfc").show();    
    $("#banco").click(function(){

    });    
    $("#centro_trabajo").click(function(){

    });    
    $("#clave_sp").click(function(){

    });    
    $("#codigo_post").click(function(){

    });    
    $("#cuenta").click(function(){

    });    
    $("#curp").click(function(){

    });    
    $("#cve_municipio").click(function(){

    });    
    $("#cve_nivel").click(function(){

    });    
    $("#dt_sp_erroneos").click(function(){

    });    
    $("#email").click(function(){

    });    
    $("#error").click(function(){

    });    
    $("#ley_adscripcion").click(function(){

    });    
    $("#ley_municipio").click(function(){

    });    
    $("#ley_puesto").click(function(){

    });    
    $("#lugar_pago").click(function(){

    });    
    $("#nivel").click(function(){

    });    
    $("#nombre").click(function(){

    });    
    $("#rfc").click(function(){

    });    
    $("#banco").click(function(){

    });    
    $("#centro_trabajo").click(function(){

    });    
    $("#clave_sp").click(function(){

    });    
    $("#codigo_post").click(function(){

    });    
    $("#cuenta").click(function(){

    });    
    $("#curp").click(function(){

    });    
    $("#cve_municipio").click(function(){

    });    
    $("#cve_nivel").click(function(){

    });    
    $("#dt_sp_erroneos").click(function(){

    });    
    $("#email").click(function(){

    });    
    $("#error").click(function(){

    });    
    $("#ley_adscripcion").click(function(){

    });    
    $("#ley_municipio").click(function(){

    });    
    $("#ley_puesto").click(function(){

    });    
    $("#lugar_pago").click(function(){

    });    
    $("#nivel").click(function(){

    });    
    $("#nombre").click(function(){

    });    
    $("#rfc").click(function(){

    });
/////////////////////////////////////////////////FIN DE LOS EVENTOS////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////FUNCIONES KEYUP/////////////////////////////////////////////////////////////////////////////////////////
    
    $("#banco").keyup(function () {

    });    
    $("#centro_trabajo").keyup(function () {

    });    
    $("#clave_sp").keyup(function () {

    });    
    $("#codigo_post").keyup(function () {

    });    
    $("#cuenta").keyup(function () {

    });    
    $("#curp").keyup(function () {

    });    
    $("#cve_municipio").keyup(function () {

    });    
    $("#cve_nivel").keyup(function () {

    });    
    $("#dt_sp_erroneos").keyup(function () {

    });    
    $("#email").keyup(function () {

    });    
    $("#error").keyup(function () {

    });    
    $("#ley_adscripcion").keyup(function () {

    });    
    $("#ley_municipio").keyup(function () {

    });    
    $("#ley_puesto").keyup(function () {

    });    
    $("#lugar_pago").keyup(function () {

    });    
    $("#nivel").keyup(function () {

    });    
    $("#nombre").keyup(function () {

    });    
    $("#rfc").keyup(function () {

    });    
    $("#banco").keyup(function () {

    });    
    $("#centro_trabajo").keyup(function () {

    });    
    $("#clave_sp").keyup(function () {

    });    
    $("#codigo_post").keyup(function () {

    });    
    $("#cuenta").keyup(function () {

    });    
    $("#curp").keyup(function () {

    });    
    $("#cve_municipio").keyup(function () {

    });    
    $("#cve_nivel").keyup(function () {

    });    
    $("#dt_sp_erroneos").keyup(function () {

    });    
    $("#email").keyup(function () {

    });    
    $("#error").keyup(function () {

    });    
    $("#ley_adscripcion").keyup(function () {

    });    
    $("#ley_municipio").keyup(function () {

    });    
    $("#ley_puesto").keyup(function () {

    });    
    $("#lugar_pago").keyup(function () {

    });    
    $("#nivel").keyup(function () {

    });    
    $("#nombre").keyup(function () {

    });    
    $("#rfc").keyup(function () {

    });
/////////////////////////////////////////////////FIN DE LOS EVENTOS KEY UP////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////FIN DE LOS keypress////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////FUNCIONES keypress/////////////////////////////////////////////////////////////////////////////////////////
    
    $("#banco").keypress(function(){

    });    
    $("#centro_trabajo").keypress(function(){

    });    
    $("#clave_sp").keypress(function(){

    });    
    $("#codigo_post").keypress(function(){

    });    
    $("#cuenta").keypress(function(){

    });    
    $("#curp").keypress(function(){

    });    
    $("#cve_municipio").keypress(function(){

    });    
    $("#cve_nivel").keypress(function(){

    });    
    $("#dt_sp_erroneos").keypress(function(){

    });    
    $("#email").keypress(function(){

    });    
    $("#error").keypress(function(){

    });    
    $("#ley_adscripcion").keypress(function(){

    });    
    $("#ley_municipio").keypress(function(){

    });    
    $("#ley_puesto").keypress(function(){

    });    
    $("#lugar_pago").keypress(function(){

    });    
    $("#nivel").keypress(function(){

    });    
    $("#nombre").keypress(function(){

    });    
    $("#rfc").keypress(function(){

    });    
    $("#banco").keypress(function(){

    });    
    $("#centro_trabajo").keypress(function(){

    });    
    $("#clave_sp").keypress(function(){

    });    
    $("#codigo_post").keypress(function(){

    });    
    $("#cuenta").keypress(function(){

    });    
    $("#curp").keypress(function(){

    });    
    $("#cve_municipio").keypress(function(){

    });    
    $("#cve_nivel").keypress(function(){

    });    
    $("#dt_sp_erroneos").keypress(function(){

    });    
    $("#email").keypress(function(){

    });    
    $("#error").keypress(function(){

    });    
    $("#ley_adscripcion").keypress(function(){

    });    
    $("#ley_municipio").keypress(function(){

    });    
    $("#ley_puesto").keypress(function(){

    });    
    $("#lugar_pago").keypress(function(){

    });    
    $("#nivel").keypress(function(){

    });    
    $("#nombre").keypress(function(){

    });    
    $("#rfc").keypress(function(){

    });
/////////////////////////////////////////////////FIN DE LOS EVENTOS keypress////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////FUNCIONES ON PROP///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////FUNCIONES PROP/////////////////////////////////////////////////////////////////////////////////////////
    
    if ($("#banco").prop('checked')) {
    } else {
    }    
    if ($("#centro_trabajo").prop('checked')) {
    } else {
    }    
    if ($("#clave_sp").prop('checked')) {
    } else {
    }    
    if ($("#codigo_post").prop('checked')) {
    } else {
    }    
    if ($("#cuenta").prop('checked')) {
    } else {
    }    
    if ($("#curp").prop('checked')) {
    } else {
    }    
    if ($("#cve_municipio").prop('checked')) {
    } else {
    }    
    if ($("#cve_nivel").prop('checked')) {
    } else {
    }    
    if ($("#dt_sp_erroneos").prop('checked')) {
    } else {
    }    
    if ($("#email").prop('checked')) {
    } else {
    }    
    if ($("#error").prop('checked')) {
    } else {
    }    
    if ($("#ley_adscripcion").prop('checked')) {
    } else {
    }    
    if ($("#ley_municipio").prop('checked')) {
    } else {
    }    
    if ($("#ley_puesto").prop('checked')) {
    } else {
    }    
    if ($("#lugar_pago").prop('checked')) {
    } else {
    }    
    if ($("#nivel").prop('checked')) {
    } else {
    }    
    if ($("#nombre").prop('checked')) {
    } else {
    }    
    if ($("#rfc").prop('checked')) {
    } else {
    }    
    if ($("#banco").prop('checked')) {
    } else {
    }    
    if ($("#centro_trabajo").prop('checked')) {
    } else {
    }    
    if ($("#clave_sp").prop('checked')) {
    } else {
    }    
    if ($("#codigo_post").prop('checked')) {
    } else {
    }    
    if ($("#cuenta").prop('checked')) {
    } else {
    }    
    if ($("#curp").prop('checked')) {
    } else {
    }    
    if ($("#cve_municipio").prop('checked')) {
    } else {
    }    
    if ($("#cve_nivel").prop('checked')) {
    } else {
    }    
    if ($("#dt_sp_erroneos").prop('checked')) {
    } else {
    }    
    if ($("#email").prop('checked')) {
    } else {
    }    
    if ($("#error").prop('checked')) {
    } else {
    }    
    if ($("#ley_adscripcion").prop('checked')) {
    } else {
    }    
    if ($("#ley_municipio").prop('checked')) {
    } else {
    }    
    if ($("#ley_puesto").prop('checked')) {
    } else {
    }    
    if ($("#lugar_pago").prop('checked')) {
    } else {
    }    
    if ($("#nivel").prop('checked')) {
    } else {
    }    
    if ($("#nombre").prop('checked')) {
    } else {
    }    
    if ($("#rfc").prop('checked')) {
    } else {
    }
/////////////////////////////////////////////////FIN DE LOS EVENTOS PROP////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

});
//////////////////////////////////////////////////////CIERRE DOCUMENT READY////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function validar_numeros(elem) {
    var text = document.getElementById(elem);
    text.addEventListener("keypress", _check);
    function _check(e) {
        var textV = "which" in e ? e.which : e.keyCode,
                char = String.fromCharCode(textV),
                regex = /[0-9]/ig;
        if (!regex.test(char))
            e.preventDefault();
        return false;
    }
}
function validar_letras(elem) {
    var text = document.getElementById(elem);
    text.addEventListener("keypress", _check);
    function _check(e) {
        var textV = "which" in e ? e.which : e.keyCode,
                char = String.fromCharCode(textV),
                regex = /^[a-zA-ZáéíóúñÁÉÍÓÚÑ0-9\s]+$/g;
        if (!regex.test(char))
            e.preventDefault();
        return false;
    }
}