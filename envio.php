<?php
// Conectar a la base de datos
$servername = "127.0.0.1";  // El servidor de la base de datos
$username = "u855900840_william";      // Tu usuario de base de datos
$password = "SOA@utp123";              // Tu contraseña de base de datos
$dbname = "u855900840_eventos_peru"; 

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
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
