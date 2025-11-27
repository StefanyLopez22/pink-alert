<?php
// verificar_todo.php
header('Content-Type: text/html; charset=utf-8');
include 'conexion.php';

try {
    echo "<h2>✅ Verificando Configuración Completa</h2>";
    
    // 1. Verificar conexión
    echo "<p style='color: green;'><strong>1. Conexión:</strong> ✅ Exitosa a bd_sistema_login</p>";
    
    // 2. Verificar tabla usuario
    echo "<h3>2. 📊 Tabla 'usuario':</h3>";
    $tabla = $pdo->query("SHOW TABLES LIKE 'usuario'")->fetch(PDO::FETCH_COLUMN);
    
    if ($tabla) {
        echo "<p style='color: green;'>✅ La tabla 'usuario' existe</p>";
        
        // Mostrar estructura
        $estructura = $pdo->query("DESCRIBE usuario")->fetchAll(PDO::FETCH_ASSOC);
        echo "<h4>Estructura de la tabla:</h4>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Campo</th><th>Tipo</th></tr>";
        foreach ($estructura as $campo) {
            echo "<tr><td>{$campo['Field']}</td><td>{$campo['Type']}</td></tr>";
        }
        echo "</table>";
        
        // Mostrar algunos usuarios
        $usuarios = $pdo->query("SELECT idusuario, nombreUsuario, emailUsuario FROM usuario LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
        echo "<h4>👥 Primeros 5 usuarios:</h4>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Email</th></tr>";
        foreach ($usuarios as $usuario) {
            echo "<tr>";
            echo "<td>" . $usuario['idusuario'] . "</td>";
            echo "<td>" . $usuario['nombreUsuario'] . "</td>";
            echo "<td>" . $usuario['emailUsuario'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // 3. Verificar stored procedures
    echo "<h3>3. 📋 Stored Procedures:</h3>";
    $procedures = $pdo->query("SHOW PROCEDURE STATUS WHERE Db = 'bd_sistema_login'")->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($procedures) > 0) {
        echo "<ul>";
        foreach ($procedures as $proc) {
            $check = ($proc['Name'] == 'sp_buscar_usuario_email') ? " ✅" : "";
            echo "<li>" . $proc['Name'] . $check . "</li>";
        }
        echo "</ul>";
    }
    
    // 4. Probar el stored procedure de email
    echo "<h3>4. 🧪 Probando sp_buscar_usuario_email:</h3>";
    
    $emails_prueba = ['stefanyausenciolopez@gmail.com', 'alfredo@gmail.com'];
    
    foreach ($emails_prueba as $email) {
        echo "<h4>Buscando: $email</h4>";
        
        try {
            $stmt = $pdo->prepare("CALL sp_buscar_usuario_email(?)");
            $stmt->execute([$email]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($resultado) {
                echo "<p style='color: green;'>✅ Usuario encontrado:</p>";
                echo "<pre>" . print_r($resultado, true) . "</pre>";
            } else {
                echo "<p style='color: orange;'>⚠️ No se encontró usuario con ese email</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Error al ejecutar procedure: " . $e->getMessage() . "</p>";
        }
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Error general: " . $e->getMessage() . "</p>";
}
?>