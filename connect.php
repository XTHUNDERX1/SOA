<?php
// URL de conexión a PostgreSQL
$conn_string = "postgresql://william:1UBq6PxYt6buLtcmDSwGpWKd84Ij5yuD@dpg-cstcek56l47c73ejj0o0-a/eventos_peru";

// Crear la conexión usando pg_connect
$conn = pg_connect($conn_string);

// Verificar la conexión
if (!$conn) {
    die("Conexión fallida: " . pg_last_error());
} 
echo "Conexión realizada con la base de datos eventos_peru";
?>
