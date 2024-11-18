<?php
// Parámetros de conexión
$host = "dpg-cstcek56l47c73ejj0o0-a"; // Host de tu base de datos en Render
$port = "5432"; // Puerto para PostgreSQL
$dbname = "eventos_peru"; // Nombre de la base de datos
$user = "william"; // Usuario
$password = "1UBq6PxYt6buLtcmDSwGpWKd84Ij5yuD"; // Contraseña

// Crear la cadena de conexión
$connection_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Intenta conectar
$conn = pg_connect($connection_string);

if (!$conn) {
    die("Conexión fallida: " . pg_last_error());
} else {
    echo "Conexión exitosa a la base de datos PostgreSQL en Render";
}

// Realiza consultas, por ejemplo:
$query = "SELECT * FROM tabla_test";
$result = pg_query($conn, $query);
if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        echo "ID: " . $row['id'] . " - Nombre: " . $row['nombre'] . "<br>";
    }
} else {
    echo "Error en la consulta: " . pg_last_error();
}

// Cierra la conexión
pg_close($conn);
?>
