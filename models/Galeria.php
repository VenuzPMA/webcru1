<?php
class Galeria {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todas las fotos
    public function getFotos() {
        $stmt = $this->db->query("SELECT * FROM galeria");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Agregar una foto
    public function addFoto($titulo, $ruta) {
        $stmt = $this->db->prepare("INSERT INTO galeria (titulo, ruta) VALUES (:titulo, :ruta)");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':ruta', $ruta);
        $stmt->execute();
    }

    // Eliminar una foto
    public function deleteFoto($id) {
        $stmt = $this->db->prepare("DELETE FROM galeria WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }


    
}
