<?php
// buscar_usuario_email.php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'] ?? '';
    
    if (empty($email)) {
        echo json_encode(['success' => false, 'error' => 'Email requerido']);
        exit;
    }
    
    try {
        // Llamar al stored procedure
        $stmt = $pdo->prepare("CALL sp_buscar_usuario_email(?)");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario) {
            echo json_encode([
                'success' => true,
                'usuario' => [
                    'id' => $usuario['idusuario'],
                    'nombre' => $usuario['nombreUsuario'],
                    'apPaterno' => $usuario['apPaterno'],
                    'apMaterno' => $usuario['apMaterno'],
                    'email' => $usuario['emailUsuario'],
                    'telefono' => $usuario['telCelularUsuario']
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Usuario no encontrado'
            ]);
        }
        
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Error: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>