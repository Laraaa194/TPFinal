<?php

require_once __DIR__ . '/../vendor/phpmailer/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;


class EmailHelper{
    public static function enviarVerificacion($nombre, $email, $token,$id)
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sabiamente209@gmail.com';
        $mail->Password   = 'zosz qaan ibli uawi';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('tucorreo@gmail.com', 'SabiaMente');
        $mail->addAddress($email, $nombre);

        $mail->isHTML(true);
        $mail->Subject = 'Verifica tu cuenta';
        $url = "http://localhost/Register/verificar?token=$token&idJugador=$id";
        $mail->Body    = "Hola $nombre,<br><br>Hacé clic en el siguiente enlace para verificar tu cuenta:<br>
                              <a href='$url'>$url</a><br><br>Si no creaste esta cuenta, ignorá este mensaje.";
        $mail->AltBody = "Hola $nombre, visitá este enlace para verificar tu cuenta: $url";

        $mail->send();
        return true;
      }

}




