<div id="sidebar" class="d-flex flex-column">
    <h4 class="text-center py-4">Menú</h4>
    <a href="dashboard.php" class="menu-item">
        <i class="fas fa-home"></i> Inicio
    </a>
    <a href="calendario.php" class="menu-item">
        <i class="fas fa-calendar-alt"></i> Calendario
    </a>
    <a href="ideas_citas.php" class="menu-item">
        <i class="fas fa-heart"></i> Ideas de Citas
    </a>
    <a href="restaurantes.php" class="menu-item">
        <i class="fas fa-utensils"></i> Restaurantes
    </a>
    <a href="peliculas.php" class="menu-item">
        <i class="fas fa-film"></i> Películas
    </a>
    <!-- Nueva opción de Galería -->
    <a href="galeria.php" class="menu-item">
        <i class="fas fa-images"></i> Galería
    </a>
    <a href="logout.php" class="menu-item mt-auto">
        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
    </a>
</div>


<style>
    /* Estilo general del menú */
    #sidebar {
        width: 250px;
        background-color: #2c3e50;
        color: #ecf0f1;
        height: 100vh;
        display: flex;
        flex-direction: column;
        padding-top: 20px;
    }

    /* Título del menú */
    #sidebar h4 {
        font-size: 1.5rem;
        font-weight: bold;
        color: #ecf0f1;
        border-bottom: 1px solid #34495e;
        margin-bottom: 20px;
    }

    /* Estilo de los enlaces */
    .menu-item {
        color: #ecf0f1;
        text-decoration: none;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .menu-item i {
        margin-right: 10px;
        font-size: 1.2rem;
    }

    .menu-item:hover {
        background-color: #34495e;
        color: #1abc9c;
        padding-left: 25px;
    }

    /* Último elemento (Cerrar sesión) */
    .mt-auto {
        margin-top: auto;
    }
</style>

<!-- FontAwesome para íconos -->
<!-- Encabezado HTML común -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">



