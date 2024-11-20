<?php
require '../includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Consulta a la base de datos para verificar las credenciales
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Si el usuario es válido, iniciar sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Correo o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: bold;
            color: #333;
        }
        .form-control {
            border-radius: 30px;
            box-shadow: none;
        }
        .btn-primary {
            background-color: #5C6BC0;
            border-color: #5C6BC0;
            border-radius: 30px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .btn-primary:hover {
            background-color: #3f51b5;
            border-color: #3f51b5;
        }
        .alert {
            border-radius: 10px;
        }
        .footer-text {
            text-align: center;
            color: #777;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center mb-4">Iniciar Sesión</h2>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-4">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control form-control-lg" id="email" name="email" required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control form-control-lg" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
