<?php

require_once "../../modelo/Conexion.php";
require_once "../../modelo/Usuario.php";
require_once "../../modelo/Encargado.php";
require_once "../../manejador/ManejadorEncargado.php";

require_once '../autenticadorSesion.php';
require_once 'autenticarEncargado.php';

require_once 'diseñoEncargado.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Registar transportista - Encargado</title>
</head>

<body>

    <div class="container">

        <br>

        <h2>Registrar transportista</h2>

        <div class="col-md-5">

            <?php if (isset($_GET['mensaje'])) { ?>

                <div class="alert alert-danger" role="alert">
                    <?php echo $_GET['mensaje']; ?>
                </div>
                
            <?php } ?>

            <form action="../../controlador/controladorEncargado.php?accion=registrarTransportista" method="POST" 
                  enctype="multipart/form-data">
                       
                <!-- CEDULA TRANSPORTISTA -->
                <label for="cedula_transportista">Cédula</label>
                <input id="cedula_transportista" class="form-control" 
                       type="text" name="cedula" placeholder="Ingrese la cédula" minlength="8" maxlength="8" 
                       title="Sin puntos ni guiones" pattern="[1-9]{1}[0-9]{7}" required>

                <!-- NOMBRE -->
                <label for="nombre">Nombre</label>
                <input id="nombre" class="form-control" 
                       type="text" name="nombre" placeholder="Ingrese el nombre" maxlength="40" required>

                <!-- APELLIDO -->
                <label for="apellido">Apellido</label>
                <input id="apellido" class="form-control" 
                       type="text" name="apellido" placeholder="Ingrese el apellido" maxlength="40" required>

                <!-- DIRECCION -->
                <label for="direccion">Dirección</label>
                <input id="direccion" class="form-control" 
                       type="text" name="direccion" placeholder="Ingrese la dirección" maxlength="55" required>

                <!-- TELEFONO -->
                <label for="telefono">Teléfono</label>
                <input id="telefono" class="form-control"
                       type="tel" name="telefono" placeholder="Ingrese el teléfono" maxlength="20" required>

                <!-- FOTO -->
                <label for="foto">Foto</label>
                <input id="foto" class="form-control-file"
                       type="file" class="input-group-prepend" name="foto" accept="image/*" required
                       title="No es necesario poner una foto si el transportista ya tiene una">

                <!-- PIN -->
                <label for="pin">PIN</label>
                <input id="pin" class="form-control"
                       type="password" minlength="6" maxlength="6" id="pin" name="pin" placeholder="Ingrese el PIN" 
                       title="Alfanumerico y seis caracteres" pattern="[0-9a-zA-Z]{6}" required>

                <br>

                <!-- BOTON REGISTRAR -->
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" name="registrarTransportista" value="Registrar">
                </div>
                        
            </form>
        
        </div>

    </div>

</body>

</html>