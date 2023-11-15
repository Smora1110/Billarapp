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
    

    

    private function calcularDiferenciaEnMinutos($fechaInicio, $fechaFin)
    {
        $fechaInicio = new \DateTime($fechaInicio);
        $fechaFin = new \DateTime($fechaFin);

        $diferencia = $fechaInicio->diff($fechaFin);

        // Calcular la diferencia total en minutos
        $diferenciaEnMinutos = $diferencia->days * 24 * 60 + $diferencia->h * 60 + $diferencia->i;

        return $diferenciaEnMinutos;
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



    public function iniciarTiempo($nombreUsuario)
{
    try {
        // Actualizar la base de datos con la fecha y hora de inicio
        $consulta = $this->cn->prepare("UPDATE usuarios SET tiempo_inicio = CURRENT_TIMESTAMP, tiempo_fin = NULL WHERE nombre_usuario = :nombreUsuario");
        $consulta->bindParam(':nombreUsuario', $nombreUsuario, \PDO::PARAM_STR);
        $consulta->execute();
        
        // Obtener la fecha y hora actual desde la base de datos
        $consulta = $this->cn->prepare("SELECT tiempo_inicio FROM usuarios WHERE nombre_usuario = :nombreUsuario");
        $consulta->bindParam(':nombreUsuario', $nombreUsuario, \PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(\PDO::FETCH_ASSOC);

        // Devolver la fecha y hora de inicio desde la base de datos
        return $resultado['tiempo_inicio'];
    } catch (\PDOException $e) {
        // Manejar el error de conexión
        echo "Error de conexión: " . $e->getMessage();
    }
}


public function detenerTiempo($nombreUsuario)
{
    try {
        // Actualizar la base de datos con la fecha y hora de fin
        $consulta = $this->cn->prepare("UPDATE usuarios SET tiempo_fin = CURRENT_TIMESTAMP WHERE nombre_usuario = :nombreUsuario");
        $consulta->bindParam(':nombreUsuario', $nombreUsuario, \PDO::PARAM_STR);
        $consulta->execute();
        
        // Obtener la fecha y hora de fin desde la base de datos
        $consulta = $this->cn->prepare("SELECT tiempo_fin FROM usuarios WHERE nombre_usuario = :nombreUsuario");
        $consulta->bindParam(':nombreUsuario', $nombreUsuario, \PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(\PDO::FETCH_ASSOC);

        // Devolver la fecha y hora de fin desde la base de datos
        return $resultado['tiempo_fin'];
    } catch (\PDOException $e) {
        // Manejar el error de conexión
        echo "Error de conexión: " . $e->getMessage();
    }
}
public function actual($nombreUsuario)
{
    try {
        // Actualizar la base de datos con la fecha y hora de fin
        $consulta = $this->cn->prepare("UPDATE usuarios SET actual = CURRENT_TIMESTAMP WHERE nombre_usuario = :nombreUsuario");
        $consulta->bindParam(':nombreUsuario', $nombreUsuario, \PDO::PARAM_STR);
        $consulta->execute();
        
        // Obtener la fecha y hora de fin desde la base de datos
        $consulta = $this->cn->prepare("SELECT actual FROM usuarios WHERE nombre_usuario = :nombreUsuario");
        $consulta->bindParam(':nombreUsuario', $nombreUsuario, \PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(\PDO::FETCH_ASSOC);

        // Devolver la fecha y hora de fin desde la base de datos
        return $resultado['actual'];
    } catch (\PDOException $e) {
        // Manejar el error de conexión
        echo "Error de conexión: " . $e->getMessage();
    }
}
public function inicio($nombreUsuario)
{
    try {
        
        $consulta = $this->cn->prepare("SELECT tiempo_inicio FROM usuarios WHERE nombre_usuario = :nombreUsuario");
        $consulta->bindParam(':nombreUsuario', $nombreUsuario, \PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(\PDO::FETCH_ASSOC);

        // Devolver la fecha y hora de fin desde la base de datos
        return $resultado['tiempo_inicio'];
    } catch (\PDOException $e) {
        // Manejar el error de conexión
        echo "Error de conexión: " . $e->getMessage();
    }
}

    public function reiniciarTiempo($nombreUsuario)
    {
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
    public function obtenerTiempoTranscurridoActual($nombreUsuario)
    {
        try {
            // Obtener la fecha y hora de inicio y fin desde la base de datos
            $consulta = $this->cn->prepare("SELECT UNIX_TIMESTAMP(tiempo_inicio) as tiempo_inicio, UNIX_TIMESTAMP(tiempo_fin) as tiempo_fin FROM usuarios WHERE nombre_usuario = :nombreUsuario");
            $consulta->bindParam(':nombreUsuario', $nombreUsuario, \PDO::PARAM_STR);
            $consulta->execute();
            $resultado = $consulta->fetch(\PDO::FETCH_ASSOC);


            // Calcular el tiempo transcurrido en segundos
            if ($resultado && $resultado['tiempo_inicio'] !== null && $resultado['tiempo_fin'] !== null) {
                $tiempoInicio = $resultado['tiempo_inicio'];
                $tiempoFin = $resultado['tiempo_fin'];

                // Calcular la diferencia en segundos
                $tiempoTranscurrido = $tiempoFin - $tiempoInicio;

                // Convertir a minutos
                $tiempoTranscurridoEnMinutos = round($tiempoTranscurrido / 60);

                return $tiempoTranscurridoEnMinutos;
            }
        } catch (\PDOException $e) {
            // Manejar el error de conexión
            echo "Error de conexión: " . $e->getMessage();
        }

        return 0; // Retorna 0 si hay algún problema o no se encuentran datos
    }
    public function obtenerTiempo($nombreUsuario)
    {
        try {
            // Obtener la fecha y hora de inicio y fin desde la base de datos
            $consulta = $this->cn->prepare("SELECT UNIX_TIMESTAMP(tiempo_inicio) as tiempo_inicio, UNIX_TIMESTAMP(tiempo_fin) as tiempo_fin FROM usuarios WHERE nombre_usuario = :nombreUsuario");
            $consulta->bindParam(':nombreUsuario', $nombreUsuario, \PDO::PARAM_STR);
            $consulta->execute();
            $resultado = $consulta->fetch(\PDO::FETCH_ASSOC);


            // Calcular el tiempo transcurrido en segundos
            if ($resultado && $resultado['tiempo_inicio'] !== null && $resultado['tiempo_fin'] !== null) {
                $tiempoInicio = $resultado['tiempo_inicio'];
                $tiempoFin = $resultado['tiempo_fin'];

                // Calcular la diferencia en segundos
                $tiempoTranscurrido = $tiempoFin - $tiempoInicio;

                // Convertir a minutos
                $tiempoTranscurridoEnMinutos = round($tiempoTranscurrido / 60);

                return $tiempoTranscurridoEnMinutos;
            }
        } catch (\PDOException $e) {
            // Manejar el error de conexión
            echo "Error de conexión: " . $e->getMessage();
        }

        return 0; // Retorna 0 si hay algún problema o no se encuentran datos
    }








    // Agrega el siguiente método a tu clase Pedido
    public function obtenerTiemposInicioFin($nombreUsuario)
    {
        try {
            // Obtener la fecha y hora de inicio y fin desde la base de datos
            $consulta = $this->cn->prepare("SELECT tiempo_inicio, tiempo_fin FROM usuarios WHERE nombre_usuario = :nombreUsuario");
            $consulta->bindParam(':nombreUsuario', $nombreUsuario, \PDO::PARAM_STR);
            $consulta->execute();
            $resultado = $consulta->fetch();

            // Retorna el resultado obtenido
            return $resultado;
        } catch (\PDOException $e) {
            // Manejar el error de conexión
            echo "Error de conexión: " . $e->getMessage();
        }

        return null;
    }


    public function eliminarDatosMesa($nombre_usuario)
    {
        try {
            // Iniciar transacción para asegurar operaciones atómicas
            $this->cn->beginTransaction();

            // Eliminar toda la fila en la tabla clientes que tenga el nombre de usuario especificado
            $consultaEliminarCliente = $this->cn->prepare("DELETE FROM clientes WHERE mesa = :nombre_usuario");
            $consultaEliminarCliente->bindParam(':nombre_usuario', $nombre_usuario, \PDO::PARAM_STR);
            $consultaEliminarCliente->execute();

            // Confirmar la transacción
            $this->cn->commit();
        } catch (\PDOException $e) {
            // Revertir la transacción en caso de error
            $this->cn->rollBack();

            // Manejar el error de conexión
            echo "Error de conexión: " . $e->getMessage();
        }
    }
}