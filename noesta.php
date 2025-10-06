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
        }
        .button:hover {
            background-color: #B68C59;
        }
        .input-group {
            
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
        }
        .input-group input {
            width: calc(100% - 30px);
            padding: 10px;
            border: 1px solid #D5C1AB;
            border-radius: 5px;
        }
        .input-group select, .input-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #D5C1AB;
            border-radius: 5px;
        }
        .input-group select {
            background-color: #FFFFFF;
        }
        .input-group textarea {
            resize: vertical;
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
            <label style="text-align: center;" for="clave-servidor"> Tus datos no necesitan actualización</label>
        </div>
    </div>

    <footer id="footer" style="height: 120px;">
        <img src="imagenes/logo.PNG" style="width: 400px; height: 100px; float: left;" alt="Pie de página">
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
