<?php

namespace billar;

class Pedido
{

    private $config;
    private $cn = null;

    public function __construct()
    {

        $this->config = parse_ini_file(__DIR__ . '/../config.ini');

        $this->cn = new \PDO($this->config['dns'], $this->config['usuario'], $this->config['clave'], array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ));
    }
    public function mostrar()
    {
        $sql = "SELECT p.id, nombre, mesa, total, fecha FROM pedidos p 
        INNER JOIN clientes c ON p.cliente_id = c.id ORDER BY p.id DESC";

        $resultado = $this->cn->prepare($sql);

        if ($resultado->execute())
            return  $resultado->fetchAll();

        return false;
    }

    public function registrar($_params)
    {
        $sql = "INSERT INTO `pedidos`(`cliente_id`, `total`, `fecha`) 
        VALUES (:cliente_id,:total,:fecha)";

        $resultado = $this->cn->prepare($sql);

        $_array = array(
            ":cliente_id" => $_params['cliente_id'],
            ":total" => $_params['total'],
            ":fecha" => $_params['fecha'],

        );

        if ($resultado->execute($_array))
            return $this->cn->lastInsertId();

        return false;
    }

    public function registrarDetalle($_params)
    {
        $sql = "INSERT INTO `detalle_pedidos`(`pedido_id`, `producto_id`, `precio`, `cantidad`) 
        VALUES (:pedido_id,:producto_id,:precio,:cantidad)";

        $resultado = $this->cn->prepare($sql);

        $_array = array(
            ":pedido_id" => $_params['pedido_id'],
            ":producto_id" => $_params['producto_id'],
            ":precio" => $_params['precio'],
            ":cantidad" => $_params['cantidad'],
        );

        if ($resultado->execute($_array))
            return  true;

        return false;
    }


    public function mostrarUltimos()
    {
        $sql = "SELECT p.id, nombre, mesa, total, fecha FROM pedidos p 
        INNER JOIN clientes c ON p.cliente_id = c.id ORDER BY p.id DESC LIMIT 10";

        $resultado = $this->cn->prepare($sql);

        if ($resultado->execute())
            return  $resultado->fetchAll();

        return false;
    }





    public function mostrarDetallePorIdPedido($id)
    {
        $sql = "SELECT 
                dp.id,
                pe.titulo,
                dp.precio,
                dp.cantidad,
                pe.foto
                FROM detalle_pedidos dp
                INNER JOIN productos pe ON pe.id= dp.producto_id
                WHERE dp.pedido_id = :id";

        $resultado = $this->cn->prepare($sql);

        $_array = array(
            ':id' => $id
        );

        if ($resultado->execute($_array))
            return  $resultado->fetchAll();

        return false;
    }
    public function mostrarMesas()
    {
        $sql = "SELECT nombre_usuario FROM usuarios WHERE estado = 0;
        ";

        $resultado = $this->cn->prepare($sql);

        if ($resultado->execute())
            return  $resultado->fetchAll();

        return false;
    }
    public function mostrarPorId($id)
    {
        $sql = "SELECT p.id, nombre,mesa, total, fecha FROM pedidos p 
        INNER JOIN clientes c ON p.cliente_id = c.id WHERE p.id = :id";

        $resultado = $this->cn->prepare($sql);

        $_array = array(
            ':id' => $id
        );

        if ($resultado->execute($_array))
            return  $resultado->fetch();

        return false;
    }
    public function mostrarPorMesa($nombre_usuario)
    {
        $sql = "SELECT p.id, nombre, mesa, total,fecha 
            FROM pedidos p 
            INNER JOIN clientes c ON p.cliente_id = c.id 
            WHERE mesa = :nombre_usuario
            ORDER BY p.id DESC";

        $resultado = $this->cn->prepare($sql);

        $_array = array(
            ':nombre_usuario' => $nombre_usuario
        );

        if ($resultado->execute($_array))
            return  $resultado->fetchAll();

        return false;
    }


    public function iniciarTiempo($nombreUsuario) {
        try {
            // Obtener la fecha y hora actual
            $fechaHoraInicio = date("Y-m-d H:i:s");

            // Actualizar la base de datos con la fecha y hora de inicio
            $consulta = $this->cn->prepare("UPDATE usuarios SET tiempo_inicio = :fechaHoraInicio, tiempo_fin = NULL WHERE nombre_usuario = :nombreUsuario");
            $consulta->bindParam(':fechaHoraInicio', $fechaHoraInicio, \PDO::PARAM_STR);
            $consulta->bindParam(':nombreUsuario', $nombreUsuario, \PDO::PARAM_STR);
            $consulta->execute();
        } catch (\PDOException $e) {
            // Manejar el error de conexión
            echo "Error de conexión: " . $e->getMessage();
        }
    }

    public function detenerTiempo($nombreUsuario) {
        try {
            // Obtener la fecha y hora actual
            $fechaHoraFin = date("Y-m-d H:i:s");

            // Actualizar la base de datos con la fecha y hora de fin
            $consulta = $this->cn->prepare("UPDATE usuarios SET tiempo_fin = :fechaHoraFin WHERE nombre_usuario = :nombreUsuario");
            $consulta->bindParam(':fechaHoraFin', $fechaHoraFin, \PDO::PARAM_STR);
            $consulta->bindParam(':nombreUsuario', $nombreUsuario, \PDO::PARAM_STR);
            $consulta->execute();
        } catch (\PDOException $e) {
            // Manejar el error de conexión
            echo "Error de conexión: " . $e->getMessage();
        }
    }

    public function reiniciarTiempo($nombreUsuario) {
        try {
            // Reiniciar ambos tiempos en la base de datos a NULL
            $consulta = $this->cn->prepare("UPDATE usuarios SET tiempo_inicio = NULL, tiempo_fin = NULL WHERE nombre_usuario = :nombreUsuario");
            $consulta->bindParam(':nombreUsuario', $nombreUsuario, \PDO::PARAM_STR);
            $consulta->execute();
        } catch (\PDOException $e) {
            // Manejar el error de conexión
            echo "Error de conexión: " . $e->getMessage();
        }
    }
    public function obtenerTiempoTranscurridoActual($nombreUsuario) {
        try {
            // Obtener la fecha y hora de inicio desde la base de datos
            $consulta = $this->cn->prepare("SELECT tiempo_inicio FROM usuarios WHERE nombre_usuario = :nombreUsuario");
            $consulta->bindParam(':nombreUsuario', $nombreUsuario, \PDO::PARAM_STR);
            $consulta->execute();
            $resultado = $consulta->fetch();
    
            // Calcular el tiempo transcurrido en segundos
            if ($resultado && $resultado['tiempo_inicio'] !== null) {
                $tiempoInicio = strtotime($resultado['tiempo_inicio']);
                $tiempoActual = time();
                $tiempoTranscurrido = $tiempoActual - $tiempoInicio;
    
                return $tiempoTranscurrido;
            }
        } catch (\PDOException $e) {
            // Manejar el error de conexión
            echo "Error de conexión: " . $e->getMessage();
        }
    
        return null;
    }
    
}
