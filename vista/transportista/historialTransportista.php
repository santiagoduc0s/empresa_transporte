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
    <title>Historial - Transportista</title>
</head>

<body>

    <div class="container">

        <?php

        $manejadorTransportista = new ManejadorTransportista;

        // EXTRAEMOS AL TRANSPORTISTA INGRESADO EN LA SESION
        $transportistaSesion = $_SESSION['usuario'];

        // TODOS LOS PAQUETES DEL TRANSPORTISTA QUE INICIÓ SESION
        $historialPaquetes = $manejadorTransportista->historialTransportista($transportistaSesion);

        if (!is_null($historialPaquetes)) { ?>

            <br>

            <h2>Historial de paquetes</h2>

            <br>

            <table class="table table-success">

                <tr>
                    <th>Codigo</th>
                    <th>Fecha estimada de entrega</th>
                    <th>Fecha de entrega</th>
                    <th>Estado</th>
                </tr>

                <!-- MOSTRAMOS LOS PAQUETES ASIGNADOS AL TRANSPORTISTA -->
                <?php foreach ($historialPaquetes as $paquete) { ?>

                    <tr>
                        <td><?php echo $paquete->codigo; ?></td>
                        <td><?php echo $paquete->fechaEstimadaEntrega; ?></td>
                        <td><?php echo $paquete->fechaEntrega; ?></td>
                        <td><?php echo ucwords($paquete->estadoPaquete); ?></td>
                    </tr>
                    
                <?php } ?>
                
            </table>
            
        <?php } else { ?>

            <br>

            <h2>Aún no ha entregado ningun paquete</h2>

            <br>

        <?php } ?>
    
    </div>

</body>

</html>