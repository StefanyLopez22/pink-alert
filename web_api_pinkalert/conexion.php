<?php
// conexion.php - NOMBRE CORRECTO
$host = 'localhost';
$dbname = 'bd_sistema_login';  // ⚠️ ESTE ES EL NOMBRE CORRECTO
$username = 'root';
$password = '123456';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "✅ Conexión exitosa a $dbname";
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}
?>