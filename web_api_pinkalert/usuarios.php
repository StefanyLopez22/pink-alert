<?php
$idusuario = $_REQUEST['idusuario'];
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "bd_sistema_login";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("call bd_sistema_login.sp_buscar_usuario_id(:id);");
    $stmt -> bindParam(':id',$idusuario);
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    //convertir jason
    echo json_encode($result);
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
?>