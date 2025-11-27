<?php
$servername = "localhost:3306";
$username = "root";
$password = "123456";
$dbname = "bd_sistema_login";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("call bd_sistema_login.sp_buscar_usuario();
");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    echo json_encode($result);

   
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>