<?php
require_once __DIR__ . "/controllers/ProductoController.php";
$productos = ProductoController::listar();

$lista = [];
$total = 0;
$bajo = 0;
$vencidos = 0;
$ganancia = 0;

$hoy = date("Y-m-d");

while($p = $productos->fetch_assoc()){
    $lista[] = $p;
    $total++;

    if ($p['stock'] <= $p['stock_min']) $bajo++;
    if ($p['fecha_vencimiento'] < $hoy) $vencidos++;

    $ganancia += ($p['precio_venta'] - $p['precio_compra']) * $p['stock'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>FreshStock</title>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #0f172a, #1e293b);
    margin: 0;
    color: #f1f5f9;
}

.container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
}

h1 {
    text-align: center;
    color: #f8fafc;
}

/* FORMULARIO */
.form-box {
    background: #1e293b;
    padding: 20px;
    border-radius: 12px;
    border-left: 6px solid #22c55e;
    box-shadow: 0 10px 25px rgba(0,0,0,0.4);
    margin-bottom: 20px;
}

.form-box input {
    padding: 10px;
    margin: 5px;
    border: none;
    border-radius: 6px;
    background: #0f172a;
    color: white;
}

.form-box button {
    background: #22c55e;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 6px;
    cursor: pointer;
}

.form-box button:hover {
    background: #16a34a;
}

/* KPI CARDS */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.card {
    padding: 20px;
    border-radius: 12px;
    color: white;
    font-weight: bold;
    text-align: center;
    box-shadow: 0 10px 20px rgba(0,0,0,0.4);
}

/* COLORES INTENSOS */
.total {
    background: linear-gradient(45deg, #3b82f6, #60a5fa);
}

.bajo {
    background: linear-gradient(45deg, #f59e0b, #fbbf24);
}

.vencido {
    background: linear-gradient(45deg, #ef4444, #f87171);
}

.ganancia {
    background: linear-gradient(45deg, #22c55e, #4ade80);
}

/* BOTÓN CSV */
.btn {
    background: #06b6d4;
    color: white;
    padding: 10px 15px;
    border-radius: 8px;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 15px;
    font-weight: bold;
}

.btn:hover {
    background: #0891b2;
}

/* TABLA */
table {
    width: 100%;
    border-collapse: collapse;
    background: #1e293b;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
}

th {
    background: #0f172a;
    color: #38bdf8;
    text-transform: uppercase;
    font-size: 13px;
}

th, td {
    padding: 12px;
    text-align: center;
}

tr:nth-child(even) {
    background: #334155;
}

/* ESTADOS */
.estado-ok {
    color: #22c55e;
    font-weight: bold;
}

.estado-bajo {
    color: #fbbf24;
    font-weight: bold;
}

.estado-vencido {
    color: #ef4444;
    font-weight: bold;
}

/* HOVER */
tr:hover {
    background: #475569;
}
</style>
</head>

<body>
<div class="container">

<h1>📦 FreshStock Dashboard</h1>

<!-- 🔥 FORMULARIO -->
<div class="form-box">
    <h3>➕ Agregar Producto</h3>
    <form method="POST" action="guardar.php">
        <input name="nombre" placeholder="Nombre" required>
        <input name="stock" type="number" placeholder="Stock" required>
        <input name="stock_min" type="number" placeholder="Stock Min" required>
        <input name="pc" type="number" step="0.01" placeholder="Precio Compra" required>
        <input name="pv" type="number" step="0.01" placeholder="Precio Venta" required>
        <input name="fecha" type="date" required>

        <button type="submit">Guardar</button>
    </form>
</div>

<!-- KPI -->
<div class="cards">
    <div class="card total">Total<br><?= $total ?></div>
    <div class="card bajo">Bajo stock<br><?= $bajo ?></div>
    <div class="card vencido">Vencidos<br><?= $vencidos ?></div>
    <div class="card ganancia">Ganancia<br>S/ <?= number_format($ganancia,2) ?></div>
</div>

<a class="btn" href="exportar.php">⬇ Descargar CSV</a>

<br><br>

<table>
<tr>
<th>Nombre</th>
<th>Stock</th>
<th>Precio</th>
<th>Vencimiento</th>
<th>Estado</th>
</tr>

<?php foreach($lista as $p):

$estado = "OK";
$class = "estado-ok";

if ($p['fecha_vencimiento'] < $hoy){
    $estado = "VENCIDO";
    $class = "estado-vencido";
}
elseif ($p['stock'] <= $p['stock_min']){
    $estado = "BAJO STOCK";
    $class = "estado-bajo";
}
?>

<tr>
<td><?= $p['nombre'] ?></td>
<td><?= $p['stock'] ?></td>
<td>S/ <?= $p['precio_venta'] ?></td>
<td><?= $p['fecha_vencimiento'] ?></td>
<td class="<?= $class ?>"><?= $estado ?></td>
</tr>

<?php endforeach; ?>

</table>

</div>
</body>
</html>