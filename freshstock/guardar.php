<?php
require_once "config/database.php";

$sql = "INSERT INTO productos 
(nombre, stock, stock_min, precio_compra, precio_venta, fecha_vencimiento)
VALUES (
'{$_POST['nombre']}',
'{$_POST['stock']}',
'{$_POST['stock_min']}',
'{$_POST['pc']}',
'{$_POST['pv']}',
'{$_POST['fecha']}'
)";

$conn->query($sql);

header("Location: index.php");