<?php
session_start(); // Inicia la sesión
session_destroy(); // Destruye todos los datos de la sesión
header('Location: login.php'); // Redirige al usuario a la página de login
exit; // Finaliza el script para asegurarse de que no se ejecute más código
?>
