<?php

require_once "../../modelo/Conexion.php";
require_once "../../modelo/Usuario.php";
require_once "../../modelo/Transportista.php";
require_once "../../modelo/Paquete.php";
require_once "../../manejador/ManejadorTransportista.php";

require_once '../autenticadorSesion.php';
require_once 'autenticarTransportista.php';

require_once 'diseñoTransportista.php';

// SI NO SE SELECCIONÓ NINGUN PAQUETE, REDIRECCIONAMOS AL HOME
if (!isset($_GET['codigoPaquete']))
{
    header("Location: homeTransportista.php");
    die();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Finalizar selección - Transportista</title>
</head>

<body>

    <div class="container">

        <br>

        <h2>Finalizar selección - Transportista</h2>

        <br>

        <table class="table table-success">

            <tr>
                <th>Código</th>
                <th>Dirección del remitente</th>
                <th>Dirección del envío</th>
                <th>Fragil</th>
                <th>Pedecedero</th>
            </tr>

            <?php

            $manejadorTransportista = new ManejadorTransportista;

            // EXTRAEMOS AL TRANSPORTISTA INGRESADO EN LA SESION
            $transportistaSesion = $_SESSION['usuario'];
            // EXTRAEMOS EL CODIGO DEL PAQUETE SELECCIONADO
            $codigoPaqueteSeleccionado = $_GET['codigoPaquete'];
            
            // DATOS DEL PAQUETE SELECCIONADO
            $paqueteSeleccionado = $manejadorTransportista->paqueteParaAsignar($codigoPaqueteSeleccionado);

            ?>

            <!-- MOSTRAMOS LOS DATOS DEL PAQUETE SELECCIONADO -->
            <tr>
                <td><?php echo $paqueteSeleccionado->codigo; ?></td>
                <td><?php echo ucwords($paqueteSeleccionado->direccionRemitente); ?></td>
                <td><?php echo ucwords($paqueteSeleccionado->direccionEnvio); ?></td>
                <td><?php echo ucwords($paqueteSeleccionado->fragil); ?></td>
                <td><?php echo ucwords($paqueteSeleccionado->pedecedero); ?></td>
            </tr>

        </table>

        <div class="col-md-5">

            <form action="../../controlador/controladorTransportista.php?accion=asignarPaquete" method="POST">

                <!-- CODIGO DEL PAQUETE -->
                <input type="hidden" name="codigoPaquete" value="<?php echo $codigoPaqueteSeleccionado ?>">

                <!-- FECHA ESTIMADA DE ENTREGA -->
                <label for="fecha_estimada_entrega">Fecha estimada de la entrega</label>
                <input id="fecha_estimada_entrega" class="form-control" 
                    type="date" name="fechaEstimadaEntrega" min="<?php echo date('Y-m-d'); ?>" required>

                <br>

                <!-- BOTON TERMINAR ASIGNACION DE PAQUETE -->
                <input class="btn btn-primary" type="submit" name="asignarPaquete" value="Terminar">

            </form>

        </div>

    </div>

</body>

</html>