<?php
class Database{
    private $host     = 'localhost';
    private $user     = 'root';      
    private $password = '';           
    private $database = 'poketcg';
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    
}
?>