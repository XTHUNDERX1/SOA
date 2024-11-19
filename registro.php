<?php
$servername = "localhost";  // El servidor de la base de datos
$username = "u855900840_william";      // Tu usuario de base de datos
$password = "SOA@utp123";              // Tu contraseña de base de datos
$dbname = "u855900840_eventos_peru";   // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario (debes implementar un formulario HTML)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = $_POST['nombreUsuario'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    $rolID = $_POST['rolID']; // Asumiendo que se obtiene el RolID de algún lugar

    // Encriptar la contraseña
    $contraseñaEncriptada = password_hash($contraseña, PASSWORD_DEFAULT);

    // Insertar usuario en la base de datos
    $sql = "INSERT INTO usuarios (NombreUsuario, Email, Contraseña, RolID) VALUES (?, ?, ?, ?)";
    
    // Preparar la consulta
    $stmt = $conn->prepare($sql);
    
    // Verificar si la preparación fue exitosa
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Enlazar los parámetros con la sentencia preparada
    $stmt->bind_param("sssi", $nombreUsuario, $email, $contraseñaEncriptada, $rolID);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Usuario registrado exitosamente.";
    } else {
        echo "Error: " . $stmt->error; // Muestra el error en caso de que falle
    }

    // Cerrar la sentencia
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>
