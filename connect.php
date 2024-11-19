<?php
$servername = "127.0.0.1";  // El servidor de la base de datos
$username = "u855900840_william";      // Tu usuario de base de datos
$password = "SOA@utp123";              // Tu contraseña de base de datos
$dbname = "u855900840_eventos_peru";   // Nombre de la base de datos

try {
    // Crear conexión con PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Establecer el modo de error a excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa!";
}
catch(PDOException $e) {
    // Capturar errores en la conexión
    echo "Conexión fallida: " . $e->getMessage();
}
?>
