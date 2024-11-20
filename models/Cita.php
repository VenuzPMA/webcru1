<?php

class Cita {
    private $db;
    private $table = 'citas';

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todas las citas
    public function getCitas() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Devuelve un array de citas
    }

    // Obtener una cita por ID
    public function getCitaById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Devuelve la cita como un array
    }

    // Insertar una nueva cita
    public function addCita($fecha, $hora, $descripcion) {
        $query = "INSERT INTO " . $this->table . " (fecha, hora, descripcion) VALUES (:fecha, :hora, :descripcion)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':descripcion', $descripcion);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;  // Si ocurre un error, devuelve false
        }
    }

    // Actualizar una cita
    public function updateCita($id, $fecha, $hora, $descripcion) {
        $query = "UPDATE " . $this->table . " SET fecha = :fecha, hora = :hora, descripcion = :descripcion WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':descripcion', $descripcion);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;  // Si ocurre un error, devuelve false
        }
    }

    // Eliminar una cita
    public function deleteCita($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;  // Si ocurre un error, devuelve false
        }
    }
}
?>
