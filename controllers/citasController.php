<?php
require_once '../models/Cita.php';

class CitasController {
    private $cita;

    public function __construct($db) {
        $this->cita = new Cita($db);  // Pasar la conexión al modelo
    }

    // Obtener todas las citas
    public function index() {
        return $this->cita->getCitas();  // Devuelve las citas
    }

    // Crear una nueva cita
    public function create($fecha, $hora, $descripcion) {
        $this->cita->addCita($fecha, $hora, $descripcion);
    }

    // Obtener una cita específica para editar
public function edit($id) {
    return $this->cita->getCitaById($id);  // Esta función obtiene la cita por ID
}

    // Actualizar una cita
    public function update($id, $fecha, $hora, $descripcion) {
        $this->cita->updateCita($id, $fecha, $hora, $descripcion);
    }

    // Eliminar una cita
    public function delete($id) {
        $this->cita->deleteCita($id);
    }
}
?>
