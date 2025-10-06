<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Actualización</title>
    <style>
        body {
            background-color: #FFFFFF;
            font-family: Arial, sans-serif;
            color: #8A2036;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
        }
        header, footer {
            background-color: #8A2036;
            color: #D5C1AB;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin-top: 10%;
            margin-left: 20%;
            margin-bottom: 10%;
            padding: 70px;
            border: 1px solid #B68C59;
            border-radius: 10px;
            background-color: #FFFFFF;
            
        }
        .button {
            background-color: #8A2036;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: right;
            
        }
        .button:hover {
            background-color: #B68C59;
        }
        .input-group {
            
            margin-bottom: 15px;
        }
        
        footer .social-icons {
            margin-top: 10px;
        }
        footer .social-icons img {
            width: 30px;
            margin: 0 5px;
        }
        .boton {
            
            padding: 10px 20px;
            font-size: 16px;
            color: #000000;
            background-color: #e3b47a; /* Color de fondo */
            text-align: center;
            border-radius: 5px;
            float: inline-end;
            margin-right: 20px; 
            margin-top: 20px;
        }
        .boton:hover {
            background-color: #eac67f; /* Color de fondo al pasar el mouse */
        }
        .open-modal-btn {
            background-color: #8A2036;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .modal {
            display: none; /* Oculto por defecto */
            position: fixed;
            z-index: 1; /* Ubicación en la parte superior de la página */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Habilita el desplazamiento si es necesario */
            background-color: rgba(0, 0, 0, 0.5); /* Fondo negro con opacidad */
        }

        /* Estilo del contenido del modal */
        .modal-content {
            background-color: white;
            margin: 15% auto; /* Centrado vertical y horizontal */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Ancho del modal */
            max-width: 500px; /* Ancho máximo del modal */
        }

        /* Estilo para el botón de cerrar el modal */
        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <header>
        <div class="row" style="height: 80px;">
            <img src="imagenes/logo.PNG" style="width: 300px; height: 70px; float: left;" alt="Encabezado">
            <button class="boton" onclick="scrollToFooter()">Contacto</button>
            <button class="boton" href="#">Actualización de datos</button>
                
        </div>
    </header>

    <div class="container">
        <div class="input-group">
            <h1 style="text-align: center;">Tus datos no estan actualizados</h1>
            <label style="text-align: center;" for="clave-servidor">Es necesario que actualices tus datos de acuerdo a los proporcionados en la constancia de situación fiscal.</label>
            <br><br><br>
            <button style="margin-left: 45%;" class="open-modal-btn" id="openModalBtn">Continuar</button>
        </div>
    </div>
    <div id="myModal" class="modal">
        <!-- Contenido del Modal -->
        <div class="modal-content">
            <span class="close-btn" id="closeModalBtn">&times;</span>
            <div class="input-group">
                <h2 style="text-align: center;">POLITICAS DE PRIVACIDAD</h2>
                <br><br><br>
                <p>El Servidor Público al momento de llenar el formulario y porporcionar su constancia de situación fiscal autoriza la modificación de sus datos.</p>
                <br><br><br>
                <label for="myCheckbox">
                    <input type="checkbox" id="myCheckbox"> Acepto las politicas de privacidad
                </label>
                <br><br><br><br>
                <button type="submit" id="continueBtn" class="button" onclick="formulario()">Continuar</button>
                <br><br>            
            </div>    
        </div>
    </div>

    <footer id="footer" style="height: 120px;">
        <img src="imagenes/logo.PNG" style=" width: 400px; height: 100px; float: left;" alt="Pie de página">
        <div class="social-icons">
            <img src="imagenes/x.png" alt="X">
            <img src="imagenes/instagram.png" alt="Instagram">
            <img src="imagenes/youtube.png" alt="YouTube">
            <img src="imagenes/facebook.png" alt="Facebook">
        </div>
        <br>
        <div style="margin-right: 5px;">
            <div><strong>CONTACTO</strong></div>
            <div>Teléfono</div>
            <div>Correo</div>
        </div>
        
    </footer>

</body>
</html>
<script>
        function scrollToFooter() {
            document.getElementById("footer").scrollIntoView({ behavior: 'smooth' });
        }
</script>
<script>
        function formulario() {
            window.location.href = "formulario.php";
        }
</script>
<script>
        // Obtén el modal
        var modal = document.getElementById("myModal");

        // Obtén el botón que abre el modal
        var btn = document.getElementById("openModalBtn");

        // Obtén el elemento <span> que cierra el modal
        var span = document.getElementById("closeModalBtn");

        // Cuando el usuario hace clic en el botón, abre el modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // Cuando el usuario hace clic en <span> (x), cierra el modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Cuando el usuario hace clic en cualquier lugar fuera del modal, ciérralo
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>