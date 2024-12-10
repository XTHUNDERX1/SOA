<?php
// Iniciar sesión
session_start();

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al formulario de inicio de sesión
header("Location: login.html");
exit();
?>
