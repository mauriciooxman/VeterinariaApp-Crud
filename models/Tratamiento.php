<?php
/**
 * Modelo de Tratamiento
 * Treatment Model
 */
class Tratamiento {
    private $conn;
    private $table_name = "tratamientos";

    public $id_tratamiento;
    public $id_cita;
    public $descripcion;
    public $medicamentos;
    public $costo;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear nuevo tratamiento (Create)
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (id_cita, descripcion, medicamentos, costo) 
                  VALUES (:id_cita, :descripcion, :medicamentos, :costo)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_cita", $this->id_cita);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":medicamentos", $this->medicamentos);
        $stmt->bindParam(":costo", $this->costo);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Leer todos los tratamientos con información relacionada (Read All)
    public function readAll() {
        $query = "SELECT t.*, 
                         c.fecha_cita, c.motivo,
                         m.nombre as mascota_nombre,
                         v.nombre as vet_nombre, v.apellido as vet_apellido
                  FROM " . $this->table_name . " t
                  LEFT JOIN citas c ON t.id_cita = c.id_cita
                  LEFT JOIN mascotas m ON c.id_mascota = m.id_mascota
                  LEFT JOIN veterinarios v ON c.id_veterinario = v.id_veterinario
                  ORDER BY t.fecha_tratamiento DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Leer un tratamiento específico (Read One)
    public function readOne() {
        $query = "SELECT t.*, 
                         c.fecha_cita, c.motivo,
                         m.nombre as mascota_nombre
                  FROM " . $this->table_name . " t
                  LEFT JOIN citas c ON t.id_cita = c.id_cita
                  LEFT JOIN mascotas m ON c.id_mascota = m.id_mascota
                  WHERE t.id_tratamiento = :id_tratamiento LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_tratamiento", $this->id_tratamiento);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->id_cita = $row['id_cita'];
            $this->descripcion = $row['descripcion'];
            $this->medicamentos = $row['medicamentos'];
            $this->costo = $row['costo'];
            return true;
        }
        return false;
    }

    // Actualizar tratamiento (Update)
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET id_cita = :id_cita, 
                      descripcion = :descripcion, 
                      medicamentos = :medicamentos, 
                      costo = :costo 
                  WHERE id_tratamiento = :id_tratamiento";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_cita", $this->id_cita);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":medicamentos", $this->medicamentos);
        $stmt->bindParam(":costo", $this->costo);
        $stmt->bindParam(":id_tratamiento", $this->id_tratamiento);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar tratamiento (Delete)
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_tratamiento = :id_tratamiento";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_tratamiento", $this->id_tratamiento);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
