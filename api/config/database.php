<?php
class Database
{
    private $host = "localhost";
    private $db_name = "u241141_Herbivore";
    private $username = "u241141_Herbivore";
    private $password = "SKu9Rn2feVQkVY6NjcF7";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>