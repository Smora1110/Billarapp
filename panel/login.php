<?php 


if($_SERVER['REQUEST_METHOD'] ==='POST'){

$nombre_usuario = $_POST['nombre_usuario'];

$clave = $_POST['clave'];

require '../vendor/autoload.php';
    $usuario = new billar\usuario;
    $resultado = $usuario->login($nombre_usuario,$clave);
    if(!$resultado){
        print 'login failed ';
    }else{
        $_SESSION['nombre_usuario'] = $nombre_usuario;
        header('Location: index.php');
    }

    print_r($resultado);

}
