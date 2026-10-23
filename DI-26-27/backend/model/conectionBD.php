<?php

class Conection {
    private string $host    = 'localhost';
    private string $db      = 'universidad';
    private string $user    = 'root';
    private string $pass    = '1234';
    private string $charset = 'utf8mb4';

    // Instancia única de la clase (Singleton)
    private static ?Conection $instance = null;
    
    // Instancia de PDO
    private ?PDO $pdo = null;

    // Constructor privado para evitar la instanciación directa con 'new'
    private function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            // Pasa a minúsculas los nombres de las columnas que devuelve la BD
            // (en la tabla están en mayúsculas: DNI, NOMBRE...), para poder usar
            // $datos['nombre'] en PHP y data.data.nombre en JS
            PDO::ATTR_CASE               => PDO::CASE_LOWER,
            // Hace que rowCount() en un UPDATE cuente las filas encontradas
            // (aunque los datos no cambien), no solo las modificadas
            PDO::MYSQL_ATTR_FOUND_ROWS   => true,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['success' => false, 'msg' => 'Error de conexión: ' . $e->getMessage()]);
            exit;
        }
    }

    // Método estático para obtener la instancia única
    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Método para obtener el objeto PDO y hacer consultas
    public function getPDO(): PDO {
        return $this->pdo;
    }

    // Evitar que la instancia sea clonada
    private function __clone() {}

    // Evitar que la instancia sea deserializada
    public function __wakeup() {
        throw new \Exception("No se permite deserializar esta clase.");
    }
}