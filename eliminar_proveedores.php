<?php
include 'connect.php';

$id = $_GET['id'];
$sql = "DELETE FROM proveedores WHERE ProveedorID = $id";

if ($conn->query($sql)) {
    header('Location: index.php');
} else {
    echo 'Error: ' . $conn->error;
}
?>