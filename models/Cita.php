<?php
/**
 * Modelo de Cita
 * Appointment Model
 */
class Cita {
    private $conn;
    private $table_name = "citas";

    public $id_cita;
    public $id_mascota;
    public $id_veterinario;
    public $fecha_cita;
    public $motivo;
    public $estado;
    public $observaciones;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear nueva cita (Create)
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (id_mascota, id_veterinario, fecha_cita, motivo, estado, observaciones) 
                  VALUES (:id_mascota, :id_veterinario, :fecha_cita, :motivo, :estado, :observaciones)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_mascota", $this->id_mascota);
        $stmt->bindParam(":id_veterinario", $this->id_veterinario);
        $stmt->bindParam(":fecha_cita", $this->fecha_cita);
        $stmt->bindParam(":motivo", $this->motivo);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":observaciones", $this->observaciones);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Leer todas las citas con información relacionada (Read All)
    public function readAll() {
        $query = "SELECT c.*, 
                         m.nombre as mascota_nombre, m.especie,
                         v.nombre as vet_nombre, v.apellido as vet_apellido,
                         cl.nombre as cliente_nombre, cl.apellido as cliente_apellido
                  FROM " . $this->table_name . " c
                  LEFT JOIN mascotas m ON c.id_mascota = m.id_mascota
                  LEFT JOIN veterinarios v ON c.id_veterinario = v.id_veterinario
                  LEFT JOIN clientes cl ON m.id_cliente = cl.id_cliente
                  ORDER BY c.fecha_cita DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Leer una cita específica (Read One)
    public function readOne() {
        $query = "SELECT c.*, 
                         m.nombre as mascota_nombre, m.especie,
                         v.nombre as vet_nombre, v.apellido as vet_apellido
                  FROM " . $this->table_name . " c
                  LEFT JOIN mascotas m ON c.id_mascota = m.id_mascota
                  LEFT JOIN veterinarios v ON c.id_veterinario = v.id_veterinario
                  WHERE c.id_cita = :id_cita LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_cita", $this->id_cita);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->id_mascota = $row['id_mascota'];
            $this->id_veterinario = $row['id_veterinario'];
            $this->fecha_cita = $row['fecha_cita'];
            $this->motivo = $row['motivo'];
            $this->estado = $row['estado'];
            $this->observaciones = $row['observaciones'];
            return true;
        }
        return false;
    }

    // Actualizar cita (Update)
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET id_mascota = :id_mascota, 
                      id_veterinario = :id_veterinario, 
                      fecha_cita = :fecha_cita, 
                      motivo = :motivo, 
                      estado = :estado, 
                      observaciones = :observaciones 
                  WHERE id_cita = :id_cita";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_mascota", $this->id_mascota);
        $stmt->bindParam(":id_veterinario", $this->id_veterinario);
        $stmt->bindParam(":fecha_cita", $this->fecha_cita);
        $stmt->bindParam(":motivo", $this->motivo);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":observaciones", $this->observaciones);
        $stmt->bindParam(":id_cita", $this->id_cita);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar cita (Delete)
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_cita = :id_cita";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_cita", $this->id_cita);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
