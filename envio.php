<?php
// Asegúrate de que la conexión es correcta con PDO
$servername = "127.0.0.1";
$username = "u855900840_william";
$password = "SOA@utp123";
$dbname = "u855900840_eventos_peru";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Verificación de la conexión
} catch(PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
    exit;
}

// Obtener los datos del formulario
$evento_id = $_POST['evento_id'];
$comentarios = $_POST['comentarios'];
$calificacion = $_POST['calificacion'];

// Preparar la consulta SQL
$sql = "INSERT INTO feedback (EventoID, Comentarios, Calificacion) VALUES (?, ?, ?)";

// Preparar la declaración
$stmt = $conn->prepare($sql);
$stmt->bind_param("isi", $evento_id, $comentarios, $calificacion);

// Ejecutar la declaración
if ($stmt->execute()) {
    echo "Consulta ejecutada con éxito.";
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
