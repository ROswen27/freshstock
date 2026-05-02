<?php
require_once __DIR__ . "/config/database.php";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=productos.csv');

$output = fopen('php://output', 'w');

// Encabezados
fputcsv($output, ['ID','Nombre','Stock','Stock Min','Compra','Venta','Vencimiento']);

// Consulta
$result = $conn->query("SELECT * FROM productos");

// Datos
while($row = $result->fetch_assoc()){
    fputcsv($output, [
        $row['id'],
        $row['nombre'],
        $row['stock'],
        $row['stock_min'],
        $row['precio_compra'],
        $row['precio_venta'],
        $row['fecha_vencimiento']
    ]);
}

fclose($output);
exit;