<?php

class ManejadorVisitante extends Conexion
{
    /* esta funcion retorna un paquete de la base de datos, según el código del paquete ingresado */
    public function buscarPaquete($codigoPaquete)
    {
        $sentencia = "SELECT * FROM paquete
                      WHERE codigo = '$codigoPaquete'
                      AND estado_paquete != 'eliminado'";

        $this->conexionServidor();
        $this->conexionBaseDatos();
        $resultado = $this->ejecutarSentencia($sentencia);
        $this->cerrarConexion();

        $cantidadFilas = mysqli_num_rows($resultado);

        if ($cantidadFilas >= 1) // SI EXISTE UN PAQUETE CON ESE CÓDIGO
        {
            $fila = mysqli_fetch_assoc($resultado);

            // CREAMOS UN PAQUETE PARA ALMACENAR LA INFOMACIÓN
            $paqueteBuscado = new Paquete;

            $paqueteBuscado->direccionEnvio = $fila['direccion_envio'];
            $paqueteBuscado->fechaEstimadaEntrega = $fila['fecha_estimada_entrega'];
            $paqueteBuscado->estadoPaquete = $fila['estado_paquete'];
            $paqueteBuscado->fechaEntrega = $fila['fecha_entrega'];

            // RETORNAMOS EL PAQUETE CON LA INFORMACIÓN
            return $paqueteBuscado;
        }
        else // SI NO HAY NINGUN PAQUETE CON ESE CODIGO
        {
            // RETORNAMOS NULL
            return null;
        }
    }
}

?>