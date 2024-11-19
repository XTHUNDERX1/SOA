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

    // Verificar si se encontró al usuario y si la contraseña coincide
    if ($user && password_verify($password, $user['Contraseña'])) {
        $_SESSION['UsuarioID'] = $user['UsuarioID'];
        $_SESSION['NombreUsuario'] = $user['NombreUsuario'];
        $_SESSION['RolID'] = $user['RolID'];

        // Redirigir según el rol del usuario
        switch ($user['RolID']) {
            case 1: // Administrador
                header('Location: dashboard.php');
                break;
            case 2: // Usuario regular
                header('Location: home.php');
                break;
            case 3: // Proveedor
                header('Location: registro_proveedor.html');
                break;
            default: // Rol desconocido
                echo "<script>alert('Rol desconocido, contacte al administrador.');window.location='login.html';</script>";
                break;
        }
        exit();
    } else {
        // Mostrar un mensaje de error si el email o contraseña no coinciden
        echo "<script>alert('Email o contraseña incorrectos');window.location='login.html';</script>";
    }
}
?>
