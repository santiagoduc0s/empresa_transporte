<!DOCTYPE html>
<html lang="es">

<head>

	<meta charset="utf-8">

	<link rel="icon" href="../iconoEmpresa.ico">

	<!-- HOJAS DE ESTILO -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<!-- JS -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

</head>

<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

		<div class="collapse navbar-collapse" id="navbarSupportedContent">

			<ul class="navbar-nav mr-auto">

				<!-- HOME -->
				<li class="nav-item">
					<a class="nav-link" href="homeTransportista.php" tabindex="-1" aria-disabled="true">Home</a>
				</li>

				<!-- HISTORIAL -->
				<li class="nav-item">
					<a class="nav-link" href="historialTransportista.php" tabindex="-1" aria-disabled="true">Historial</a>
				</li>

				<!-- SELECCIONAR PAQUETE -->
				<li class="nav-item">
					<a class="nav-link" href="asignarPaqueteTransportista.php" tabindex="-1" aria-disabled="true">Seleccionar paquete</a>
				</li>

			</ul>

			<ul class="nav navbar-nav navbar-right">

				<!-- NOMBRE TRANSPORTISTA -->
				<li class="nav-item">
					<?php
					$transportistaSesion = $_SESSION['usuario'];
					echo ucwords($transportistaSesion->nombre);
					?>
				</li>

			</ul>

			<ul class="nav navbar-nav navbar-right">

				<!-- BOTON CERRAR SESION (DE LA BARRA DE NAVEGACION) -->
				<li>
					<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Cerrar Sesion</a>
				</li>

			</ul>

		</div>

	</nav>

	<!-- PANTALLA DE CERRAR SESION -->
	<div class="modal" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">

		<div class="modal-dialog modal-sm">

			<div class="modal-content">

				<div class="modal-header">

					<h4>Salir</h4>

				</div>

				<div class="modal-body">

					<p>Esta seguro de Abandonar la Session</p>

					<div class="actionsBtns">

						<!-- CERRAR SESION -->
						<a href="../../controlador/controladorLogout.php?terminarSesion=terminarSesion" class="btn btn-danger">Salir</a>

						<button class="btn btn-default" data-dismiss="modal">Cancelar</button>

					</div>

				</div>

			</div>

		</div>

	</div>

</body>

</html>