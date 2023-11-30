<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $destinatario = $_POST["destinatario"];
    $asunto = $_POST["asunto"];
    $mensaje = $_POST["mensaje"];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'chris.kakashin1292@gmail.com';
        $mail->Password = 'gzja wpkb cqzo vdhc'; // Coloca tu contraseña correcta aquí
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('chris.kakashin1292@gmail.com', 'Christian');
        $mail->addAddress($destinatario);

        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje;

        $mail->send();

        // Redirige a contacto_formulario.php con el parámetro exito
        header("Location: contacto_formulario.php?exito=true");
        exit();

    } catch (Exception $e) {
        // Redirige a contacto_formulario.php con el parámetro error
        header("Location: contacto_formulario.php?exito=false&error={$mail->ErrorInfo}");
        exit();
    }
}
?>
