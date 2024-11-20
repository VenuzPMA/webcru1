<?php 
require_once '../includes/db.php';  
require_once '../controllers/peliculasController.php';  

// Crear una instancia del controlador de películas
$peliculasController = new PeliculasController($db);

// Obtener todas las películas
$peliculas = $peliculasController->index();

// Agregar una nueva película
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $duracion = $_POST['duracion'];
    $director = $_POST['director'];
    $anio = $_POST['anio'];
    $peliculasController->create($titulo, $genero, $duracion, $director, $anio);
    header("Location: peliculas.php?add=true");
    exit();
}

// Editar una película existente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $duracion = $_POST['duracion'];
    $director = $_POST['director'];
    $anio = $_POST['anio'];
    $peliculasController->update($id, $titulo, $genero, $duracion, $director, $anio);
    header("Location: peliculas.php");
    exit();
}

// Eliminar una película
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $peliculasController->delete($id);
    header("Location: peliculas.php");
    exit();
}

// Obtener los datos de una película para editar
$editPelicula = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editPelicula = $peliculasController->edit($id);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Películas</title>
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

    <!-- Contenido principal -->
    <div id="content">
        <h2 class="my-4">Lista de Películas</h2>
        
        <!-- Botón para agregar una película -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addPeliculaModal">Agregar Película</button>

        <!-- Tabla con películas -->
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Género</th>
                    <th>Duración</th>
                    <th>Director</th>
                    <th>Año</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($peliculas as $pelicula): ?>
                    <tr>
                        <td><?= $pelicula['id'] ?></td>
                        <td><?= $pelicula['titulo'] ?></td>
                        <td><?= $pelicula['genero'] ?></td>
                        <td><?= $pelicula['duracion'] ?></td>
                        <td><?= $pelicula['director'] ?></td>
                        <td><?= $pelicula['anio'] ?></td>
                        <td>
                            <a href="peliculas.php?edit=<?= $pelicula['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="peliculas.php?delete=<?= $pelicula['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar película -->
    <div class="modal fade" id="addPeliculaModal" tabindex="-1" aria-labelledby="addPeliculaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPeliculaModalLabel">Agregar Película</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="peliculas.php">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="genero" class="form-label">Género</label>
                            <input type="text" name="genero" id="genero" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="duracion" class="form-label">Duración</label>
                            <input type="number" name="duracion" id="duracion" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="director" class="form-label">Director</label>
                            <input type="text" name="director" id="director" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="anio" class="form-label">Año</label>
                            <input type="number" name="anio" id="anio" class="form-control" required>
                        </div>
                        <button type="submit" name="add" class="btn btn-primary">Agregar Película</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar película -->
    <?php if ($editPelicula): ?>
    <div class="modal fade" id="editPeliculaModal" tabindex="-1" aria-labelledby="editPeliculaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPeliculaModalLabel">Editar Película</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="peliculas.php">
                        <input type="hidden" name="id" value="<?= $editPelicula['id'] ?>">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" value="<?= $editPelicula['titulo'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="genero" class="form-label">Género</label>
                            <input type="text" name="genero" id="genero" class="form-control" value="<?= $editPelicula['genero'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="duracion" class="form-label">Duración</label>
                            <input type="text" name="duracion" id="duracion" class="form-control" value="<?= $editPelicula['duracion'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="director" class="form-label">Director</label>
                            <input type="text" name="director" id="director" class="form-control" value="<?= $editPelicula['director'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="anio" class="form-label">Año</label>
                            <input type="number" name="anio" id="anio" class="form-control" value="<?= $editPelicula['anio'] ?>" required>
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
                var addModal = new bootstrap.Modal(document.getElementById('addPeliculaModal'), {});
                addModal.hide();
            <?php endif; ?>
            
            <?php if ($editPelicula): ?>
                var editModal = new bootstrap.Modal(document.getElementById('editPeliculaModal'), {});
                editModal.show();
            <?php endif; ?>
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
