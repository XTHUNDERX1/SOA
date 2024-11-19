<?php
include 'connect.php';

$id = $_GET['id'];
$sql = "DELETE FROM proveedores WHERE ProveedorID = $id";

if ($conn->query($sql)) {
    header('Location: dashboard_proveedores.php');
} else {
    echo 'Error: ' . $conn->error;
}
?>