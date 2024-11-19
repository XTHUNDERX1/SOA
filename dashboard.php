<?php
// Asegúrate de que la conexión es correcta con PDO
$servername = "127.0.0.1";
$username = "u855900840_william";
$password = "SOA@utp123";
$dbname = "u855900840_eventos_peru";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Verificación de la conexión
    echo "Conexión exitosa!<br>";
} catch(PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
    exit;
}

// Consulta de usuarios
$query = "SELECT UsuarioID, NombreUsuario, Email, NombreRol FROM Usuarios INNER JOIN roles ON Usuarios.RolID = roles.RolID";
try {
    // Ejecutar la consulta
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Comprobar si hay resultados
    if (empty($result)) {
        echo "No se encontraron usuarios.<br>";
    } else {
        // Mostrar los resultados
        echo "<table class='table table-bordered table-striped'>
                <thead class='thead-dark'>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de Usuario</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>";

        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['UsuarioID'] . "</td>";
            echo "<td>" . $row['NombreUsuario'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . $row['NombreRol'] . "</td>";
            echo "<td>
                    <a href='edit_user.php?id=" . $row['UsuarioID'] . "' class='btn btn-primary btn-sm'>Editar</a>
                    <a href='delete_user.php?id=" . $row['UsuarioID'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar este usuario?\")'>Eliminar</a>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    }
} catch(PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
?>
