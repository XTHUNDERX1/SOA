<?php
include 'connect.php';
$result = $conn->query("SELECT * FROM proveedores");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Proveedores</title>
</head>
<body>
    <h1>Lista de Proveedores</h1>
    <a href="create.php">Agregar Proveedor</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Dirección</th>
            <th>Reputación</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['ProveedorID'] ?></td>
                <td><?= $row['NombreProveedor'] ?></td>
                <td><?= $row['Telefono'] ?></td>
                <td><?= $row['Email'] ?></td>
                <td><?= $row['Direccion'] ?></td>
                <td><?= $row['Reputacion'] ?></td>
                <td>
                    <a href="update.php?id=<?= $row['ProveedorID'] ?>">Editar</a>
                    <a href="delete.php?id=<?= $row['ProveedorID'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este proveedor?')">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>