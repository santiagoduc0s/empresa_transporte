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
    <title>Administrar paquetes - Encargado</title>
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

            <h2>Administración de paquetes</h2>

            <br>

            <table class="table table-success">

                <tr>
                    <th>Código</th>
                    <th>Estado</th>
                    <th>Fecha estimada de la entrega</th>
                    <th>Fragil</th>
                    <th>Pedecedero</th>
                    <th>Dirección del remitente</th>
                    <th>Dirección del envío</th>
                    <th>Fecha y hora de asignación</th>
                    <th>Fecha de entrega</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                </tr>
            
                <!-- MOSTRSMOS LO PAQUETES SIN ASIGNAR -->
                <?php for ($i = 0; $i < count($paquetesSinAsignar); $i++) { ?>
                    
                    <tr>
                        <td><?php echo $paquetesSinAsignar[$i]->codigo; ?></td>
                        <td><?php echo ucwords($paquetesSinAsignar[$i]->estadoPaquete); ?></td>
                        <td>-</td>
                        <td><?php echo ucwords($paquetesSinAsignar[$i]->fragil); ?></td>
                        <td><?php echo ucwords($paquetesSinAsignar[$i]->pedecedero); ?></td>
                        <td><?php echo ucwords($paquetesSinAsignar[$i]->direccionRemitente); ?></td>
                        <td><?php echo ucwords($paquetesSinAsignar[$i]->direccionEnvio); ?></td>
                        <td>-</td>
                        <td>-</td>
                        <!-- LINK PARA MODIFICAR EL PAQUETE SIN ASIGNAR -->
                        <td><a href='modificarPaqueteEncargado.php?codigoPaquete=<?php echo $paquetesSinAsignar[$i]->codigo; ?>'>Modificar</a></td>
                        <!-- LINK PARA ELIMINAR EL PAQUETE SIN ASIGNAR -->
                        <td><a href='../../controlador/controladorEncargado.php?accion=eliminarPaquete&codigoPaquete=<?php echo $paquetesSinAsignar[$i]->codigo; ?>'>Eliminar</a></td>
                    </tr>

                <?php } ?>

                <tr><td colspan="11"></td></tr>

                <!-- MOSTRSMOS LO PAQUETES EN TRANSITO -->
                <?php for ($i = 0; $i < count($paquetesEnTransito); $i++) { ?>

                    <tr>
                        <td><?php echo $paquetesEnTransito[$i]->codigo; ?></td>
                        <td><?php echo ucwords($paquetesEnTransito[$i]->estadoPaquete); ?></td>
                        <td><?php echo $paquetesEnTransito[$i]->fechaEstimadaEntrega; ?></td>
                        <td><?php echo ucwords($paquetesEnTransito[$i]->fragil); ?></td>
                        <td><?php echo ucwords($paquetesEnTransito[$i]->pedecedero); ?></td>
                        <td><?php echo ucwords($paquetesEnTransito[$i]->direccionRemitente); ?></td>
                        <td><?php echo ucwords($paquetesEnTransito[$i]->direccionEnvio); ?></td>
                        <td><?php echo $paquetesEnTransito[$i]->fechaYHoraAsignacion; ?></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>

                <?php } ?>
                
                <tr><td colspan="11"></td></tr>

                <!-- MOSTRSMOS LO PAQUETES ENTREGADOS -->
                <?php for ($i = 0; $i < count($paquetesEntregados); $i++) { ?>

                    <tr>
                        <td><?php echo $paquetesEntregados[$i]->codigo; ?></td>
                        <td><?php echo ucwords($paquetesEntregados[$i]->estadoPaquete); ?></td>
                        <td><?php echo $paquetesEntregados[$i]->fechaEstimadaEntrega; ?></td>
                        <td><?php echo ucwords($paquetesEntregados[$i]->fragil); ?></td>
                        <td><?php echo ucwords($paquetesEntregados[$i]->pedecedero); ?></td>
                        <td><?php echo ucwords($paquetesEntregados[$i]->direccionRemitente); ?></td>
                        <td><?php echo ucwords($paquetesEntregados[$i]->direccionEnvio); ?></td>
                        <td><?php echo $paquetesEntregados[$i]->fechaYHoraAsignacion; ?></td>
                        <td><?php echo $paquetesEntregados[$i]->fechaEntrega; ?></td>
                        <td>-</td>
                        <td>-</td>
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