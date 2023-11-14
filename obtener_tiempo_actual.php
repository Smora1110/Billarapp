<?php
// Simular un retardo de 1 segundo (puedes eliminar esto en un entorno de producción)
sleep(1);

// Obtener el tiempo actual en formato JSON
$tiempoActual = [
    'minutos' => date('i'),
    'segundos' => date('s')
];

// Establecer el encabezado para indicar que se envía JSON
header('Content-Type: application/json');

// Imprimir el tiempo actual como JSON
echo json_encode($tiempoActual);
?>
