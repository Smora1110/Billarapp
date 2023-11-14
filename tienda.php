<?php
session_start();
session_start();
if (!isset($_SESSION['usuario_info']) or empty($_SESSION['usuario_info'])) {
  // Redirigir a la página de inicio de sesión
  header("Location: index.php");
  exit(); // Asegurar que el script se detenga después de la redirección
}
require 'funciones.php';
require 'vendor/autoload.php';

// Establece la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "tiendabillar";

try {
  $conexion = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Error en la conexión: " . $e->getMessage());
}

if (isset($_POST['filtro-categoria'])) {
  $categoria_filtrada = $_POST['filtro-categoria'];

  // Construye la consulta SQL para filtrar por categoría
  if ($categoria_filtrada !== 'todos') {
      $sql = "SELECT productos.id, productos.titulo, productos.foto, categorias.nombre 
              FROM productos 
              INNER JOIN categorias ON productos.categoria_id = categorias.id 
              WHERE categorias.nombre = :categoria";
      
      // Utiliza la categoría seleccionada en la consulta SQL
      $stmt = $conexion->prepare($sql);
      $stmt->bindParam(':categoria', $categoria_filtrada, PDO::PARAM_STR);
      $stmt->execute();
      $info_productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
      // Si la categoría es "todos", muestra todos los productos
      $sql = "SELECT productos.id, productos.titulo, productos.foto, categorias.nombre 
              FROM productos 
              INNER JOIN categorias ON productos.categoria_id = categorias.id";
      
      $stmt = $conexion->prepare($sql);
      $stmt->execute();
      $info_productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
} else {
  // Si no se ha seleccionado una categoría, muestra todos los productos
  $producto = new billar\producto;
  $info_productos = $producto->mostrar();
}

// Obtén la información de las categorías
$sql_categorias = "SELECT nombre FROM categorias";
$stmt_categorias = $conexion->prepare($sql_categorias);
$stmt_categorias->execute();
$categorias_info = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);

// Construye el array de categorías
$categorias = array_column($categorias_info, 'nombre');
$cantidad = count($info_productos);
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

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">

</head>

<body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="tienda.php"><svg xmlns="http://www.w3.org/2000/svg" href="tienda.php" class="icon icon-tabler icon-tabler-sport-billard" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M12 12m-8 0a8 8 0 1 0 16 0a8 8 0 1 0 -16 0" />
                    </svg>
                </a>

                <a class="navbar-brand" href="tienda.php">BillarApp

                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="tienda.php">Tienda</a></li>

                    <li><a href="billar.php">Billar</a></li>
                    <li><a href="pool.php">Pool</a></li>
                </ul>

                <ul class="nav navbar-nav pull-right">
                    <li>
                        <a href="carrito.php" class="btn">CARRITO <span class="badge"><?php print cantidadproducto(); ?></span></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="panel/cerrar_session.php">Salir</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container" id="main">
        <div class="row">
            <form method="POST" action="">
                <label for="filtro-categoria">Filtrar por categoría:</label>
                <select name="filtro-categoria" id="filtro-categoria">
                    <option value="todos">Todos</option>
                    <?php
                    foreach ($categorias as $categoria) {
                        echo "<option value=\"$categoria\">$categoria</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Filtrar">
            </form>

            <?php
            if ($cantidad > 0) {
                for ($x = 0; $x < $cantidad; $x++) {
                    $item = $info_productos[$x];
            ?>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="thumbnail">
                            <div class="caption">
                                <h3 class="text-center titulo-producto"><?php print $item['titulo'] ?></h3>
                                <img src="<?php print 'upload/' . $item['foto']; ?>" class="img-responsive">
                                <p class="text-center">
                                    <a href="carrito.php?id=<?php print $item['id'] ?>" class="btn btn-success" role="button">
                                        <span class="glyphicon glyphicon-shopping-cart"></span> Comprar
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else { ?>
                <h4 class="text-center">NO HAY REGISTROS</h4>
            <?php } ?>
        </div>
    </div> <!-- /container -->

    <!-- jQuery and Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>
