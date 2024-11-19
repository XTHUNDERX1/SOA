<?php
include 'connect.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM proveedores WHERE ProveedorID = $id");
$proveedor = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $reputacion = $_POST['reputacion'];

    $sql = "UPDATE proveedores SET 
            NombreProveedor = '$nombre', 
            Telefono = '$telefono', 
            Email = '$email', 
            Direccion = '$direccion', 
            Reputacion = $reputacion 
            WHERE ProveedorID = $id";
    if ($conn->query($sql)) {
        header('Location: index.php');
    } else {
        echo 'Error: ' . $conn->error;
    }
}
?>