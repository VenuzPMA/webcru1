<?php
require_once '../includes/db.php';
require_once '../controllers/galeriaController.php';

$galeriaController = new GaleriaController($db);

// Verificar existencia de directorio 'uploads' y crearlo si no existe
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

// Subir foto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['subir'])) {
    $titulo = $_POST['titulo'];
    $ruta = 'uploads/' . basename($_FILES['foto']['name']);
    
    // Verificar si la foto se subió correctamente
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta)) {
        $galeriaController->addFoto($titulo, $ruta);
        header("Location: galeria.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error al subir la foto. Por favor, inténtalo de nuevo.</div>";
    }
}

// Eliminar foto
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $galeriaController->deleteFoto($id);
    header("Location: galeria.php");
    exit();
}

// Configuración de la paginación
$porPagina = 6;  // Número de imágenes por página
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaActual - 1) * $porPagina;

// Obtener fotos desde la base de datos con paginación
$fotos = $galeriaController->getFotosPaginadas($offset, $porPagina);
$totalFotos = $galeriaController->getTotalFotos();
$totalPaginas = ceil($totalFotos / $porPagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Fotos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Aseguramos que el body ocupe toda la altura de la pantalla */
        body {
            display: flex;
            height: 100vh;
            margin: 0;
        }

        /* Permite desplazamiento dentro del menú sin cambiar su tamaño */
#menu {
    overflow-y: auto;  /* Si el contenido es largo, se desplaza */
}


        /* Espacio necesario para el contenido */
        #content {

    padding: 20px;
    flex-grow: 1;
    overflow-y: auto;
}

        /* Estilo adicional para las tarjetas de la galería */
        .gallery-card img {
    width: 100%; /* Asegura que la imagen se ajuste al contenedor */
    height: auto; /* Mantiene la proporción de la imagen */
    object-fit: cover; /* O 'contain' dependiendo del efecto visual que desees */
}


        .gallery-card {
            margin-bottom: 20px;
        }

        .form-container {
            margin-bottom: 30px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <!-- Menú incluido desde menu.php -->
    <?php include '../includes/menu.php'; ?>

    <!-- Contenido principal -->
    <div id="content" class="container">
        <h2 class="my-4">Galería de Fotos</h2>
        
        <!-- Botón para agregar una foto -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addFotoModal">Agregar Foto</button>

        <!-- Galería -->
        <div class="row">
            <?php foreach ($fotos as $foto): ?>
                <div class="col-md-4 gallery-card">
                    <div class="card">
                        <img src="<?= htmlspecialchars($foto['ruta']) ?>" class="card-img-top" alt="<?= htmlspecialchars($foto['titulo']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($foto['titulo']) ?></h5>
                            <a href="galeria.php?delete=<?= $foto['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Paginación -->
        <div class="pagination">
            <ul class="pagination">
                <li class="page-item <?= $paginaActual <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="galeria.php?pagina=<?= $paginaActual - 1 ?>">Anterior</a>
                </li>
                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="page-item <?= $i == $paginaActual ? 'active' : '' ?>">
                        <a class="page-link" href="galeria.php?pagina=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= $paginaActual >= $totalPaginas ? 'disabled' : '' ?>">
                    <a class="page-link" href="galeria.php?pagina=<?= $paginaActual + 1 ?>">Siguiente</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Modal para agregar foto -->
    <div class="modal fade" id="addFotoModal" tabindex="-1" aria-labelledby="addFotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFotoModalLabel">Agregar Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
                        </div>
                        <button type="submit" name="subir" class="btn btn-primary">Subir Foto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
