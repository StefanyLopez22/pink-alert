<?php
// test_email_corregido.php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);

try {
    // ⚠️ CONFIGURACIÓN CORREGIDA
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'tu_correo@gmail.com'; // SOLO el email, sin espacios
    $mail->Password = 'neroarzgkmmnbmhi'; // ⚠️ QUITA LOS ESPACIOS de "nero arzg kmmn bmhi"
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->SMTPDebug = 2; // ⚠️ ACTIVA DEBUG para ver el problema
    $mail->Debugoutput = 'html';
    
    $mail->setFrom('tu_correo@gmail.com', 'Pink Alert Test');
    $mail->addAddress('ausenciolopez@gmail.com');
    
    $mail->isHTML(true);
    $mail->Subject = '✅ Test PHPMailer Corregido';
    $mail->Body = '<h1>Test con configuración corregida</h1>';
    
    $mail->send();
    echo "✅ Email enviado correctamente!";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
    echo "<br>Debug: " . $mail->ErrorInfo;
}
?>