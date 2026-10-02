<?php

class Alumno {
    private $dni;
    private $nombre;
    private $apellido_1;
    private $localidad;

    // Si no le pasamos nada, se pondrán los valores en null.
    public function __construct($dni = null, $nombre = null, $apellido_1 = null, $localidad = null) {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellido_1 = $apellido_1;
        $this->localidad = $localidad;
    }

    // Método para insertar este alumno en la BD
    public function insertar($pdo) {
        try {
            $sql = "INSERT INTO alumno (dni, nombre, apellido_1, localidad) 
                    VALUES (:dni, :nombre, :apellido_1, :localidad)";

            $stmt = $pdo->prepare($sql);

            return $stmt->execute([
                ':dni'        => $this->dni,
                ':nombre'     => $this->nombre,
                ':apellido_1' => $this->apellido_1,
                ':localidad' => $this->localidad
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function obtener($pdo) {
        try {
            $sql = "SELECT * FROM alumno WHERE dni = :dni";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([':dni' => $this->dni]);

            // Extraemos el resultado como un array asociativo
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($datos) {
                // Actualizamos las propiedades de la clase
                $this->nombre = $datos['nombre'];
                $this->apellido_1 = $datos['apellido_1'];
                $this->localidad = $datos['localidad'];
                return $datos; // Devuelve los datos encontrados
            }

            return false; // No se encontró ningún alumno con ese DNI
        } catch (PDOException $e) {
            return false;
        }
    }

    public function eliminar($pdo) {
        try {
            $sql = "SELECT * FROM alumno WHERE dni = :dni";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':dni' => $this->dni]);

            
        }
    }
}