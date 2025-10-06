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

  var startBtn = $("#tour");
  function setupTour(tour) {
    var backBtnClass = "btn btn-sm btn-outline-primary",
      nextBtnClass = "btn btn-sm btn-primary btn-next";
    tour.addStep({
      title: "DATOS DE USUARIO",
      text: "SI HACES CLICK AQUÍ, PUEDES CAMBIAR LOS DATOS DEL USUARIO",
      attachTo: { element: ".avatar", on: "bottom" },
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
      title: "MENU DEL SISTEMA",
      text: "AL DAR CLICK SE DESPLEGARAN MAS OPCIONES",
      attachTo: { element: "#menu_principal", on: "top" },
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
      title: "SUBMENU DEL SISTEMA",
      text: "AL DAR CLICK SE REDICCIONARA EL MODULO DE CAPTURA",
      attachTo: { element: "#menu_secundario", on: "top" },
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
      title: "OCULTAR MENU",
      text: "AQUI PUEDES OCULTAR/DESOCULTAR EL MENU PRINCIPAL",
      attachTo: { element: "#oculta_menus", on: "top" },
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
