<?php
$serverName = "FOAMY-PC"; 
$dbname = "miGuiaLocal";
$username = "userMGL";
$password = "pwsMGL";

try {
    // Crear conexión usando PDO
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$dbname", $username, $password);
    // Establecer el modo de error de PDO para excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
