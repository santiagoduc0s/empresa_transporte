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
	<meta charset="utf-8">
	<title>Home - Transportista</title>
</head>

<body>

	<div class="container">

		<?php

		$manejadorTransportista = new ManejadorTransportista;

		// EXTRAEMOS AL TRANSPORTISTA INGRESADO EN LA SESION
		$transportistaSesion = $_SESSION['usuario'];

		// PAQUETE ASIGNADO AL TRANSPORTISTA INGRESADO
		$paqueteEnTransito = $manejadorTransportista->paqueteActivo($transportistaSesion);

		// SI EL PAQUETE EXISTE
		if (!is_null($paqueteEnTransito)) { ?>

			<br>

			<h2>Paquete activo</h2>

			<br>

			<table class="table table-success">

				<tr>
					<th>Código</th>
					<th>Dirección del remitente</th>
					<th>Dirección del envío</th>
					<th>Fecha estimada de entrega</th>
					<th>Fecha y hora de asignación</th>
					<th></th>
				</tr>

				<!-- MOSTRAMOS LOS DATOS DEL PAQUETE ASIGNADO AL TRANSPORTISTA (EN TRANSITO) -->
				<tr>
					<td><?php echo $paqueteEnTransito->codigo ?></td>
					<td><?php echo ucwords($paqueteEnTransito->direccionRemitente); ?></td>
					<td><?php echo ucwords($paqueteEnTransito->direccionEnvio); ?></td>
					<td><?php echo $paqueteEnTransito->fechaEstimadaEntrega; ?></td>
					<td><?php echo $paqueteEnTransito->fechaYHoraAsignacion; ?></td>
					<!-- LINK PARA FINALIZAR LA ENTREGA -->
					<td><a href="../../controlador/controladorTransportista?accion=finalizarEntrega&codigoPaquete=<?php echo $paqueteEnTransito->codigo; ?>">Finalizar entrega</a></td>
				</tr>

			</table>

		<?php } else { ?>

			<br>

			<h2>No tiene ningún paquete asignado</h2>

			<br>

		<?php } ?>

	</div>

</body>

</html>