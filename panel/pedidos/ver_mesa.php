<?php
session_start();
if (!isset($_SESSION['usuario_info']) or empty($_SESSION['usuario_info'])) {
    header('Location: ../../index.php');
    exit; // Asegúrate de salir después de redirigir
}

$estado = $_SESSION['estado'];

print_r($estado);
if ($estado == 0) {
    header('Location: ../tienda.php');
    exit; // Asegúrate de salir después de redirigir
}
?>

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
                        <a href="" class="btn">Mesas</a>
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
    <div class="container" id="main">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>

                            <th>Total</th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        require '../../vendor/autoload.php';
                        $nombre_usuario = isset($_GET['id']) ? $_GET['id'] : null;




                        $pedido = new billar\Pedido;
                        $info_pedido = $pedido->mostrarPorMesa($nombre_usuario);


                        $cantidad = count($info_pedido);
                        if ($cantidad > 0) {
                            $c = 0;
                            for ($x = 0; $x < $cantidad; $x++) {
                                $c++;
                                $item = $info_pedido[$x];


                                print '<tr>';
                                print '<td>' . $c . '</td>';
                                print '<td>' . $item['nombre'] . '</td>';

                                print '<td>' . $item['total'] . '</td>';

                                print '</tr>';
                            }
                        } else {
                            print '<tr>';
                            print '<td colspan="6">NO HAY REGISTROS</td>';
                            print '</tr>';
                        }
                        ?>





                        <form action="../../src/actualizar_tiempo.php" method="post">
                            <input type="hidden" name="nombre_usuario" value="<?php echo $nombre_usuario; ?>">
                            <button type="submit" name="accion" value="iniciar" class="btn btn-danger btn-sm btn-iniciar"><span>inicio</span></button>
                            <button type="submit" name="accion" value="detener" class="btn btn-danger btn-sm btn-detener"><span>detener</span></button>
                            <button type="submit" name="accion" value="reinicio" class="btn btn-danger btn-sm btn-reinicio"><span>reinicio</span></button>
                        </form>



                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>
</body>

</html>