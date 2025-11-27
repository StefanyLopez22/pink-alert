<?php
header('Content-Type: application/json');

$nombreUsuario = $_REQUEST['nombreUsuario'];
$apPaterno = $_REQUEST['apPaterno'];
$apMaterno = $_REQUEST['apMaterno'];
$emailUsuario = $_REQUEST['emailUsuario'];
$telCelularUsuario = $_REQUEST['telCelularUsuario'];
$nombreLogin = $_REQUEST['nombreLogin'];
$passwordLogin = $_REQUEST['passwordLogin'];
$idRolUsuario = $_REQUEST['idRolUsuario'];

$servername = "localhost";
$username = "root";
$password = "123456"; // o "" si tu MySQL no tiene contraseña
$dbname = "bd_sistema_login";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("CALL sp_crear_cuenta(
        :nombreUsuario, :apPaterno, :apMaterno, :emailUsuario,
        :telCelularUsuario, :nombreLogin, :passwordLogin, :idRolUsuario)");

    $stmt->bindParam(':nombreUsuario', $nombreUsuario);
    $stmt->bindParam(':apPaterno', $apPaterno);
    $stmt->bindParam(':apMaterno', $apMaterno);
    $stmt->bindParam(':emailUsuario', $emailUsuario);
    $stmt->bindParam(':telCelularUsuario', $telCelularUsuario);
    $stmt->bindParam(':nombreLogin', $nombreLogin);
    $stmt->bindParam(':passwordLogin', $passwordLogin);
    $stmt->bindParam(':idRolUsuario', $idRolUsuario, PDO::PARAM_INT);

    $stmt->execute();

    echo json_encode(["mensaje" => "Se creó la cuenta correctamente."]);
} catch(PDOException $e) {
    echo json_encode(["error" => "Error: " . $e->getMessage()]);
}

$conn = null;
?>
