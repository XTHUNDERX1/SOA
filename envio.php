<?php
// Asegúrate de que la conexión es correcta con PDO
$servername = "127.0.0.1";
$username = "u855900840_william";
$password = "SOA@utp123";
$dbname = "u855900840_eventos_peru";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
    exit;
}

// Obtener los datos del formulario
$evento_id = $_POST['evento_id'];
$comentarios = $_POST['comentarios'];
$calificacion = $_POST['calificacion'];

try {
    // Preparar la consulta SQL
    $sql = "INSERT INTO feedback (EventoID, Comentarios, Calificacion) VALUES (:evento_id, :comentarios, :calificacion)";
    $stmt = $conn->prepare($sql);

    // Asociar los parámetros
    $stmt->bindParam(':evento_id', $evento_id, PDO::PARAM_INT);
    $stmt->bindParam(':comentarios', $comentarios, PDO::PARAM_STR);
    $stmt->bindParam(':calificacion', $calificacion, PDO::PARAM_INT);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        // Redirigir al usuario después de un envío exitoso
        header("Location: user_home.html");
        exit; // Importante para detener la ejecución del script después de la redirección
    } else {
        echo "Error al ejecutar la consulta.";
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>
