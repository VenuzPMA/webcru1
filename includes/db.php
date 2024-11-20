<?php
$host = 'localhost';
$dbname = 'Crudbg';
$user = 'root'; // Cambiar si usas otro usuario
$password = 'admin'; // Cambiar si tienes contraseña configurada

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password); // Cambio aquí de $pdo a $db
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
