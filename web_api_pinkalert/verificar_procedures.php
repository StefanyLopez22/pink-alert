<?php
// verificar_procedures.php
header('Content-Type: text/html; charset=utf-8');
include 'conexion.php';

try {
    echo "<h2>🔍 Verificando Stored Procedures</h2>";
    
    // Verificar procedures existentes
    $procedures = $pdo->query("
        SHOW PROCEDURE STATUS WHERE Db = 'bd_sistema_login'
    ")->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>📋 Stored Procedures existentes:</h3>";
    if (count($procedures) > 0) {
        echo "<ul>";
        foreach ($procedures as $proc) {
            echo "<li>" . $proc['Name'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No hay stored procedures</p>";
    }
    
    // Probar el procedure por email
    echo "<h3>🧪 Probando sp_buscar_usuario_email:</h3>";
    $email_prueba = 'stefanyausenciolopez@gmail.com';
    
    $stmt = $pdo->prepare("CALL sp_buscar_usuario_email(?)");
    $stmt->execute([$email_prueba]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($resultado) {
        echo "<p style='color: green;'>✅ Usuario encontrado:</p>";
        echo "<pre>" . print_r($resultado, true) . "</pre>";
    } else {
        echo "<p style='color: red;'>❌ No se encontró usuario</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>