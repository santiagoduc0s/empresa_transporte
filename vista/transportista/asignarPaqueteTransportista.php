<?php

require_once "../../modelo/Conexion.php";
require_once "../../modelo/Usuario.php";
require_once "../../modelo/Transportista.php";
require_once "../../modelo/Paquete.php";
require_once "../../manejador/ManejadorTransportista.php";

require_once '../autenticadorSesion.php';
require_once 'autenticarTransportista.php';

require_once 'diseñoTransportista.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Seleccionar paquete - Transportista</title>
</head>

<body>

    <div class="container">

        <?php
        
        $manejadorTransportista = new ManejadorTransportista;

        $transportistaSesion = $_SESSION['usuario'];

        // VERIFICAMOS SI EL TRANSPORTISTA ESTA DISPONIBLE
        // SI NO ESTA DISPONIBLE, NO LO DEJAMOS SELECCIONAR UN PAQUETE
        $estaDisponible = $manejadorTransportista->estaDisponible($transportistaSesion);
        
        if ($estaDisponible) 
        {
            // PAQUETES SI ASIGNAR
            $paquetesSinAsignar = $manejadorTransportista->paquetesSinAsignar();

            if (!is_null($paquetesSinAsignar)) { ?>

                <br>

                <h2>Seleccione un paquete para transportar</h2>

                <br>

                <table class="table table-success">

                    <tr>
                        <th>Codigo</th>
                        <th>Dirección del remitente</th>
                        <th>Dirección del envío</th>
                        <th>Fragil</th>
                        <th>Pedecedero</th>
                        <th></th>
                    </tr>

                    <!-- MOSTRAMOS LOS PAQUETES SIN ASIGNAR -->
                    <?php foreach ($paquetesSinAsignar as $paquete) { ?>

                        <tr>
                            <td><?php echo $paquete->codigo; ?></td>
                            <td><?php echo ucwords($paquete->direccionRemitente); ?></td>
                            <td><?php echo ucwords($paquete->direccionEnvio); ?></td>
                            <td><?php echo ucwords($paquete->fragil); ?></td>
                            <td><?php echo ucwords($paquete->pedecedero); ?></td>
                            <!-- LINK PARA SELECCIONAR UN PAQUETE -->
                            <td><a href="finAsignarPaqueteTransportista.php?codigoPaquete=<?php echo $paquete->codigo; ?>">Seleccionar</a></td>
                        </tr>

                    <?php } ?>

                </table>

            <?php } else { ?>

                <br>

                <h2>No hay paquetes para enviar</h2>

                <br>

            <?php }

        } else { ?>

            <br>

            <h2>Ya tiene un paquete asignado</h2>

            <br>

        <?php } ?>

    </div>

</body>

</html>