<?php

require_once '../../modelo/Conexion.php';
require_once '../../modelo/Paquete.php';
require_once '../../manejador/ManejadorVisitante.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">

    <title>Buscar paquete - Visitante</title>

    <link rel="icon" href="../iconoEmpresa.ico">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>

<body>

    <div class="container">

        <div class="abs-center">

            <br>
            
            <h2>Ingrese el código de su paquete</h2>
            
            <br>

            <form action="mostrarPaqueteVisitante.php" method="POST" class="border p-3 form">

                <!-- CODIGO PAQUETE -->
                <div class="form-group">
                    <label for="codigo_paquete">Codigo del paquete</label>
                    <input id="codigo_paquete" class="form-control" type="text" name="codigo_paquete" pattern="[a-z0-9]{16}" minlength="16" maxlength="16" required>
                </div>

                <input class="btn btn-success" type="submit" name="buscarPaquete" value="Buscar">

            </form>

            <?php if (isset($_POST['buscarPaquete'])) {

                $codigoPaquete = $_POST['codigo_paquete'];

                $manejadorVisitante = new ManejadorVisitante;

                // DATOS DEL PAQUETE INGRESADO
                $paquete = $manejadorVisitante->buscarPaquete($codigoPaquete);

                if (!is_null($paquete)) { ?>
                
                    <table class="table">

                        <tr>
                            <th>Estado</th>
                            <th>Dirección de envío</th>
                            <th>Fecha estimada de entrega</th>
                            <th>Fecha de entrega</th>
                        </tr>

                        <!-- MOSTRAMOS LOS DATOS DEL PAQUETE INGRESADO -->
                        <tr>
                            <td><?php echo ucwords($paquete->estadoPaquete); ?></td>
                            <td><?php echo ucwords($paquete->direccionEnvio); ?></td>
                            <td><?php echo $paquete->fechaEstimadaEntrega; ?></td>
                            <td><?php echo $paquete->fechaEntrega; ?></td>
                        </tr>

                    </table>

                <?php } else { ?>

                    <br>
                    
                    <h3>Este paquete no existe</h3>
                    
                    <br>

                <?php }

            } ?>
            
        </div>

    </div>

</body>

</html>