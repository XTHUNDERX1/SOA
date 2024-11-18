<?php
// Detalles de conexión de PostgreSQL
$host = "dpg-cstcek56l47c73ejj0o0-a";  // Reemplaza con el host proporcionado por Render
$port = "5432";  // Puerto de PostgreSQL
$dbname = "eventos_peru";  // Nombre de la base de datos
$username = "william";  // Nombre de usuario proporcionado por Render
$password = "1UBq6PxYt6buLtcmDSwGpWKd84Ij5yuD";  // Contraseña proporcionada por Render

// Crear la conexión
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$username password=$password");

// Verificar la conexión
if (!$conn) {
    die("Conexión fallida: " . pg_last_error());
} 
echo "Conexión realizada con la base de datos eventos_peru";
?>
