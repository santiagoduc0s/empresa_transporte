<?php

$tipoUsuario = $_SESSION['usuario'];

// VERIFICAMOS QUE EL USUARIO SEA UN TRANSPORTISTA
if (!$tipoUsuario instanceof Transportista)
{
    // SI NO LO ES BORRAMOS LA SESION Y LA COOKIE
    setcookie('tiempoDeSesion', false, time() - 1, '/');
    session_destroy();
    
    // REDIRECCIONAMOS AL LOGIN
    header('Location: ../loginUsuario.php?mensaje=Ocurrió un error, vuelva a ingresar');
    die();
}

?>