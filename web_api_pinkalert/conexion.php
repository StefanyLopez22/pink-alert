<?php

$host = "mysql-1a3d.railway.internal";
$user = "root";
$pass = "qqEwosZNNPVWzDHMlNNLZufIniyZOkUn";
$dbname = "railway";
$port = 3306;

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>
