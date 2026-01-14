<?php
/**
 * Modelo de Cliente
 * Client Model
 */
class Cliente {
    private $conn;
    private $table_name = "clientes";

    public $id_cliente;
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;
    public $direccion;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear nuevo cliente (Create)
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (nombre, apellido, telefono, email, direccion) 
                  VALUES (:nombre, :apellido, :telefono, :email, :direccion)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":direccion", $this->direccion);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Leer todos los clientes (Read All)
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY apellido, nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Leer un cliente específico (Read One)
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_cliente = :id_cliente LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_cliente", $this->id_cliente);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->nombre = $row['nombre'];
            $this->apellido = $row['apellido'];
            $this->telefono = $row['telefono'];
            $this->email = $row['email'];
            $this->direccion = $row['direccion'];
            return true;
        }
        return false;
    }

    // Actualizar cliente (Update)
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre = :nombre, 
                      apellido = :apellido, 
                      telefono = :telefono, 
                      email = :email, 
                      direccion = :direccion 
                  WHERE id_cliente = :id_cliente";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":direccion", $this->direccion);
        $stmt->bindParam(":id_cliente", $this->id_cliente);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar cliente (Delete)
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_cliente = :id_cliente";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_cliente", $this->id_cliente);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
