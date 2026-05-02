<?php
require_once __DIR__ . "/../models/Producto.php";

class ProductoController {

    public static function listar() {
        return Producto::listar();
    }
}