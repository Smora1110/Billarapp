

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BillarApp</title>

    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/estilos.css">
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../dashboard.php">BillarApp</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav pull-right">
                <li>
                    <a href="../pedidos/index.php" class="btn">Pedidos</a>
                </li>
                <li>
                    <a href="index.php" class="btn">Productos</a>
                </li>
                <li class="active">
                    <a href="productos/mesas.php" class="btn">Mesas</a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">admin <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../cerrar_session.php">Salir</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<h1>Listado de Mesas</h1>
<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "tiendabillar");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el ID de la mesa desde la URL
$mesa_id = $_GET['mesa'];

// Consulta para obtener el detalle del pedido para la mesa seleccionada
$consulta_detalle_pedido = "SELECT dp.id, p.titulo, dp.precio, dp.cantidad, dp.estado 
                           FROM detalle_pedidos dp
                           JOIN productos p ON dp.producto_id = p.id
                           JOIN pedidos pe ON dp.pedido_id = pe.id
                           JOIN clientes c ON pe.cliente_id = c.id
                           WHERE c.mesa = '$mesa'";
$resultado_detalle_pedido = $conexion->query($consulta_detalle_pedido);

// Mostrar la información del detalle del pedido
echo "<h1>Detalle del Pedido - Mesa $mesa_id</h1>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Estado</th></tr>";

while ($fila_detalle = $resultado_detalle_pedido->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$fila_detalle['id']}</td>";
    echo "<td>{$fila_detalle['titulo']}</td>";
    echo "<td>{$fila_detalle['precio']}</td>";
    echo "<td>{$fila_detalle['cantidad']}</td>";
    echo "<td>{$fila_detalle['estado']}</td>";
    echo "</tr>";
}

echo "</table>";

// Cerrar la conexión
$conexion->close();
?>
</html>