<?php

require_once "../../modelo/Conexion.php";
require_once "../../modelo/Usuario.php";
require_once "../../modelo/Encargado.php";

require_once '../autenticadorSesion.php';
require_once 'autenticarEncargado.php';

require_once 'diseñoEncargado.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Crear paquete - Encargado</title>
</head>

<body>

    <div class="container">

        <br>

        <h2>Crear paquete</h2>

        <div class="col-md-5">

            <form action="../../controlador/controladorEncargado.php?accion=crearPaquete" method="POST">

                <!-- DIRECCION DEL REMITENTE -->
                <label for="direccion_remitente">Dirección del remitente</label> 
                <input id="direccion_remitente" class="form-control"
                       type="text" name="direccionRemitente" maxlength="45" 
                       placeholder="Ingrese la dirección del remitente" required>

                <!-- DIRECCION DE ENVIO -->
                <label for="direccion_envio">Dirección de envío</label>
                <input id="direccion_envio" class="form-control" 
                       type="text" name="direccionEnvio" maxlength="45" 
                       placeholder="Ingrese la dirección de envío" required>

                <!-- FRAGIL -->
                <label for="fragil">Fragil</label>
                <select id="fragil" class="form-control" name="fragil">
                    <option value="no">No</option>
                    <option value="si">Si</option>
                </select>

                <!-- PEDECEDERO -->
                <label for="pedecedero">Pedecedero</label>
                <select id="pedecedero" class="form-control" name="pedecedero">
                    <option value="no">No</option>
                    <option value="si">Si</option>
                </select>

                <br>

                <!-- BOTON CREAR PAQUETE -->
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" name="crearPaquete" value="Crear">
                </div>

            </form>

        </div>

    </div>

</body>

</html>