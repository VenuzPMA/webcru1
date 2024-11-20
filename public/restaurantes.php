<?php
require_once '../includes/db.php';
require_once '../controllers/restaurantesController.php';

// Crear una instancia del controlador de restaurantes
$restaurantesController = new RestaurantesController($db);

// Variables para el manejo de errores y mensajes
$error = null;
$success = null;

// Obtener todos los restaurantes
$restaurantes = $restaurantesController->index();

// Agregar un nuevo restaurante
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $nombre = trim($_POST['nombre']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);
    $tipo_cocina = trim($_POST['tipo_cocina']);
    $horario_apertura = $_POST['horario_apertura'];
    $horario_cierre = $_POST['horario_cierre'];

    try {
        $restaurantesController->create($nombre, $direccion, $telefono, $tipo_cocina, $horario_apertura, $horario_cierre);
        header("Location: restaurantes.php?success=1");
        exit();
    } catch (Exception $e) {
        $error = "Error al agregar restaurante: " . $e->getMessage();
    }
}

// Editar un restaurante existente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);
    $tipo_cocina = trim($_POST['tipo_cocina']);
    $horario_apertura = $_POST['horario_apertura'];
    $horario_cierre = $_POST['horario_cierre'];

    try {
        // Verificar que el restaurante exista
        if ($restaurantesController->edit($id)) {
            $restaurantesController->update($id, $nombre, $direccion, $telefono, $tipo_cocina, $horario_apertura, $horario_cierre);
            header("Location: restaurantes.php?success=2");
            exit();
        } else {
            $error = "El restaurante no existe.";
        }
    } catch (Exception $e) {
        $error = "Error al actualizar restaurante: " . $e->getMessage();
    }
}

// Eliminar un restaurante
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $restaurantesController->delete($id);
        header("Location: restaurantes.php?success=3");
        exit();
    } catch (Exception $e) {
        $error = "Error al eliminar restaurante: " . $e->getMessage();
    }
}

// Obtener los datos de un restaurante para edición
$editRestaurante = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editRestaurante = $restaurantesController->edit($id);
}

// Alternar estado de visitado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    // Comprobar si visitado está presente en $_POST
    $visitado = isset($_POST['visitado']) ? 1 : 0; // Si el checkbox está marcado, visitado será 1, sino 0.

    try {
        $restaurantesController->toggleVisitado($id, $visitado);
        header("Location: restaurantes.php?success=4");
        exit();
    } catch (Exception $e) {
        $error = "Error al actualizar estado: " . $e->getMessage();
    }
}





?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            height: 100vh;
        }
        #content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }
        table {
            margin-top: 20px;
        }
        th, td {
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Menú incluido desde menu.php -->
    <?php include '../includes/menu.php'; ?>

    <div id="content">
        <h2 class="my-4">Lista de Restaurantes</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        <?php
        if ($_GET['success'] == 1) echo "Restaurante agregado exitosamente.";
        elseif ($_GET['success'] == 2) echo "Restaurante actualizado exitosamente.";
        elseif ($_GET['success'] == 3) echo "Restaurante eliminado exitosamente.";
        elseif ($_GET['success'] == 4) echo "Estado de visitado actualizado exitosamente.";
        ?>
    </div>
<?php endif; ?>


        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addRestauranteModal">Agregar Restaurante</button>

        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Tipo de Cocina</th>
                    <th>Horario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
    <?php foreach ($restaurantes as $restaurante): ?>
        <tr>
            <td><?= $restaurante['id'] ?></td>
            <td><?= $restaurante['nombre'] ?></td>
            <td><?= $restaurante['direccion'] ?></td>
            <td><?= $restaurante['telefono'] ?></td>
            <td><?= $restaurante['tipo_cocina'] ?></td>
            <td><?= $restaurante['horario_apertura'] . ' - ' . $restaurante['horario_cierre'] ?></td>
            <td>
                <!-- Alternar estado de visitado -->
                


                <a href="restaurantes.php?edit=<?= $restaurante['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                <a href="restaurantes.php?delete=<?= $restaurante['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

        </table>
    </div>

    <!-- Modal para agregar restaurante -->
    <div class="modal fade" id="addRestauranteModal" tabindex="-1" aria-labelledby="addRestauranteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRestauranteModalLabel">Agregar Restaurante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="restaurantes.php">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" name="direccion" id="direccion" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipo_cocina" class="form-label">Tipo de Cocina</label>
                            <input type="text" name="tipo_cocina" id="tipo_cocina" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="horario_apertura" class="form-label">Horario de Apertura</label>
                            <input type="time" name="horario_apertura" id="horario_apertura" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="horario_cierre" class="form-label">Horario de Cierre</label>
                            <input type="time" name="horario_cierre" id="horario_cierre" class="form-control" required>
                        </div>
                        <button type="submit" name="add" class="btn btn-success">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal para editar restaurante -->
     <?php if ($editRestaurante): ?>
    <div class="modal fade" id="editRestauranteModal" tabindex="-1" aria-labelledby="editRestauranteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRestauranteModalLabel">Editar Restaurante</h5>
                <a href="restaurantes.php" class="btn-close" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <form method="POST" action="restaurantes.php">
                    <input type="hidden" name="id" value="<?= $editRestaurante['id'] ?>">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($editRestaurante['nombre']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="<?= htmlspecialchars($editRestaurante['direccion']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" value="<?= htmlspecialchars($editRestaurante['telefono']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_cocina" class="form-label">Tipo de Cocina</label>
                        <input type="text" name="tipo_cocina" id="tipo_cocina" class="form-control" value="<?= htmlspecialchars($editRestaurante['tipo_cocina']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="horario_apertura" class="form-label">Horario de Apertura</label>
                        <input type="time" name="horario_apertura" id="horario_apertura" class="form-control" value="<?= $editRestaurante['horario_apertura'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="horario_cierre" class="form-label">Horario de Cierre</label>
                        <input type="time" name="horario_cierre" id="horario_cierre" class="form-control" value="<?= $editRestaurante['horario_cierre'] ?>" required>
                    </div>
                    <button type="submit" name="edit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <?php endif; ?>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php if ($editRestaurante): ?>
            // Muestra el modal de edición al cargar la página
            var editModal = new bootstrap.Modal(document.getElementById('editRestauranteModal'), {});
            editModal.show();
        <?php endif; ?>
    });
</script>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>