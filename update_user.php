<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['UsuarioID'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $email = $_POST['email'];
    $rolID = $_POST['rolID'];

    $query = "UPDATE Usuarios SET NombreUsuario = '$nombreUsuario', Email = '$email', RolID = $rolID WHERE UsuarioID = $userId";

    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Usuario actualizado con éxito');window.location='dashboard.html';</script>";
    } else {
        echo "Error al actualizar el usuario: " . $conn->error;
    }
}
?>
