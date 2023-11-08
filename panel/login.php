<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre_usuario = $_POST['nombre_usuario'];
    $clave = $_POST['clave'];
    require '../vendor/autoload.php';
    $usuario = new billar\usuario;
    $resultado = $usuario->login($nombre_usuario, $clave);

    if ($resultado) {

        session_start();

        $_SESSION['usuario_info'] = array(
            'nombre_usuario' => $resultado['$nombre_usuario'],
            'estado'=> 1
        );

        if ($nombre_usuario=='admin') {
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            header('Location: dashboard.php');
        } elseif ($nombre_usuario!=='admin'){
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            header('Location: ../index.php');
        }

    } else {
        echo "Usuario o contraseña incorrectos";
    }
    
}
