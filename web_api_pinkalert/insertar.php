<?php
$nombreusuario = $_REQUEST['nombreusuario'];
$apPaterno = $_REQUEST['apPaterno'];
$apMaterno = $_REQUEST ['apMaterno'];
$emailUsuario =$_REQUEST['email'];
$telefono =$_REQUEST['telefono'];
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "bd_sistema_login";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("call bd_sistema_login.sp_insertar_usuario(:nombre, :apPaterno, :apMaterno, :email,:telefono);");

    $stmt->bindParam(':nombre', $nombreusuario);
    $stmt->bindParam(':apPaterno', $apPaterno);
    $stmt->bindParam(':apMaterno', $apMaterno);
    $stmt->bindParam(':email', $emailUsuario);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->execute();

    $response = ["mensaje" => "Se agrego el usuario correctamente"];

    echo json_encode($response);
} catch(PDOException $e) {

    $response = ["error" => "Error al agregar el usuario: " . $e->getMessage()];
    echo json_encode($response);
}

$conn = null;
?>