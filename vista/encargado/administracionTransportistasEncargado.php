<?php

require_once "../../modelo/Conexion.php";
require_once "../../modelo/Usuario.php";
require_once "../../modelo/Encargado.php";
require_once "../../modelo/Transportista.php";
require_once "../../manejador/ManejadorEncargado.php";

require_once '../autenticadorSesion.php';
require_once 'autenticarEncargado.php';

require_once 'diseñoEncargado.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Administrar transportistas - Encargado</title>
</head>

<body>

    <div class="container">

        <?php

        $manejadorEncargado = new ManejadorEncargado;

        // TODOS LOS TRANSPORTISTAS
        $todosLosTransportistas = $manejadorEncargado->todosLosTransportistas();

        if (!is_null($todosLosTransportistas)) 
        { 
            // TRANSPORTISTAS DISPONIBLES
            $transportistasDisponibles = $todosLosTransportistas['transportistasDisponibles'];
            // TRANSPORTISTAS NO DISPONIBLES
            $transportistasNoDisponibles = $todosLosTransportistas["transportistasNoDisponibles"];
            
            ?>

            <br>
            
            <h2>Administración de transportistas</h2>
            
            <br>

            <table class="table table-success">

                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Estado</th>
                    <th>Foto</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                </tr>

                <!-- MOSTRAMOS LOS TRANSPORTISTAS DISPONIBLES -->
                <?php for ($i = 0; $i < count($transportistasDisponibles); $i++) { ?>
                    
                    <tr>
                        <td><?php echo $transportistasDisponibles[$i]->cedula; ?></td>
                        <td><?php echo ucwords($transportistasDisponibles[$i]->nombre); ?></td>
                        <td><?php echo ucwords($transportistasDisponibles[$i]->apellido); ?></td>
                        <td><?php echo $transportistasDisponibles[$i]->telefono; ?></td>
                        <td><?php echo ucwords($transportistasDisponibles[$i]->direccion); ?></td>
                        <td><?php echo ucwords($transportistasDisponibles[$i]->estadoTransportista); ?></td>
                        <td><img src="<?php echo $transportistasDisponibles[$i]->foto; ?>" alt="Hubo un error" width="100" height="100"></td>
                        <!-- LINK PARA MODIFICAR EL TRANSPORTISTA -->
                        <td><a href='modificarTransportistaEncargado.php?cedulaTransportista=<?php echo $transportistasDisponibles[$i]->cedula; ?>'>Modificar</a></td>
                        <!-- LINK PARA ELIMINAR EL ELIMINAR -->
                        <td><a href='../../controlador/controladorEncargado.php?accion=eliminarTransportista&cedulaTransportista=<?php echo $transportistasDisponibles[$i]->cedula; ?>'>Eliminar</a></td>
                    </tr>

                <?php } ?>
                    
                    <tr><td colspan="11"></td></tr>

                <!-- MOSTRAMOS LOS TRANSPORTISTAS NO DISPONIBLES -->
                <?php for ($i = 0; $i < count($transportistasNoDisponibles); $i++) { ?>
                    
                    <tr>
                        <td><?php echo $transportistasNoDisponibles[$i]->cedula; ?></td>
                        <td><?php echo ucwords($transportistasNoDisponibles[$i]->nombre); ?></td>
                        <td><?php echo ucwords($transportistasNoDisponibles[$i]->apellido); ?></td>
                        <td><?php echo $transportistasNoDisponibles[$i]->telefono; ?></td>
                        <td><?php echo ucwords($transportistasNoDisponibles[$i]->direccion); ?></td>
                        <td><?php echo ucwords($transportistasNoDisponibles[$i]->estadoTransportista); ?></td>
                        <td><img src="<?php echo $transportistasNoDisponibles[$i]->foto; ?>" alt="Hubo un error" width="100" height="100"></td>
                        <!-- LINK PARA MODIFICAR EL TRANSPORTISTA -->
                        <td><a href='modificarTransportistaEncargado.php?cedulaTransportista=<?php echo $transportistasNoDisponibles[$i]->cedula; ?>'>Modificar</a></td>
                        <!-- LINK PARA ELIMINAR EL TRANSPORTISTA -->
                        <td><a href='../../controlador/controladorEncargado.php?accion=eliminarTransportista&cedulaTransportista=<?php echo $transportistasNoDisponibles[$i]->cedula; ?>'>Eliminar</a></td>
                    </tr>

                <?php } ?>

            </table>

        <?php } else {?>

            <br>

            <h2>No hay transportistas</h2>

            <br>

        <?php } ?>

    </div>

</body>

</html>