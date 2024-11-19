<?php
include 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Preparar la consulta para buscar al usuario en la base de datos
    $query = "SELECT * FROM Usuarios WHERE Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verificación de depuración para ver si el usuario se está obteniendo
    if ($user) {
        echo "Usuario encontrado: " . print_r($user, true); // Esta línea es solo para depuración
    } else {
        echo "No se encontró ningún usuario con ese email.";
    }

    // Verificar si se encontró al usuario y si la contraseña coincide
    if ($user && password_verify($password, $user['Contraseña'])) {
        $_SESSION['UsuarioID'] = $user['UsuarioID'];
        $_SESSION['NombreUsuario'] = $user['NombreUsuario'];
        $_SESSION['RolID'] = $user['RolID'];

        // Redirigir según el rol del usuario
        if ($user['RolID'] == 1) { // Asumiendo que el rol de Administrador tiene el ID 1
            header('Location: dashboard.php'); // Redirigir al panel de control si es administrador
        } else {
            header('Location: user_home.html'); // Página de inicio para usuarios no administradores
        }
        exit();
    } else {
        // Mostrar un mensaje de error si el email o contraseña no coinciden
        echo "<script>alert('Email o contraseña incorrectos');window.location='login.html';</script>";
    }
}
?>
