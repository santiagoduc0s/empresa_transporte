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
    <title>Historial de paquetes - Encargado</title>
</head>

<body>

    <div class="container">

        <?php

        $manejadorEncargado = new ManejadorEncargado;

        // TODOS LOS PAQUETES
        $todosLosPaquetes = $manejadorEncargado->todosLosPaquetes();

        if (!is_null($todosLosPaquetes))
        {
            // PAQUETES SIN ASIGNAR
            $paquetesSinAsignar = $todosLosPaquetes["paquetesSinAsignar"];
            // PAQUETES EN TRANSITO
            $paquetesEnTransito = $todosLosPaquetes["paquetesEnTransito"];
            // PAQUETES ENTREGADOS
            $paquetesEntregados = $todosLosPaquetes["paquetesEntregados"];

            ?>

            <br>

            <h2>Historial de paquetes</h2>

            <br>

            <table class="table table-success">

                <tr>
                    <th>Código</th>
                    <th>Estado</th>
                    <th>Fecha estimada de la entrega</th>
                    <th>Fecha entrega</th>
                </tr>
            
                <!-- MOSTRAMOS LOS PAQUETES SIN ASIGNAR -->
                <?php for ($i = 0; $i < count($paquetesSinAsignar); $i++) { ?>
                    
                    <tr>
                        <td><?php echo $paquetesSinAsignar[$i]->codigo; ?></td>
                        <td><?php echo ucwords($paquetesSinAsignar[$i]->estadoPaquete); ?></td>
                        <td>-</td>
                        <td>-</td>
                    </tr>

                <?php } ?>

                <tr><td colspan="11"></td></tr>

                <!-- MOSTRAMOS LOS PAQUETES EN TRANSITO -->
                <?php for ($i = 0; $i < count($paquetesEnTransito); $i++) { ?>

                    <tr>
                        <td><?php echo $paquetesEnTransito[$i]->codigo; ?></td>
                        <td><?php echo ucwords($paquetesEnTransito[$i]->estadoPaquete); ?></td>
                        <td><?php echo $paquetesEnTransito[$i]->fechaEstimadaEntrega; ?></td>
                        <td>-</td>
                    </tr>

                <?php } ?>
                
                <tr><td colspan="11"></td></tr>

                <!-- MOSTRAMOS LOS PAQUETES ENTREGADOS -->
                <?php for ($i = 0; $i < count($paquetesEntregados); $i++) { ?>

                    <tr>
                        <td><?php echo $paquetesEntregados[$i]->codigo; ?></td>
                        <td><?php echo ucwords($paquetesEntregados[$i]->estadoPaquete); ?></td>
                        <td><?php echo $paquetesEntregados[$i]->fechaEstimadaEntrega; ?></td>
                        <td><?php echo $paquetesEntregados[$i]->fechaEntrega ?></td>
                    </tr>

                <?php } ?>   

            </table>     

        <?php } else {?>

            <br>

            <h2>No hay paquetes</h2>

            <br>

        <?php } ?>

    </div>

</body>

</html>