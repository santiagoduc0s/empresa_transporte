<?php

require_once "../../modelo/Conexion.php";
require_once "../../modelo/Usuario.php";
require_once "../../modelo/Encargado.php";
require_once "../../modelo/Transportista.php";
require_once "../../manejador/ManejadorEncargado.php";

require_once '../autenticadorSesion.php';
require_once 'autenticarEncargado.php';

require_once 'diseñoEncargado.php';

// SI NO HAY UNA CEDULA SELECIONADA, NO SE PUEDE ENTAR A ESTA VISTA
if (!isset($_GET['cedulaTransportista'])) 
{
	header('Location: homeEncargado.php');
	die();
}

$cedulaTransportista = $_GET['cedulaTransportista'];

$manejadorEncargado = new ManejadorEncargado;

// DATOS DEL TRANSPORTISTA SELECIONADO
$transportistaParaModificar = $manejadorEncargado->transportistaParaModificar($cedulaTransportista);

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title>Modificar transportista - Encargado</title>
</head>

<body>

	<div class="container">

		<br>

		<h2>Modificar transportista</h2>

		<div class="col-md-5">

			<?php if (isset($_GET['mensaje'])) { ?>

				<div class="alert alert-danger" role="alert">
					<?php echo $_GET['mensaje']; ?>
				</div>

			<?php } ?>

			<form action="../../controlador/controladorEncargado.php?accion=modificarTransportista" method="POST" enctype="multipart/form-data">

				<!-- CEDULA TRANSPORTISTA NUEVA -->
				<label for="cedula_transportista">Cédula</label>
				<input id="cedula_transportista" class="form-control" type="text" name="cedulaTransportistaNueva" placeholder="Cédula" minlength="8" maxlength="8" title="Sin puntos ni guiones" pattern="[1-9]{1}[0-9]{7}" required value="<?php echo $transportistaParaModificar->cedula; ?>">

				<!-- CEDULA TRANSPORTISTA VIEJA -->
				<input type="hidden" name="cedulaTransportistaVieja" value="<?php echo $transportistaParaModificar->cedula; ?>">

				<!-- NOMBRE -->
				<label for="nombre">Nombre</label>
				<input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre" maxlength="40" required value="<?php echo ucwords($transportistaParaModificar->nombre); ?>">

				<!-- APELLIDO -->
				<label for="apellido">Apellido</label>
				<input id="apellido" class="form-control" type="text" name="apellido" placeholder="Apellido" maxlength="40" value="<?php echo ucwords($transportistaParaModificar->apellido); ?>">

				<!-- DIRECCION -->
				<label for="direccion">Dirección</label>
				<input id="direccion" class="form-control" type="text" name="direccion" placeholder="Dirección" maxlength="55" required value="<?php echo ucwords($transportistaParaModificar->direccion); ?>">

				<!-- TELEFONO -->
				<label for="telefono">Teléfono</label>
				<input id="telefono" class="form-control" type="tel" name="telefono" placeholder="Teléfono" maxlength="20" required value="<?php echo $transportistaParaModificar->telefono; ?>">

				<!-- FOTO -->
				<label for="foto">Foto</label>
				<input id="foto" class="form-control-file" type="file" name="foto" accept="image/*">

				<!-- PIN -->
				<label for="pin">PIN</label>
				<input id="pin" class="form-control" type="password" name="pin" minlength="6" maxlength="6" placeholder="PIN" title="Alfanumerico y seis caracteres" pattern="[0-9a-zA-Z]{6}" required>

				<br>

				<!-- BOTON REGISTRAR -->
				<div class="form-group">
					<input class="btn btn-primary" type="submit" name="modificarTransportista" value="Modificar">
				</div>

			</form>

		</div>

	</div>

</body>

</html>