<?php
// URL de conexión a PostgreSQL
$dsn = "pgsql:host=dpg-cstcek56l47c73ejj0o0-a;port=5432;dbname=eventos_peru";
$username = "william";
$password = "1UBq6PxYt6buLtcmDSwGpWKd84Ij5yuD";

try {
    // Crear la conexión usando PDO
    $conn = new PDO($dsn, $username, $password);
    // Establecer el modo de error de PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos eventos_peru en Render";

    // Consulta de prueba
    $query = "SELECT NOW()"; // Devuelve la fecha y hora actual
    $stmt = $conn->query($query);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<br>Consulta exitosa. Hora actual en la base de datos: " . $row['now'];
} catch (PDOException $e) {
    // Manejo de errores
    echo "Conexión fallida: " . $e->getMessage();
}
?>
