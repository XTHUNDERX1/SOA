<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombreProveedor'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $reputacion = $_POST['reputacion'];

    $sql = "INSERT INTO proveedores (NombreProveedor, Telefono, Email, Direccion, Reputacion) 
            VALUES ('$nombre', '$telefono', '$email', '$direccion', $reputacion)";
    if ($conn->query($sql)) {
        header('Location:dashboard_proveedores.php ');
    } else {
        echo 'Error: ' . $conn->error;
    }
}
?>  