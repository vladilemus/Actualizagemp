/*=========================================================================================
	File Name: tour.js
	Description: tour
	----------------------------------------------------------------------------------------
	Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
	Author: Pixinvent
	Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
  "use strict";

  var startBtn = $("#tour2");
  function setupTour(tour) {
    var backBtnClass = "btn btn-sm btn-outline-primary",
      nextBtnClass = "btn btn-sm btn-primary btn-next";
    tour.addStep({
      title: "NUEVOS REGISTROS",
      text: "SI HACES CLICK AQUÍ, PUEDES INICIAR EL FORMULARIO PARA AGREGAR UN NUEVO REGISTRO",
      attachTo: { element: "#btn_nuevo_registro", on: "bottom" },
      buttons: [
        {
          action: tour.cancel,
          classes: backBtnClass,
          text: "SALIR",
        },
        {
          text: "SIGUIENTE",
          classes: nextBtnClass,
          action: tour.next,
        },
      ],
    });
    tour.addStep({
      title: "INFORMACION RAPIDA",
      text: "SE DESPLEGA EL NÚMERO DE RE REGISTROS Y EL NOMBRE DEL MODULO ACTUAL",
      attachTo: { element: "#informacion_modulo", on: "top" },
      buttons: [
        {
          text: "SALIR",
          classes: backBtnClass,
          action: tour.cancel,
        },
        {
          text: "ANTERIOR",
          classes: backBtnClass,
          action: tour.back,
        },
        {
          text: "SIGUIENTE",
          classes: nextBtnClass,
          action: tour.next,
        },
      ],
    });
    tour.addStep({
      title: "OPCIÓN DE BUSQUEDA",
      text: "SELECCIONA UNA OPCION PARA BUSCAR EN LOS REGISTROS",
      attachTo: { element: "#vector_busqueda", on: "top" },
      buttons: [
        {
          text: "SALIR",
          classes: backBtnClass,
          action: tour.cancel,
        },
        {
          text: "ANTERIOR",
          classes: backBtnClass,
          action: tour.back,
        },
        {
          text: "SIGUIENTE",
          classes: nextBtnClass,
          action: tour.next,
        },
      ],
    });
    tour.addStep({
      title: "ESCRIBE TU BUSUQEDA",
      text: "ESCRIBE EL TEXTO A BUSCAR Y DA CLICK EN EL BOTON DE BUSCAR",
      attachTo: { element: "#buscar_campo", on: "top" },
      buttons: [
        {
          text: "SALIR",
          classes: backBtnClass,
          action: tour.cancel,
        },
        {
          text: "ANTERIOR",
          classes: backBtnClass,
          action: tour.back,
        },
        {
          text: "SIGUIENTE",
          classes: nextBtnClass,
          action: tour.next,
        },
      ],
    });
    tour.addStep({
      title: "TABLA DE DATOS",
      text: "SE MUESTRAN LOS REGISTROS DEL MODULO",
      attachTo: { element: "#tabla_contenido", on: "top" },
      buttons: [
        {
          text: "SALIR",
          classes: backBtnClass,
          action: tour.cancel,
        },
        {
          text: "ANTERIOR",
          classes: backBtnClass,
          action: tour.back,
        },
        {
          text: "SIGUIENTE",
          classes: nextBtnClass,
          action: tour.next,
        },
      ],
    });
    tour.addStep({
      title: "ACTUALIZA REGISTROS",
      text: "AL DAR CLICK SE ABRIRA EL MODULO PARA ACTUALIZAR EL REGISTRO, SI EL USUARIO TIENE PERMISOS",
      attachTo: { element: "#btn_actualiza_registro", on: "top" },
      buttons: [
        {
          text: "SALIR",
          classes: backBtnClass,
          action: tour.cancel,
        },
        {
          text: "ANTERIOR",
          classes: backBtnClass,
          action: tour.back,
        },
        {
          text: "SIGUIENTE",
          classes: nextBtnClass,
          action: tour.next,
        },
      ],
    });
    tour.addStep({
      title: "ELIMINA REGISTROS",
      text: "AL DAR CLICK SE ABRIRA EL MODULO PARA ELIMINA EL REGISTRO, SI EL USUARIO TIENE PERMISOS",
      attachTo: { element: "#btn_elimina_registro", on: "top" },
      buttons: [
        {
          text: "SALIR",
          classes: backBtnClass,
          action: tour.cancel,
        },
        {
          text: "ANTERIOR",
          classes: backBtnClass,
          action: tour.back,
        },
        {
          text: "SIGUIENTE",
          classes: nextBtnClass,
          action: tour.next,
        },
      ],
    });
    tour.addStep({
      title: "PAGINADOR",
      text: "AQUI PUEDES VISUALIZAR ENTR EL TOTAL DE REGISTROS",
      attachTo: { element: "#btn_numero_paginas", on: "top" },
      buttons: [
        {
          text: "ANTERIOR",
          classes: backBtnClass,
          action: tour.back,
        },
        {
          text: "FINALIZAR",
          classes: nextBtnClass,
          action: tour.cancel,
        },
      ],
    });
    return tour;
  }

  if (startBtn.length) {
    startBtn.on("click", function () {
      var tourVar = new Shepherd.Tour({
        defaultStepOptions: {
          classes: "shadow-md bg-purple-dark",
          scrollTo: false,
          cancelIcon: {
            enabled: true,
          },
        },
        useModalOverlay: true,
      });

      setupTour(tourVar).start();
    });
  }
});
