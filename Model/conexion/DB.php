<?php
class DB{
    private $conn;

    public function __construct(){
        $this->conn = mysqli_connect('localhost', 'root', '', 'dbasesorias');
    }

    function getConexion(){
        return $this->conn;
    }
}