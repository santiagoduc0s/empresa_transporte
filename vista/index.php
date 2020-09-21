<?php

if (isset($_GET['ingreso']))
{
    header("Location: {$_GET['ingreso']}");
}

?>

<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">

	<title>Ingreso al Sistema</title>
	
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

				<h2>Bienvenido</h2>

				<form action="index.php" method="GET" class="border p-3 form">

					<!-- VISITANTES -->
					<div class="form-group">
                        <label for="visitantes">Visitantes</label>
                        <button class="btn btn-success btn-lg btn-block" id="visitantes" 
                                type="submit" name="ingreso" value="visitante\mostrarPaqueteVisitante.php">Aquí</button>
					</div>

					<!-- USUARIOS -->
					<div class="form-group">
                        <label for="usuarios">Usuarios</label>
                        <button class="btn btn-warning btn-lg btn-block" id="usuarios" 
                                type="submit" name="ingreso" value="loginUsuario.php">Aquí</button>
					</div>

				</form>

			</div>

		</div>

	</div>

</body>

</html>