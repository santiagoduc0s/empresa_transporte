<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">

	<title>Ingreso al Sistema - Usuario</title>

	<link rel="icon" href="iconoEmpresa.ico">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<style>

		.abs-center {
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh;
		}

		.form {
			width: 450px;
		}
		
	</style>

</head>

<body>

	<div class="container">

		<div class="abs-center">

			<div class="form-group">

				<h2>Iniciar sesión</h2>

				<form action="../controlador/controladorLogin.php" method="POST" class="border p-3 form">

					<!-- MENSAJE DE ERROR -->
					<?php if (isset($_GET['mensaje'])) { ?>

						<div class="alert alert-danger" role="alert">

							<?php echo $_GET['mensaje']; ?>

						</div>

					<?php } ?>

					<!-- CEDULA -->
					<div class="form-group">
						<label for="cedula_usuario">Cédula</label>
						<input class="form-control" id="cedula_usuario" type="text" name="cedula" placeholder="Ingrese su Cedula" maxlength="8" minlength="8" title="Sin puntos ni guiones" pattern="[1-9]{1}[0-9]{7}" required>
					</div>

					<!-- PIN -->
					<div class="form-group">
						<label for="pin_transportista">Pin</label>
						<input class="form-control" id="pin_transportista" type="password" name="pin" placeholder="Ingrese su PIN" maxlength="6" minlength="6" title="Alfanumérico y seis dígitos" pattern="[0-9a-zA-Z]{6}" required>
					</div>

					<!-- TIPO DE USUARIO -->
					<div class="form-group">
						<label for="tipo_usuario">Tipo de usuario</label>
						<select class="form-control" id="estado" name="tipoUsuario">
							<option value="transportista">Transportista</option>
							<option value="encargado">Encargado</option>
						</select>
					</div>

					<!-- BOTON DE LOGIN -->
					<input class="btn btn-warning" type="submit" name="login" value="Ingresar">

				</form>

			</div>

		</div>

	</div>

</body>

</html>