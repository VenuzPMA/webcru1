<?php
require_once '../models/Pelicula.php';

class PeliculasController {
    private $pelicula;

    public function __construct($db) {
        $this->pelicula = new Pelicula($db);
    }

    // Obtener todas las películas
    public function index() {
        return $this->pelicula->getPeliculas();
    }

    // Crear una nueva película
    public function create($titulo, $genero, $duracion, $director, $anio) {
        return $this->pelicula->addPelicula($titulo, $genero, $duracion, $director, $anio);
    }

    // Obtener una película por ID
    public function show($id) {
        return $this->pelicula->getPeliculaById($id);
    }

    // Editar una película
    public function edit($id) {
        return $this->pelicula->getPeliculaById($id);
    }

    // Actualizar una película
    public function update($id, $titulo, $genero, $duracion, $director, $anio) {
        return $this->pelicula->updatePelicula($id, $titulo, $genero, $duracion, $director, $anio);
    }

    // Eliminar una película
    public function delete($id) {
        return $this->pelicula->deletePelicula($id);
    }

   
}
?>
