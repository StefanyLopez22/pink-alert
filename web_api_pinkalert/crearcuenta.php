<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Para permitir peticiones desde tu app Android

// Obtener parámetros (soporta GET y POST)
$nombreUsuario = $_REQUEST['nombreUsuario'] ?? '';
$apPaterno = $_REQUEST['apPaterno'] ?? '';
$apMaterno = $_REQUEST['apMaterno'] ?? '';
$emailUsuario = $_REQUEST['emailUsuario'] ?? '';
$telCelularUsuario = $_REQUEST['telCelularUsuario'] ?? '';
$nombreLogin = $_REQUEST['nombreLogin'] ?? '';
$passwordLogin = $_REQUEST['passwordLogin'] ?? '';
$idRolUsuario = $_REQUEST['idRolUsuario'] ?? 2;

// Validar campos obligatorios
if (empty($nombreUsuario) || empty($emailUsuario) || empty($nombreLogin) || empty($passwordLogin)) {
    echo json_encode(["error" => "Faltan campos requeridos"]);
    exit;
}

// TUS DATOS DE PROFREEHOST
$servername = "sql100.ezyro.com";           // Host de MySQL
$username = "ezyro_40532593";               // Usuario MySQL
$password = "Taylor13";                     // Contraseña
$dbname = "ezyro_40532593_pink_alert";      // Base de datos

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // LLAMAR A TU PROCEDIMIENTO ALMACENADO sp_crear_cuenta
    $stmt = $conn->prepare("CALL sp_crear_cuenta(:nombreUsuario, :apPaterno, :apMaterno, :emailUsuario, :telCelularUsuario, :nombreLogin, :passwordLogin, :idRolUsuario)");

    $stmt->bindParam(':nombreUsuario', $nombreUsuario);
    $stmt->bindParam(':apPaterno', $apPaterno);
    $stmt->bindParam(':apMaterno', $apMaterno);
    $stmt->bindParam(':emailUsuario', $emailUsuario);
    $stmt->bindParam(':telCelularUsuario', $telCelularUsuario);
    $stmt->bindParam(':nombreLogin', $nombreLogin);
    $stmt->bindParam(':passwordLogin', $passwordLogin);
    $stmt->bindParam(':idRolUsuario', $idRolUsuario, PDO::PARAM_INT);

    $stmt->execute();

    echo json_encode(["success" => true, "mensaje" => "Cuenta creada correctamente."]);
    
} catch(PDOException $e) {
    echo json_encode(["success" => false, "error" => "Error: " . $e->getMessage()]);
}

$conn = null;
?>