<?php

require_once "../../modelo/Conexion.php";
require_once "../../modelo/Usuario.php";
require_once "../../modelo/Encargado.php";
require_once "../../modelo/Paquete.php";
require_once "../../manejador/ManejadorEncargado.php";

require_once '../autenticadorSesion.php';
require_once 'autenticarEncargado.php';

require_once 'diseñoEncargado.php';

// SI NO HAY UN PAQUETE SELECIONADO, NO SE PUEDE ENTAR A ESTA VISTA
if (!isset($_GET['codigoPaquete']))
{
    header('Location: homeEncargado.php');
    die();
}

?>

<DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Modificar Paquete - Encargado</title>
</head>

<body>

    <div class="container">

        <?php

        // ESTRAEMOS EL CODIGO DEL PAQUETE SELECCIONADO
        $codigoPaquete = $_GET['codigoPaquete'];

        $manejadorEncargado = new ManejadorEncargado;

        // INFORMACIN DEL PAQUETE SELECCIONADO
        $paqueteParaModificar = $manejadorEncargado->paqueteParaModificar($codigoPaquete);
        
        ?>

        <br>

        <h2>Modificar paquete - Encargado</h2>

        <div class="col-md-5">

            <form class="form" action="../../controlador/controladorEncargado.php?accion=modificarPaquete" method="POST">

                <!-- CODIGO PAQUETE (DISABLE) -->
                <label for="codigo_paquete">Código paquete</label>
                <input id="codigo_paquete" class="form-control"
                       type="text" value="<?php echo $paqueteParaModificar->codigo ?>" disabled>

                <!-- CODIGO DEL PAQUETE -->
                <input type="hidden" name="codigoPaquete" value="<?php echo $paqueteParaModificar->codigo ?>">

                <!-- FRAGIL -->
                <label for="fragil">Fragil</label>
                <select id="fragil" class="form-control" name="fragil">
                    <?php if ($paqueteParaModificar->fragil == 'si') { ?>
                        <option value="si" selected>Si</option>
                        <option value="no">No</option>
                    <?php } else { ?>
                        <option value="si">Si</option>
                        <option value="no" selected>No</option>
                    <?php } ?>
                </select>

                <!-- PEDECEDERO -->
                <label for="pedecedero">Pedecedero</label>
                <select id="pedecedero" class="form-control" name="pedecedero">
                    <?php if ($paqueteParaModificar->pedecedero == 'si') { ?>
                        <option value="si" selected>Si</option>
                        <option value="no">No</option>
                    <?php } else { ?>
                        <option value="si">Si</option>
                        <option value="no" selected>No</option>
                    <?php } ?>
                </select>

                <!-- DIRECCION DEL REMITENTE -->
                <label for="direccion_remitente">Dirección del remitente</label>
                <input id="direccion_remitente" class="form-control"
                       type="text" name="direccionRemitente" maxlength="45" required
                       value="<?php echo ucwords($paqueteParaModificar->direccionRemitente); ?>">

                <!-- DIRECCION DE ENVIO -->
                <label for="direccion_envio">Dirección de envio</label>
                <input id="direccion_envio" class="form-control"
                       type="text" name="direccionEnvio" maxlength="45" required
                       value="<?php echo ucwords($paqueteParaModificar->direccionEnvio); ?>">

                <br>

                <!-- BOTON MODIFICAR PAQUETE -->
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" name="modificarPaquete" value="Modificar">
                </div>

            </form>

        </div>

    </div>

</body>

</html>