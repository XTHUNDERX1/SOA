<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $query = "SELECT * FROM Usuarios WHERE UsuarioID = $userId";
    $result = $conn->query($query);
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Editar Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> <!-- Enlace a Bootstrap -->
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 350px;">
        <h2 class="card-title text-center mb-4">Editar Usuario</h2>
        <form action="update_user.php" method="POST">
            <input type="hidden" name="UsuarioID" value="<?php echo $user['UsuarioID']; ?>">
            <div class="form-group">
                <label for="nombreUsuario">Nombre de Usuario</label>
                <input type="text" class="form-control" name="nombreUsuario" value="<?php echo $user['NombreUsuario']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo $user['Email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="rolID">Rol</label>
                <select class="form-control" name="rolID" required>
                    <option value="1" <?php if ($user['RolID'] == 1) echo 'selected'; ?>>Administrador</option>
                    <option value="2" <?php if ($user['RolID'] == 2) echo 'selected'; ?>>Usuario</option>
                    <option value="3" <?php if ($user['RolID'] == 3) echo 'selected'; ?>>Moderador</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Actualizar Usuario</button>
        </form>
    </div>
</body>
</html>
