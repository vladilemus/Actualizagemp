
//////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////@ISC CHRISTOPHER DELGADILLO RAMIREZ ALV PRRS
////ARCHIVO DE CONFIGURACION DE JAVASCREIPT JQUERY
//////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////SECCION DE LAS VALIDACIONES DE LOS CAMPOS VIA JAVASCRIPT////////////////////////////////////////////////

    var cve_peticion = document.getElementById("cve_peticion");    
cve_peticion.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var cve_desc = document.getElementById("cve_desc");    
cve_desc.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var cve_doc = document.getElementById("cve_doc");    
cve_doc.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var cve_usuario = document.getElementById("cve_usuario");    
cve_usuario.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var pfolio = document.getElementById("pfolio");    
pfolio.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var Observaciones = document.getElementById("Observaciones");    
Observaciones.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
    var pfecha = document.getElementById("pfecha");    
pfecha.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    
/////////////////////////////////////////////////FIN DE LAS VALIDACIONES////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////SECCCION DEL EVENTO ONCLICK////////////////////////////////////////////////////////////////
$(document).ready(function() {    
        $("#cve_peticion").hide();    
        $("#cve_desc").hide();    
        $("#cve_doc").hide();    
        $("#cve_usuario").hide();    
        $("#pfolio").hide();    
        $("#Observaciones").hide();    
        $("#pfecha").hide();    
        $("#cve_peticion").show();    
        $("#cve_desc").show();    
        $("#cve_doc").show();    
        $("#cve_usuario").show();    
        $("#pfolio").show();    
        $("#Observaciones").show();    
        $("#pfecha").show();    
    $("#cve_peticion").click(function(){

    });    
    $("#cve_desc").click(function(){

    });    
    $("#cve_doc").click(function(){

    });    
    $("#cve_usuario").click(function(){

    });    
    $("#pfolio").click(function(){

    });    
    $("#Observaciones").click(function(){

    });    
    $("#pfecha").click(function(){

    });
/////////////////////////////////////////////////FIN DE LOS EVENTOS////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////FUNCIONES KEYUP/////////////////////////////////////////////////////////////////////////////////////////
    
    $("#cve_peticion").keyup(function () {

    });    
    $("#cve_desc").keyup(function () {

    });    
    $("#cve_doc").keyup(function () {

    });    
    $("#cve_usuario").keyup(function () {

    });    
    $("#pfolio").keyup(function () {

    });    
    $("#Observaciones").keyup(function () {

    });    
    $("#pfecha").keyup(function () {

    });
/////////////////////////////////////////////////FIN DE LOS EVENTOS KEY UP////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////FIN DE LOS keypress////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////FUNCIONES keypress/////////////////////////////////////////////////////////////////////////////////////////
    
    $("#cve_peticion").keypress(function(){

    });    
    $("#cve_desc").keypress(function(){

    });    
    $("#cve_doc").keypress(function(){

    });    
    $("#cve_usuario").keypress(function(){

    });    
    $("#pfolio").keypress(function(){

    });    
    $("#Observaciones").keypress(function(){

    });    
    $("#pfecha").keypress(function(){

    });
/////////////////////////////////////////////////FIN DE LOS EVENTOS keypress////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////FUNCIONES ON PROP///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////FUNCIONES PROP/////////////////////////////////////////////////////////////////////////////////////////
    
    if ($("#cve_peticion").prop('checked')) {
    } else {
    }    
    if ($("#cve_desc").prop('checked')) {
    } else {
    }    
    if ($("#cve_doc").prop('checked')) {
    } else {
    }    
    if ($("#cve_usuario").prop('checked')) {
    } else {
    }    
    if ($("#pfolio").prop('checked')) {
    } else {
    }    
    if ($("#Observaciones").prop('checked')) {
    } else {
    }    
    if ($("#pfecha").prop('checked')) {
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