<?php
// olvidar_password.php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'] ?? '';
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'error' => 'Email inválido']);
        exit;
    }
    
    // Verificar si el usuario existe
    include 'conexion.php';
    try {
        $stmt = $pdo->prepare("CALL sp_buscar_usuario_email(?)");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$usuario) {
            echo json_encode(['success' => false, 'error' => 'Este email no está registrado']);
            exit;
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error al verificar usuario']);
        exit;
    }
    
    $token = sprintf("%06d", random_int(100000, 999999));
    
    $mail = new PHPMailer(true);
    
    try {
        // ⚠️ CONFIGURACIÓN GMAIL - REEMPLAZA CON TUS DATOS
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ratzingamellali@gmail.com'; // REEMPLAZA
        $mail->Password = 'ikdv weym qzpm ppsg';     // REEMPLAZA (16 dígitos)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';
        
        $mail->setFrom('ratzingamellali@gmail.com', 'Pink Alert');
        $mail->addAddress($email);
        
        $mail->isHTML(true);
        $mail->Subject = '🔐 Token de Recuperación - Pink Alert';
        $mail->Body = "
            <h2>Pink Alert - Token de Recuperación</h2>
            <p>Hola <strong>{$usuario['nombreUsuario']}</strong>,</p>
            <p>Tu token es: <strong style='font-size: 24px; color: #FF5252;'>$token</strong></p>
            <p>Usa este código para recuperar tu cuenta.</p>
            <p><em>Expira en 15 minutos</em></p>
        ";
        
        $mail->send();
        
        echo json_encode([
            'success' => true,
            'mensaje' => '✅ Token enviado correctamente',
            'token' => $token
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Error al enviar email: ' . $e->getMessage()
        ]);
    }
}
?>