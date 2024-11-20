<?php
require_once '../models/Restaurante.php';

class RestaurantesController {
    private $model;

    public function __construct($db) {
        // Instancia del modelo Restaurante
        $this->model = new Restaurante($db);
    }

    // Mostrar todos los restaurantes
    public function index() {
        return $this->model->getRestaurantes();
    }

    // Agregar un nuevo restaurante
    public function create($nombre, $direccion, $telefono, $tipo_cocina, $horario_apertura, $horario_cierre) {
        $this->model->addRestaurante($nombre, $direccion, $telefono, $tipo_cocina, $horario_apertura, $horario_cierre);
    }

    // Obtener datos de un restaurante por su ID
    public function edit($id) {
        return $this->model->getRestauranteById($id);
    }

    // Actualizar un restaurante existente
    public function update($id, $nombre, $direccion, $telefono, $tipo_cocina, $horario_apertura, $horario_cierre) {
        $this->model->updateRestaurante($id, $nombre, $direccion, $telefono, $tipo_cocina, $horario_apertura, $horario_cierre);
    }

    // Eliminar un restaurante por su ID
    public function delete($id) {
        $this->model->deleteRestaurante($id);
    }

    // Alternar el estado de "Visitado" de un restaurante
    public function toggleVisitado($id, $visitado) {
        return $this->model->toggleVisitado($id, $visitado);
    }
}
?>
