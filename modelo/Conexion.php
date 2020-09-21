<?php

abstract class Conexion
{
    const SERVIDOR = "localhost";
    const USUARIO = "root";
    const CONTRASEÑA = "0209";
    const BD = "empresa_transporte";

    protected $conexion;

    protected function conexionServidor($servidor = self::SERVIDOR, $usuario = self::USUARIO, $contraseña = self::CONTRASEÑA)
    {
        $this->conexion = mysqli_connect($servidor, $usuario, $contraseña) or die("Conexion.php - __construct(): <br>" . mysqli_errno($this->conexion = mysqli_connect($servidor, $usuario, $contraseña)));
    }

    protected function conexionBaseDatos($nombreBaseDatos = self::BD)
    {
        mysqli_select_db($this->conexion, $nombreBaseDatos) or die("Conexion.php - conexionBaseDatos(): <br>" . mysqli_error($this->conexion));
    }

    protected function ejecutarSentencia($sentencia)
    {
        $resultado = mysqli_query($this->conexion, $sentencia) or die("Conexion.php - ejecutarSentecia(): <br>" . mysqli_error($this->conexion));
        return $resultado;
    }

    protected function cerrarConexion()
    {
        mysqli_close($this->conexion) or die("Conexion.php - cerrarConexion(): <br>" . mysqli_error($this->conexion));
    }
}

?>