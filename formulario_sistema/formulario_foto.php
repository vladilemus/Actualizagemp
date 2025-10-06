<?php
session_start();
include_once("../configuracion_sistema/configuracion.php");
if ($__SESSION->getValueSession('nomusuario') == "") {
    include_once("../includes/sb_refresh.php");
} else {
    include_once '../librerias/PDOConsultas.php';


    $valor=$_GET['valor'];
    $modulo_ant=$_GET['modulo_ant'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $consulta = new PDOConsultas();
        $consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0]);
        $clave_servidor_publico=$_POST['valor'];

        $query_preparado="select * from sb_persona where cve_persona=".$clave_servidor_publico;
        $valores_query=$consulta->executeQuery($query_preparado);
        $rfc=$valores_query[0]['rfc'];


        $targetDir = "../fotografia/";
        $targetFile = $targetDir .$rfc."_". basename($_FILES["image"]["name"]);

        // Verificar si el archivo es una imagen válida
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
            exit;
        }

        // Verificar el tamaño del archivo
        if ($_FILES["image"]["size"] > 5000000) {
            echo "El tamaño del archivo debe ser menor a 5 megabytes.";
            exit;
        }

        // Mover el archivo cargado a la ubicación deseada
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {


            echo "La imagen se cargó correctamente.";
            $query_update="UPDATE sb_persona
	SET
		file_fotografia='fotografia/".$rfc."_".$_FILES["image"]["name"]."'
	WHERE 
	cve_persona=".$clave_servidor_publico;
            $valores_update=$consulta->executeQuery($query_update);

            header( 'Location: ../index.php?mod=55' ) ;
        } else {
            echo "Hubo un error al cargar la imagen.";
        }
    }


    ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        form {
            margin-top: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="file"] {
            border: none;
        }

        .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <div class="container">
        <h1>Formulario de carga de imagen</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Selecciona una imagen:</label>
                <input type="text" name="valor" id="valor" value="<?= $valor?>" hidden >
                <input type="text" name="modulo" id="modulo" value="<?= $modulo_ant?>" hidden >

                <input type="file" name="image" accept=".png, .jpg, .jpeg, .gif">
            </div>
            <div class="form-group">
                <input type="submit" value="Cargar imagen">
            </div>
        </form>
    </div>

    <?php
}
?>
