<?php
class Database {
    private $host = "localhost";
    private $db_name = "allowance_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function connect(){
        $this->conn = null;
        try{
            $this->conn = new PDO(
                "mysql:host=".$this->host.";dbname=".$this->db_name,
                $this->username,
                $this->password,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            die("Connection error: " . $e->getMessage());
        }
        return $this->conn;
    }
}
