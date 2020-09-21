<?php

if (isset($_GET['terminarSesion'])) // SI SE APRETO EN EL BOTÓN SALIR
{
    // BORRAMOS LA COOKIE
    setcookie('tiempoDeSesion', false, time() - 1, '/');

    // DESTRUIMOS LA SESION
    session_start();
    session_destroy();

    // REDIRECCIONAMOS AL LOGIN
    header("Location: ../vista/loginUsuario.php");
}
else // SI SE INTENTA INGRESAR A ESTA PAGINA DESDE LA URL
{
    // REDIRECCIONAMOS AL LOGIN USUARIO
    header("Location: ../vista/formularioLogin.php");
}

?>
