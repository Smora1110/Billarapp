

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
<ul>
    <?php
    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "tiendabillar");

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta para obtener la lista de mesas y sus pedidos
    $consulta_mesas_pedidos = "SELECT usuarios.id AS mesa_id, usuarios.nombre_usuario AS mesa_nombre, pedidos.id AS pedido_id
                               FROM usuarios
                               JOIN clientes ON usuarios.nombre_usuario = clientes.mesa
                               JOIN pedidos ON clientes.id = pedidos.cliente_id";
    
    $resultado_mesas_pedidos = $conexion->query($consulta_mesas_pedidos);

    // Mostrar la lista de mesas y sus pedidos
    while ($fila_mesa_pedido = $resultado_mesas_pedidos->fetch_assoc()) {
        echo "<li><a href='pedidos.php?mesa_id={$fila_mesa_pedido['mesa_id']}'>{$fila_mesa_pedido['mesa_nombre']}</a></li>";
        
        // Si hay pedidos para esta mesa, mostrarlos
        if ($fila_mesa_pedido['pedido_id']) {
            echo "<ul>";
            // Consulta para obtener los detalles del pedido
            $consulta_detalles_pedido = "SELECT * FROM detalle_pedidos WHERE pedido_id = {$fila_mesa_pedido['pedido_id']}";
            $resultado_detalles_pedido = $conexion->query($consulta_detalles_pedido);
            while ($fila_detalle_pedido = $resultado_detalles_pedido->fetch_assoc()) {
                echo "<li>{$fila_detalle_pedido['id']} - Producto: {$fila_detalle_pedido['producto_id']}, Precio: {$fila_detalle_pedido['precio']}, Cantidad: {$fila_detalle_pedido['cantidad']}</li>";
            }
            echo "</ul>";
        }
    }

    // Cerrar la conexión
    $conexion->close();
    ?>
</ul>
</html>