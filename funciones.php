<?php

// Establece la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "tiendabillar";

try {
    $conexion = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    throw new Exception("Error en la conexión: " . $e->getMessage());
}

function agregarproducto($resultado, $id, $cantidad = 1){
    $_SESSION['carrito'][$id] = array(
        'id' => $resultado['id'],
        'titulo' => $resultado['titulo'],
        'foto' => $resultado['foto'],
        'precio' => $resultado['precio'],
        'cantidad' => $cantidad
    );
}

function actualizarproducto($id, $cantidad = FALSE){
    if($cantidad) {
        $_SESSION['carrito'][$id]['cantidad'] = $cantidad;
    } else {
        $_SESSION['carrito'][$id]['cantidad'] += 1;
    }
}

function calcularTotal(){
    $total = 0;
    if(isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])){
        foreach($_SESSION['carrito'] as $indice => $value){
            $total += $value['precio'] * $value['cantidad'];
        }
    }
    return $total;
}

function cantidadproducto(){
    $cantidad = 0;
    if(isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])){
        foreach($_SESSION['carrito'] as $indice => $value){
            $cantidad++;
        }
    }
    return $cantidad;
}

function guardarPuntos($equipo, $puntos) {
    global $conexion; // Importa la conexión a la base de datos

    try {
        // Actualiza puntos en la tabla 'puntos'
        $stmt = $conexion->prepare("UPDATE puntos SET puntos = :puntos WHERE equipo = :equipo");
        $stmt->bindParam(':puntos', $puntos, PDO::PARAM_INT);
        $stmt->bindParam(':equipo', $equipo, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        // Manejar errores en la base de datos
        throw new Exception("Error al guardar puntos: " . $e->getMessage());
    }
}

function reiniciarPuntosEnBaseDeDatos($equipo) {
    global $conexion; // Importa la conexión a la base de datos

    try {
        // Reinicia puntos en la tabla 'puntos'
        if ($conexion) {
            $stmt = $conexion->prepare("UPDATE puntos SET puntos = 0 WHERE equipo = :equipo");
            $stmt->bindParam(':equipo', $equipo, PDO::PARAM_STR);
            $stmt->execute();
        } else {
            throw new Exception("Error: La conexión a la base de datos no está establecida.");
        }
    } catch (PDOException $e) {
        // Manejar errores en la base de datos
        throw new Exception("Error al reiniciar puntos: " . $e->getMessage());
    } catch (Exception $e) {
        // Manejar otros errores
        throw new Exception("Error: " . $e->getMessage());
    }
}
?>
