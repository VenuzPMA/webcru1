<?php 
require_once '../includes/db.php';  
require_once '../controllers/citasController.php';  

// Crear una instancia del controlador de citas
$citasController = new CitasController($db);

// Obtener todas las citas
$citas = $citasController->index();

// Agregar una nueva cita
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $descripcion = $_POST['descripcion'];
    $citasController->create($fecha, $hora, $descripcion);
    header("Location: ideas_citas.php?add=true");
    exit();
}

// Editar una cita existente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $descripcion = $_POST['descripcion'];
    $citasController->update($id, $fecha, $hora, $descripcion);
    header("Location: ideas_citas.php");
    exit();
}

// Eliminar una cita
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $citasController->delete($id);
    header("Location: ideas_citas.php");
    exit();
}

// Obtener los datos de una cita para editar
$editCita = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editCita = $citasController->edit($id);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ideas de Citas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Añadido para iconos -->
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
        .btn-icon {
            font-size: 1.2rem; /* Tamaño del icono */
            padding: 5px;
        }
    </style>
</head>
<body>
    
    <!-- Menú incluido desde menu.php -->
    <?php include '../includes/menu.php'; ?>

    <!-- Contenido principal -->
    <div id="content">
        <h2 class="my-4">Lista de Citas</h2>
        
        <!-- Botón para agregar una cita -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCitaModal">Agregar Cita</button>

        <!-- Tabla con citas -->
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($citas as $cita): ?>
                    <tr>
                        <td><?= $cita['id'] ?></td>
                        <td><?= $cita['fecha'] ?></td>
                        <td><?= $cita['hora'] ?></td>
                        <td><?= $cita['descripcion'] ?></td>
                        <td>
                            <!-- Iconos para editar y eliminar -->
                            <a href="ideas_citas.php?edit=<?= $cita['id'] ?>" class="btn btn-primary btn-icon"><i class="bi bi-pencil"></i></a>
                            <a href="ideas_citas.php?delete=<?= $cita['id'] ?>" class="btn btn-danger btn-icon"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar cita -->
    <div class="modal fade" id="addCitaModal" tabindex="-1" aria-labelledby="addCitaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCitaModalLabel">Agregar Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="ideas_citas.php">
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="form-label">Hora</label>
                            <input type="time" name="hora" id="hora" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
                        </div>
                        <button type="submit" name="add" class="btn btn-primary">Agregar Cita</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar cita -->
    <?php if ($editCita): ?>
    <div class="modal fade" id="editCitaModal" tabindex="-1" aria-labelledby="editCitaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCitaModalLabel">Editar Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="ideas_citas.php">
                        <input type="hidden" name="id" value="<?= $editCita['id'] ?>">
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" value="<?= $editCita['fecha'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="form-label">Hora</label>
                            <input type="time" name="hora" id="hora" class="form-control" value="<?= $editCita['hora'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" required><?= $editCita['descripcion'] ?></textarea>
                        </div>
                        <button type="submit" name="edit" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if (isset($_GET['add'])): ?>
                var addModal = new bootstrap.Modal(document.getElementById('addCitaModal'), {});
                addModal.hide();
            <?php endif; ?>
            
            <?php if ($editCita): ?>
                var editModal = new bootstrap.Modal(document.getElementById('editCitaModal'), {});
                editModal.show();
            <?php endif; ?>
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
