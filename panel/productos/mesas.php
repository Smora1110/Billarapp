

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

        // Consulta para obtener la lista de mesas
        $consulta_mesas = "SELECT id, nombre_usuario FROM usuarios WHERE nombre_usuario LIKE 'mesa%'";
        $resultado_mesas = $conexion->query($consulta_mesas);

        // Mostrar la lista de mesas
        while ($fila_mesa = $resultado_mesas->fetch_assoc()) {
            echo "<li><a href='pedidos.php?mesa_id={$fila_mesa['id']}'>{$fila_mesa['nombre_usuario']}</a></li>";
        }

        // Cerrar la conexión
        $conexion->close();
        ?>
    </ul>
    
</body>
</html>