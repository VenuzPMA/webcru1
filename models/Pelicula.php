<?php
class Pelicula {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todas las películas
    public function getPeliculas() {
        $stmt = $this->db->query("SELECT * FROM peliculas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una película por ID
    public function getPeliculaById($id) {
        $stmt = $this->db->prepare("SELECT * FROM peliculas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Agregar una nueva película
    public function addPelicula($titulo, $genero, $duracion, $director, $anio) {
        $stmt = $this->db->prepare("INSERT INTO peliculas (titulo, genero, duracion, director, anio) VALUES (:titulo, :genero, :duracion, :director, :anio)");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':duracion', $duracion);
        $stmt->bindParam(':director', $director);
        $stmt->bindParam(':anio', $anio);
        $stmt->execute();
    }

    // Actualizar una película
    public function updatePelicula($id, $titulo, $genero, $duracion, $director, $anio) {
        $stmt = $this->db->prepare("UPDATE peliculas SET titulo = :titulo, genero = :genero, duracion = :duracion, director = :director, anio = :anio WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':duracion', $duracion);
        $stmt->bindParam(':director', $director);
        $stmt->bindParam(':anio', $anio);
        $stmt->execute();
    }

    // Eliminar una película
    public function deletePelicula($id) {
        $stmt = $this->db->prepare("DELETE FROM peliculas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
?>
