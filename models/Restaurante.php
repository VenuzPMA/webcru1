<?php
class Restaurante {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todos los restaurantes
    public function getRestaurantes() {
        $stmt = $this->db->query("SELECT * FROM restaurantes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un restaurante por ID
    public function getRestauranteById($id) {
        $stmt = $this->db->prepare("SELECT * FROM restaurantes WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Agregar un nuevo restaurante
    public function addRestaurante($nombre, $direccion, $telefono, $tipo_cocina, $horario_apertura, $horario_cierre) {
        $stmt = $this->db->prepare("INSERT INTO restaurantes (nombre, direccion, telefono, tipo_cocina, horario_apertura, horario_cierre) VALUES (:nombre, :direccion, :telefono, :tipo_cocina, :horario_apertura, :horario_cierre)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':tipo_cocina', $tipo_cocina);
        $stmt->bindParam(':horario_apertura', $horario_apertura);
        $stmt->bindParam(':horario_cierre', $horario_cierre);
        $stmt->execute();
    }

    // Actualizar un restaurante
    public function updateRestaurante($id, $nombre, $direccion, $telefono, $tipo_cocina, $horario_apertura, $horario_cierre) {
        $stmt = $this->db->prepare("UPDATE restaurantes SET nombre = :nombre, direccion = :direccion, telefono = :telefono, tipo_cocina = :tipo_cocina, horario_apertura = :horario_apertura, horario_cierre = :horario_cierre WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':tipo_cocina', $tipo_cocina);
        $stmt->bindParam(':horario_apertura', $horario_apertura);
        $stmt->bindParam(':horario_cierre', $horario_cierre);
        $stmt->execute();
    }

    // Eliminar un restaurante
    public function deleteRestaurante($id) {
        $stmt = $this->db->prepare("DELETE FROM restaurantes WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function toggleVisitado($id, $visitado) {
        $sql = "UPDATE restaurantes SET visitado = :visitado WHERE id = :id";
        $stmt = $this->db->prepare($sql);
    
        // Depurar la consulta y parámetros antes de la ejecución
        if ($stmt === false) {
            throw new Exception("Error al preparar la consulta.");
        }
    
        // Verifica si los parámetros se están vinculando correctamente
        if (!$stmt->bindParam(':visitado', $visitado, PDO::PARAM_INT)) {
            throw new Exception("Error al vincular el parámetro :visitado.");
        }
    
        if (!$stmt->bindParam(':id', $id, PDO::PARAM_INT)) {
            throw new Exception("Error al vincular el parámetro :id.");
        }
    
        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;  // Si la actualización es exitosa
        } else {
            throw new Exception("Error al ejecutar la consulta SQL");
        }
    }
    
    


}
?>
