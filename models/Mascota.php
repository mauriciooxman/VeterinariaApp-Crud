<?php
/**
 * Modelo de Mascota
 * Pet Model
 */
class Mascota {
    private $conn;
    private $table_name = "mascotas";

    public $id_mascota;
    public $nombre;
    public $especie;
    public $raza;
    public $edad;
    public $peso;
    public $id_cliente;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear nueva mascota (Create)
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (nombre, especie, raza, edad, peso, id_cliente) 
                  VALUES (:nombre, :especie, :raza, :edad, :peso, :id_cliente)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":especie", $this->especie);
        $stmt->bindParam(":raza", $this->raza);
        $stmt->bindParam(":edad", $this->edad);
        $stmt->bindParam(":peso", $this->peso);
        $stmt->bindParam(":id_cliente", $this->id_cliente);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Leer todas las mascotas con información del cliente (Read All)
    public function readAll() {
        $query = "SELECT m.*, c.nombre as cliente_nombre, c.apellido as cliente_apellido 
                  FROM " . $this->table_name . " m
                  LEFT JOIN clientes c ON m.id_cliente = c.id_cliente
                  ORDER BY m.nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Leer una mascota específica (Read One)
    public function readOne() {
        $query = "SELECT m.*, c.nombre as cliente_nombre, c.apellido as cliente_apellido 
                  FROM " . $this->table_name . " m
                  LEFT JOIN clientes c ON m.id_cliente = c.id_cliente
                  WHERE m.id_mascota = :id_mascota LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_mascota", $this->id_mascota);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->nombre = $row['nombre'];
            $this->especie = $row['especie'];
            $this->raza = $row['raza'];
            $this->edad = $row['edad'];
            $this->peso = $row['peso'];
            $this->id_cliente = $row['id_cliente'];
            return true;
        }
        return false;
    }

    // Actualizar mascota (Update)
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre = :nombre, 
                      especie = :especie, 
                      raza = :raza, 
                      edad = :edad, 
                      peso = :peso, 
                      id_cliente = :id_cliente 
                  WHERE id_mascota = :id_mascota";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":especie", $this->especie);
        $stmt->bindParam(":raza", $this->raza);
        $stmt->bindParam(":edad", $this->edad);
        $stmt->bindParam(":peso", $this->peso);
        $stmt->bindParam(":id_cliente", $this->id_cliente);
        $stmt->bindParam(":id_mascota", $this->id_mascota);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar mascota (Delete)
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_mascota = :id_mascota";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_mascota", $this->id_mascota);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
