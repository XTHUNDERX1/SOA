<?php
include 'connect.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM proveedores WHERE ProveedorID = $id");
$proveedor = $result->fetch_assoc();

if (!$proveedor) {
    // Si no se encuentra el proveedor, redirige al dashboard de proveedores
    header('Location: dashboard_proveedores.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombreProveedor'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $reputacion = $_POST['reputacion'];

    // Aquí podrías agregar validaciones, por ejemplo:
    if (empty($nombre) || empty($telefono) || empty($email)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // SQL para actualizar los datos del proveedor
        $sql = "UPDATE proveedores SET 
                NombreProveedor = '$nombre', 
                Telefono = '$telefono', 
                Email = '$email', 
                Direccion = '$direccion', 
                Reputacion = $reputacion 
                WHERE ProveedorID = $id";
        
        if ($conn->query($sql)) {
            header('Location: dashboard_proveedores.php');
            exit();
        } else {
            $error = "Error al actualizar los datos: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Editar Proveedor</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> <!-- Enlace a Bootstrap -->
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 350px;">
        <h2 class="card-title text-center mb-4">Editar Proveedor</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="update_proveedor.php?id=<?php echo $proveedor['ProveedorID']; ?>" method="POST">
            <div class="form-group">
                <label for="nombreProveedor">Nombre del Proveedor</label>
                <input type="text" class="form-control" name="nombreProveedor" value="<?php echo $proveedor['NombreProveedor']; ?>" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" name="telefono" value="<?php echo $proveedor['Telefono']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo $proveedor['Email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" name="direccion" value="<?php echo $proveedor['Direccion']; ?>" required>
            </div>
            <div class="form-group">
                <label for="reputacion">Reputación</label>
                <input type="number" class="form-control" name="reputacion" value="<?php echo $proveedor['Reputacion']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Actualizar Proveedor</button>
        </form>
    </div>
</body>
</html>
