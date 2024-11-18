<?php
$servername = "localhost";
$username = "root"; // Nombre de usuario por defecto en XAMPP
$password = "";     // Contraseña por defecto en XAMPP (normalmente está en blanco)
$database = "eventos_peru";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} 
echo  "conexion realizada con la base de datos eventos_peru";
?>
