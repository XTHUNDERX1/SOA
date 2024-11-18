<?php
$connection_string = "postgresql://william:1UBq6PxYt6buLtcmDSwGpWKd84Ij5yuD@dpg-cstcek56l47c73ejj0o0-a/eventos_peru";

// Intentamos establecer la conexión
$conn = pg_pconnect($connection_string);

if (!$conn) {
    echo "Conexión fallida: " . pg_last_error();
} else {
    echo "Conexión exitosa a la base de datos eventos_peru";
}
?>
