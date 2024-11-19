<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $query = "DELETE FROM Usuarios WHERE UsuarioID = $userId";
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Usuario eliminado con éxito');window.location='dashboard.php';</script>";
    } else {
        echo "Error al eliminar el usuario: " . $conn->error;
    }
}
?>
