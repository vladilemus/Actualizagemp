var Base64 = {
    _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=", encode: function (input) {
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        var i = 0;
        input = Base64._utf8_encode(input);
        while (i < input.length) {
            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);

            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;

            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }

            output = output + this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) + this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
        }
        return output;
    },

    decode: function (input) {
        var output = "";
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;

        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        while (i < input.length) {
            enc1 = this._keyStr.indexOf(input.charAt(i++));
            enc2 = this._keyStr.indexOf(input.charAt(i++));
            enc3 = this._keyStr.indexOf(input.charAt(i++));
            enc4 = this._keyStr.indexOf(input.charAt(i++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            output = output + String.fromCharCode(chr1);

            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }
        }

        output = Base64._utf8_decode(output);

        return output;
    },

    _utf8_encode: function (string) {
        string = string.replace(/\r\n/g, "\n");
        var utftext = "";

        for (var n = 0; n < string.length; n++) {
            var c = string.charCodeAt(n);
            if (c < 128) {
                utftext += String.fromCharCode(c);
            } else if (c > 127 && c < 2048) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            } else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }
        }
        return utftext;
    },

    _utf8_decode: function (utftext) {
        var string = "";
        var i = 0;
        var c = (c1 = c2 = 0);

        while (i < utftext.length) {
            c = utftext.charCodeAt(i);

            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            } else if (c > 191 && c < 224) {
                c2 = utftext.charCodeAt(i + 1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            } else {
                c2 = utftext.charCodeAt(i + 1);
                c3 = utftext.charCodeAt(i + 2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }
        }
        return string;
    },
};

function destruyedatos() {
    var encodeusuaruio = generateRandomString(1) + Base64.encode($("#txtnomusuario").val()) + generateRandomString(1);
    var encodeemail = generateRandomString(1) + Base64.encode($("#txtpasswd").val()) + generateRandomString(1);
    $("#txtnomusuario").val(encodeusuaruio);
    $("#txtpasswd").val(encodeemail);
    $.ajax({
        url: "index.php", data: $("#loginform").serialize(), type: "POST", dataType: "json", success: function (data) {
        },
    });

    // document.loginform.submit();
}

function generateRandomString(num) {
    const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    let result1 = Math.random().toString(36).substring(0, num);
    return result1;
}

function ValidaSoloNumeros() {
    if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;
}

function ValidaSoloLetras() {
    if (event.keyCode == 241) {
        event.returnValue = true;
    } else {
        if ((event.keyCode != 32 && event.keyCode < 65) || (event.keyCode > 90 && event.keyCode < 97) || event.keyCode > 122) event.returnValue = false;
    }
}

function mayusculas(e) {
    e.value = e.value.toUpperCase();
}

function formato(componente) {
    document.getElementById(componente).innerHTML = "<font color=red>ESTE CAMPO ES REQUERIDO</font>";
    document.getElementById(componente).focus();
}

function formato2(componente, etiqueta) {
    console.log(componente);
    document.getElementById(componente).innerHTML = etiqueta;
}

function validarTextoEntrada(input, patron) {
    var texto = input.value;
    var letras = texto.split("");
    for (var x in letras) {
        var letra = letras[x];
        if (!new RegExp(patron, "i").test(letra)) {
            letras[x] = "";
        }
    }
    input.value = letras.join("");
}

function capchacorreo(email) {
    var myemail=email;
    var encodeusuaruio = generateRandomString(2) + Base64.encode($("#txtnomusuario").val()) + generateRandomString(2);
    var encodeemail = generateRandomString(2) + Base64.encode($("#txtemail").val()) + generateRandomString(2);
    var encodepregunta = generateRandomString(2) + Base64.encode($("#txtpregunta").val()) + generateRandomString(2);
    // alert("alert" + encodeusuaruio);
    // alert("alert" + encodeemail);
    var pagina = "../plantilla/login";
    $("#content").html('<div class="loading" style="text-align: center;"><img src="imagenes_sistema/loader.gif" alt="VALIDANDO DATOS CONEXION LENTA" /><br/><h1><strong>. . .  VERIFICANDO DATOS  . . .</strong></h1></div>');
    const formData = new FormData();
    formData.append("encodeusuaruio", encodeusuaruio);
    formData.append("encodeemail", encodeemail);
    formData.append("encodepregunta", encodepregunta);

    $.ajax({
        url: "ajax_sistema/ajax_pass.php",
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    }).done(function (res) {
        if (res == "EXITO") {
            let timerInterval
            Swal.fire({
                title: res,
                html: 'ENVIANDO ENLACE A:: '+myemail,
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft()
                    }, 3500)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                    setTimeout(redireccionar(), 3000);
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
            })
        } else {
            let timerInterval
            Swal.fire({
                title: res,
                html: 'REDIRECCIONANDO <b></b> .',
                timer: 3500,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft()
                    }, 3500)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                    setTimeout(redireccionar(), 3000);
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
            })
        }
    });
}

function redireccionar() {
    window.location.replace("../DGPglink/index.php");
}