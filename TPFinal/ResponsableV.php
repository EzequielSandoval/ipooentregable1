<?php

// use ResponsableV as GlobalResponsableV;

class ResponsableV
{
    private $nombreResponsable;
    private $apellidoResponsable;
    private $numeroEmpleado;
    private $numeroLicencia;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->nombreResponsable = '';
        $this->apellidoResponsable = '';
        $this->numeroEmpleado = '';
        $this->numeroLicencia = '';
        $this->mensajeOperacion = '';
    }

    public function cargar($nombreR, $apellidoR, $numeroEmpR, $numeroLicenciaR)
    {
        $this->set_nombreResponsable($nombreR);
        $this->set_apellidoResponsable($apellidoR);
        $this->set_numeroEmpleado($numeroEmpR);
        $this->set_numeroLicencia($numeroLicenciaR);
    }
    public function get_nombreResponsable()
    {
        return $this->nombreResponsable;
    }
    public function get_apellidoResponsable()
    {
        return $this->apellidoResponsable;
    }
    public function get_numeroEmpleado()
    {
        return $this->numeroEmpleado;
    }
    public function get_numeroLicencia()
    {
        return $this->numeroLicencia;
    }

    public function set_nombreResponsable($nombreResponsable)
    {
        $this->nombreResponsable = $nombreResponsable;
    }
    public function set_apellidoResponsable($apellidoResponsable)
    {
        $this->apellidoResponsable = $apellidoResponsable;
    }
    public function set_numeroEmpleado($numeroEmpleado)
    {
        $this->numeroEmpleado = $numeroEmpleado;
    }
    public function set_numeroLicencia($numeroLicencia)
    {
        $this->numeroLicencia = $numeroLicencia;
    }



    public function setmensajeoperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }
    public function getmensajeoperacion()
    {
        return $this->mensajeOperacion;
    }


    /**
     * Recupera los datos de un responsable por medio de su numeroEmpleado
     * @param int $numeroEmpleado
     * @return true en caso de encontrar los datos, false en caso contrario 
     */
    public function Buscar($numeroEmpleado)
    {
        $base = new BaseDatos();
        $consultaResponsable = "Select * from responsable where rnumeroempleado=" . $numeroEmpleado;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaResponsable)) {
                if ($row = $base->Registro()) {

                    $this->cargar($row['rnombre'], $row['rapellido'], $numeroEmpleado, '');
                    $resp = true;
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }


    public function insertarResponsable()
    {
        $base = new BaseDatos();
        $resp = false;


        $numeroLicencia = $this->get_numeroLicencia();
        $nombreResponsable = $this->get_nombreResponsable();
        $apellidoResponsable = $this->get_apellidoResponsable();

        $consultaInsertarResponsable = "INSERT INTO responsable (rnombre, rapellido, rnumerolicencia) 
                                        VALUES ('$nombreResponsable', '$apellidoResponsable', '$numeroLicencia')";
        // si se inicia correctamente la base de datos
        if ($base->Iniciar()) {
            // pasa la consulta al metodo y se ejecuta, si se ejecuta exitosamente retorna true
            if ($id = $base->devuelveIDInsercion($consultaInsertarResponsable)) {
                $this->set_numeroEmpleado($id);
                $resp = true;
            } else {
                // si falla la ejecucion de la consulta el error se almacena en el metodo setmensajeoperacion
                $this->setmensajeoperacion($base->getError());
            }

        
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    public function listarResponsables($condicion = "")
    {
        $arrayResponsable = null;
        $base = new BaseDatos();
        $consultaResponsable = "SELECT * FROM responsable";
        if ($condicion != "") {
            $consultaResponsable = $consultaResponsable . ' WHERE ' . $condicion;
        }
        $consultaResponsable .= " order by rnombre";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaResponsable)) {
                $arrayResponsable = [];
                while ($row = $base->Registro()) {

                    $numeroEmpleado = $row['rnumeroempleado'];
                    $numeroLicencia = $row['rnumerolicencia'];
                    $nombre = $row['rnombre'];
                    $apellido = $row['rapellido'];
                    $responsable = new ResponsableV();
                    $responsable->cargar($nombre, $apellido, $numeroEmpleado, $numeroLicencia);
                    array_push($arrayResponsable, $responsable);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arrayResponsable;
    }

    public function modificarResponsable()
    {
        $resp = false;
        $base = new BaseDatos();



        $numeroEmpleado = $this->get_numeroEmpleado();
        $numeroLicencia = $this->get_numeroLicencia();
        $nombre = $this->get_nombreResponsable();
        $apellido = $this->get_apellidoResponsable();

        $conusultaModificacionEmpleado  = "UPDATE responsable SET 
                                            rnumerolicencia = '$numeroLicencia',
                                            rnombre = '$nombre', 
                                            rapellido = '$apellido' 
                                          WHERE rnumeroempleado='$numeroEmpleado'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($conusultaModificacionEmpleado)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }


    public function eliminarResponsable()
    {
        $base = new BaseDatos();
        $resp = false;
        $numeroEmpleado = $this->get_numeroEmpleado();

        $consultaEliminarResponsable = "DELETE FROM responsable WHERE rnumeroempleado = '$numeroEmpleado'";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEliminarResponsable)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }






    public function __toString()
    {
        $datosResponsable = "Numero empleado: " . $this->get_numeroEmpleado() . "\n" .
            "Numero licencia: " . $this->get_numeroLicencia() . "\n" .
            "Nombre: " . $this->get_nombreResponsable() . "\n" .
            "Apellido: " . $this->get_apellidoResponsable() . "\n";
        return $datosResponsable;
    }
}
