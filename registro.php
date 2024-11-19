<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "u855900840_william";
$password = "SOA@utp123";
$dbname = "u855900840_eventos_peru";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
echo "Conexión exitosa.";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = $_POST['nombreUsuario'] ?? '';
    $email = $_POST['email'] ?? '';
    $contraseña = $_POST['contraseña'] ?? '';
    $rolID = $_POST['rolID'] ?? '';

    if (empty($nombreUsuario) || empty($email) || empty($contraseña) || empty($rolID)) {
        die("Faltan datos en el formulario.");
    }

    $contraseñaEncriptada = password_hash($contraseña, PASSWORD_DEFAULT);
    echo "Contraseña encriptada: $contraseñaEncriptada";

    $sql = "INSERT INTO Usuarios (NombreUsuario, Email, Contraseña, RolID) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("sssi", $nombreUsuario, $email, $contraseñaEncriptada, $rolID);
    
    if ($stmt->execute()) {
        echo "Usuario registrado exitosamente.";
    } else {
        die("Error en la ejecución: " . $stmt->error);
    }

    $stmt->close();
}
$conn->close();

?>
