<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                //Enable verbose debug output
    $mail->isSMTP();
    $mail->Host       = MAIL_HOST;                     //Configure el servidor SMTP para enviar
    $mail->SMTPAuth   = true;                          // Habilita la autenticación SMTP
    $mail->Username   = MAIL_USER;                     //Usuario SMTP
    $mail->Password   = MAIL_PASS;                     //Contraseña SMTP                             
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   //Habilitar el cifrado TLS
    $mail->Port       = MAIL_PORT;                     //Puerto TCP al que conectarse, si usa 587 agregar `SMTPSecure = PHPMailer :: ENCRYPTION_STARTTLS`

    //Correo emisor y nombre
    $mail->setFrom(MAIL_USER, 'CDP');
    //Correo receptor y nombre
    $mail->addAddress('contacto@codigosdeprogramacion.com', 'Contacto CDP');
    //Enviar copia correo
    $mail->addReplyTo('contacto@codigosdeprogramacion.com');

    //Contenido
    $mail->isHTML(true);   //Establecer el formato de correo electrónico en HTML
    $mail->Subject = 'Detalles de su pedido'; //Titulo del correo

    $cuerpo = "<h4>Gracias por su compra</h4>";
    $cuerpo .= '<p>El ID de su compra es: <b>' . $idTransaccion . '</b></p>';

    //Cuerpo del correo
    $mail->Body    = utf8_decode($cuerpo);
    $mail->AltBody = 'Le enviamos los detalles de su compra.';

    $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');

    //Enviar correo
    $mail->send();
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Error de envío: {$mail->ErrorInfo}";
}
