<?php
/**
 * Clase de conexión a la base de datos
 * Database connection class
 */
class Database {
    private $host = "localhost";
    private $db_name = "veterinaria_db";
    private $username = "root";
    private $password = "";
    private $conn;

    /**
     * Obtener conexión a la base de datos
     * Get database connection
     */
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
