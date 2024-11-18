<?php
$servername = "dpg-cstcek56l47c73ejj0o0-a";
$username = "william"; // Nombre de usuario por defecto en XAMPP
$password = "1UBq6PxYt6buLtcmDSwGpWKd84Ij5yuD";     // Contraseña por defecto en XAMPP (normalmente está en blanco)
$database = "eventos_peru";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

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
    $sql = "INSERT INTO Usuarios (NombreUsuario, Email, Contraseña, RolID) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombreUsuario, $email, $contraseñaEncriptada, $rolID);

    if ($stmt->execute()) {
        echo "Usuario registrado exitosamente.";
    } else {
        echo "Error: " . $stmt->error; // Muestra el error en caso de que falle
    }

    $stmt->close();
}

$conn->close();
?>
