<?php
require_once '../configuracion_sistema/configuracion.php';
require_once '../librerias/PDOConsultas.php';
require_once '../librerias/vendor/autoload.php';
require '../vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

//varibles del post
$claveSp = $_POST['claveSp'];
$rfc = $_POST['rfc'];
$nombre = $_POST['nombre'];
$cp = $_POST['cp'];
$opciones=$_POST['opciones'];
$comentarios=$_POST['comentarios'];
$emailRemi = $_POST['email'];
$curp = $_POST['curp'];


//consulta para obtner el correo del remitente


if($opciones=='TRUE'){
    //SE CAMBIA A ACTUALIZADO
    $estatus='ACTUALIZADO';
    $camposarray = array(
        "estatus" => $estatus,
        "comentarios" => $comentarios, 
        "nombre" => $nombre,
        "curp" => $curp
    );
    $consulta->where("clave_sp", $claveSp);
    $consulta->update("det_peticiones", $camposarray);


    if($consulta->rowsChanged>0){

        //realizamos el envio del correo 
        //variables para el correo
        $mail = new PHPMailer(true);
        $correo = 'actualizagemres@gmail.com';
       
        try {
            // Configuraciones del servidor SMTP
        //    $mail->isSMTP();                                            // Usar SMTP
        //    $mail->Host       = 'smtp.example.com';                     // Servidor SMTP
        //    $mail->SMTPAuth   = true;                                   // Habilitar autenticación SMTP
        //    $mail->Username   = 'user@example.com';                     // Nombre de usuario SMTP
        //    $mail->Password   = 'secret';                               // Contraseña SMTP
        //    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Habilitar encriptación TLS, PHPMailer::ENCRYPTION_SMTPS también es aceptable
        //    $mail->Port       = 587;                                    // Puerto TCP al que conectarse
        
            $mail->SMTPDebug = 2;  // Sacar esta línea para no mostrar salida debug
            $mail->isSMTP();
        
            $mail->Host = 'smtp.gmail.com';  // Host de conexión SMTP
            $mail->SMTPAuth = true;
            $mail->Username = $correo;                 // Usuario SMTP
            $mail->Password = 'cypgnadocpiftrjo';                           // Password SMTP
            $mail->SMTPSecure = 'tls';                            // Activar seguridad TLS
            //$mail->Port = 587;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
        
            // Destinatarios
            $mail->setFrom($correo, 'ACTUALIZA GEM');
            $mail->addAddress($emailRemi, 'ACTUALIZA GEM');           // Añadir un destinatario
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
        
            // Archivos adjuntos (opcional)
            //$mail->addAttachment('/var/tmp/file.tar.gz');               // Añadir archivos adjuntos
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');          // Nombre opcional
        
            // Contenido
            $mail->isHTML(true);                                        // Establecer el formato de correo a HTML
            $mail->Subject = 'RESPUESTA ACTUALIZA GEM';
            $mail->Body = '
            <html>
                <head>
                    <style>
                        table {
                            border-collapse: collapse;
                            width: 40%;
                            margin: 0 auto;
                        }
                        th, td {
                            border: 3px solid #e29b3a;
                            padding: 10px;
                            text-align: left;
                            color: black;
                        }
                        th {
                            background-color: #d5505c;
                            color: white;
                        }
                        h1 {
                            text-align: center;
                            color: black;
                            font:bold;
                        }
                    </style>
                </head>
                <body>
                    <h1><b>Sistema ActualizaGem </b></h1>
                    <table>
                        <tr>
                            <td colspan="2" style="color: black; background-color: #d5505c; font-size: 150%; text-align: center;">
                            <b>Datos del Servidor Publico: '.$nombre. '</b></td>
                        </tr>
                        <tr>
                            <td style="color: black; background-color: #d5505c; font-size: 100%; text-align: center;"><b>OBSERVACIONES:</b></td>
                            <td>' . $comentarios . '</td>
                        </tr>
                        <tr>
                            <td style="color: black; background-color: #d5505c; font-size: 100%; text-align: center;"><b>ESTATUS:</b></td>
                            <td>' . $estatus . '</td>
                        </tr>
                    </table>
                </body>
            </html>';
            $mail->AltBody = 'Este es el contenido del correo en texto plano para clientes de correo que no soportan HTML';
        
            $mail->send();

            echo json_encode(['status' => 1]); 
        } catch (Exception $e) {
            echo "Error: {$mail->ErrorInfo}";
        }

    }else {
        echo json_encode(['status' => 3]); 
    }
    


}else{
    //SE CAMBIA A RECHAZADO
    $estatus='RECHAZADO';
    $camposarray = array("estatus"=>$estatus, "comentarios"=>$comentarios);
    $consulta->where("clave_sp",$claveSp);
    $consulta->update("det_peticiones", $camposarray);
    echo json_encode(['status' => 2]); 

     //realizamos el envio del correo 
        //variables para el correo
        $mail = new PHPMailer(true);
        $correo = 'actualizagemres@gmail.com';
       
        try {
            // Configuraciones del servidor SMTP
        //    $mail->isSMTP();                                            // Usar SMTP
        //    $mail->Host       = 'smtp.example.com';                     // Servidor SMTP
        //    $mail->SMTPAuth   = true;                                   // Habilitar autenticación SMTP
        //    $mail->Username   = 'user@example.com';                     // Nombre de usuario SMTP
        //    $mail->Password   = 'secret';                               // Contraseña SMTP
        //    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Habilitar encriptación TLS, PHPMailer::ENCRYPTION_SMTPS también es aceptable
        //    $mail->Port       = 587;                                    // Puerto TCP al que conectarse
        
            $mail->SMTPDebug = 2;  // Sacar esta línea para no mostrar salida debug
            $mail->isSMTP();
        
            $mail->Host = 'smtp.gmail.com';  // Host de conexión SMTP
            $mail->SMTPAuth = true;
            $mail->Username = $correo;                 // Usuario SMTP
            $mail->Password = 'cypgnadocpiftrjo';                           // Password SMTP
            $mail->SMTPSecure = 'tls';                            // Activar seguridad TLS
            //$mail->Port = 587;
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        
            // Destinatarios
            $mail->setFrom($correo, 'ACTUALIZA GEM');
            $mail->addAddress($emailRemi, 'ACTUALIZA GEM ');           // Añadir un destinatario
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
        
            // Archivos adjuntos (opcional)
            //$mail->addAttachment('/var/tmp/file.tar.gz');               // Añadir archivos adjuntos
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');          // Nombre opcional
        
            // Contenido
            $mail->isHTML(true);                                        // Establecer el formato de correo a HTML
            $mail->Subject = 'RESPUESTA ACTUALIZA GEM';
            $mail->Body = '
            <html>
                <head>
                    <style>
                        table {
                            border-collapse: collapse;
                            width: 40%;
                            margin: 0 auto;
                        }
                        th, td {
                            border: 3px solid #e29b3a;
                            padding: 10px;
                            text-align: left;
                            color: black;
                        }
                        th {
                            background-color: #d5505c;
                            color: white;
                        }
                        h1 {
                            text-align: center;
                            color: black;
                            font:bold;
                        }
                    </style>
                </head>
                <body>
                    <h1><b>Sistema ActualizaGem </b></h1>
                    <table>
                        <tr>
                            <td colspan="2" style="color: black; background-color: #d5505c; font-size: 150%; text-align: center;">
                            <b>Datos del Servidor Publico: '.$nombre. '</b></td>
                        </tr>
                        <tr>
                            <td style="color: black; background-color: #d5505c; font-size: 100%; text-align: center;"><b>OBSERVACIONES:</b></td>
                            <td>' . $comentarios . '</td>
                        </tr>
                        <tr>
                            <td style="color: black; background-color: #d5505c; font-size: 100%; text-align: center;"><b>ESTATUS:</b></td>
                            <td>' . $estatus . '</td>
                        </tr>
                    </table>
                </body>
            </html>';
            $mail->AltBody = 'Este es el contenido del correo en texto plano para clientes de correo que no soportan HTML';
        
            $mail->send();

            echo json_encode(['status' => 1]); 
        } catch (Exception $e) {
            echo "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
        }
}

