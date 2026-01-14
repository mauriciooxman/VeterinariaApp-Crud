<?php
/**
 * Modelo de Veterinario
 * Veterinarian Model
 */
class Veterinario {
    private $conn;
    private $table_name = "veterinarios";

    public $id_veterinario;
    public $nombre;
    public $apellido;
    public $especialidad;
    public $telefono;
    public $email;
    public $fecha_contratacion;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear nuevo veterinario (Create)
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (nombre, apellido, especialidad, telefono, email, fecha_contratacion) 
                  VALUES (:nombre, :apellido, :especialidad, :telefono, :email, :fecha_contratacion)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":especialidad", $this->especialidad);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":fecha_contratacion", $this->fecha_contratacion);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Leer todos los veterinarios (Read All)
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY apellido, nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Leer un veterinario específico (Read One)
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_veterinario = :id_veterinario LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_veterinario", $this->id_veterinario);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->nombre = $row['nombre'];
            $this->apellido = $row['apellido'];
            $this->especialidad = $row['especialidad'];
            $this->telefono = $row['telefono'];
            $this->email = $row['email'];
            $this->fecha_contratacion = $row['fecha_contratacion'];
            return true;
        }
        return false;
    }

    // Actualizar veterinario (Update)
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre = :nombre, 
                      apellido = :apellido, 
                      especialidad = :especialidad, 
                      telefono = :telefono, 
                      email = :email, 
                      fecha_contratacion = :fecha_contratacion 
                  WHERE id_veterinario = :id_veterinario";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":especialidad", $this->especialidad);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":fecha_contratacion", $this->fecha_contratacion);
        $stmt->bindParam(":id_veterinario", $this->id_veterinario);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar veterinario (Delete)
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_veterinario = :id_veterinario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_veterinario", $this->id_veterinario);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
