<?php

require_once "../../modelo/Conexion.php";
require_once "../../modelo/Usuario.php";
require_once "../../modelo/Encargado.php";
require_once "../../modelo/Transportista.php";
require_once "../../modelo/Paquete.php";
require_once "../../manejador/ManejadorEncargado.php";

require_once '../autenticadorSesion.php';
require_once 'autenticarEncargado.php';

require_once 'diseñoEncargado.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Home - Encargado</title>
</head>

<body>

    <div class="container">

        <?php

        $manejadorEncargado = new ManejadorEncargado;

        // PAQUETES EN TRANSITO CON SU TRANSPORTISTA
        $transportesActivos = $manejadorEncargado->paquetesEnTransito();
        
        if (!is_null($transportesActivos)) { ?>
        
            <br>
            
            <h2>Paquetes en transito</h2>

            <br>
            
            <table class="table table-success">

                <tr>
                    <th>Código paquete</th>
                    <th>Cédula transportista</th>
                    <th>Nombre Transportista</th>
                    <th>Fecha y hora de asignación</th>
                </tr>

                <!-- MOSTRAR PAQUETES EN TRANSITO CON SU TRANSPORTISTA -->
                <?php foreach ($transportesActivos as $transportistaPaquete) { ?>

                    <tr>
                        <td><?php echo $transportistaPaquete[0]->codigo; ?></td>
                        <td><?php echo $transportistaPaquete[1]->cedula; ?></td>
                        <td><?php echo ucwords($transportistaPaquete[1]->nombre); ?></td>
                        <td><?php echo $transportistaPaquete[0]->fechaYHoraAsignacion; ?></td>
                    </tr>
                    
                <?php } ?>

            </table>
            
        <?php } else { ?>

            <h1>No hay paquetes en transito</h1>

        <?php } ?>

    </div>

</body>

</html>