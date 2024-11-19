<?php
$servername = "localhost";  // El servidor de la base de datos
$username = "u855900840_william";      // Tu usuario de base de datos
$password = "SOA@utp123";              // Tu contraseña de base de datos
$dbname = "u855900840_eventos_peru";   // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa";
?>