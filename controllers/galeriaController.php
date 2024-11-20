<?php
require_once '../models/Galeria.php';

class GaleriaController {
    private $db;
    private $galeria;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->db = $db;  // Almacena la conexión en la propiedad $db
        $this->galeria = new Galeria($db);  // Pasa la conexión también al modelo Galeria
    }

    // Obtener todas las fotos
    public function getFotos() {
        return $this->galeria->getFotos();
    }

    // Agregar una nueva foto
    public function addFoto($titulo, $ruta) {
        $this->galeria->addFoto($titulo, $ruta);
    }

    // Eliminar una foto
    public function deleteFoto($id) {
        $this->galeria->deleteFoto($id);
    }

    // Obtener fotos paginadas con PDO
    public function getFotosPaginadas($offset, $limit) {
        // Cambiar "fotos" por "galeria" y usar PDO
        $stmt = $this->db->prepare("SELECT * FROM galeria LIMIT :offset, :limit");

        // Enlazar los parámetros usando bindValue para PDO
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener los resultados y devolverlos
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener el total de fotos con PDO
    public function getTotalFotos() {
        // Cambiar "fotos" por "galeria" y usar PDO
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM galeria");

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total'];
    }
}
?>
