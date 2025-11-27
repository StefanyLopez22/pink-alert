<?php
$idusuario = $_REQUEST['idusuario'];
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "bd_sistema_login";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("CALL Eliminar_un_usuario(:id);");
    $stmt->bindParam(':id', $idusuario);
    $stmt->execute();

    $response = ["mensaje" => "Usuario eliminado correctamente"];

    echo json_encode($response);
} catch(PDOException $e) {

    $response = ["error" => "Error al eliminar usuario: " . $e->getMessage()];
    echo json_encode($response);
}

$conn = null;
?>