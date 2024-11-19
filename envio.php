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

// Validar que la calificación esté en el rango de 1 a 5
if ($calificacion < 1 || $calificacion > 5) {
    echo "La calificación debe estar entre 1 y 5.";
    exit;
}

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
        // Preparar el mensaje del correo
        $subject = "Nuevo Feedback para Evento ID: $evento_id";
        $message = "Se ha recibido un nuevo feedback para el evento con ID: $evento_id.\n\n";
        $message .= "Comentarios: $comentarios\n";
        $message .= "Calificación: $calificacion\n";

        // Cabeceras del correo
        $headers = "From: marengo_2013@hotmail.com\r\n"; // Cambia a tu dominio o correo desde el que se enviará
        $headers .= "Reply-To: $comentarios\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Enviar el correo
        if (mail("william220418@gmail.com", $subject, $message, $headers)) {
            echo "El correo fue enviado correctamente.";
        } else {
            echo "Error al enviar el correo.";
        }

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
