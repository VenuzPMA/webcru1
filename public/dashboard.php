<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }
        #content {
            flex-grow: 1;   
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php require '../includes/menu.php'; ?>

    <!-- Contenido principal -->
    <div id="content">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Este es tu panel principal. Usa el menú a la izquierda para navegar.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
