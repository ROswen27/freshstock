<?php
require_once __DIR__ . "/../config/database.php";

class Producto {

    public static function listar() {
        global $conn;
        return $conn->query("SELECT * FROM productos");
    }
}