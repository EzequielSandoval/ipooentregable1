
<?php

// use Viaje as GlobalViaje;

class Viaje
{
    private $idViaje;
    private $vDestino;
    private $vCantMaxPasajeros;
    private $empresa;
    private $vImporte;
    private $colPasajeros;
    private $responsable;
    private $mensajeOperacion;


    public function __construct()
    {

        $this->idViaje = '';
        $this->vDestino = '';
        $this->vCantMaxPasajeros = '';
        $this->vImporte =  '';
        $this->mensajeOperacion = '';
        $this->colPasajeros  = [];
    }
    // $emp, $respV, $colPasajeros
    public function cargar($id, $destino, $cantMaxP, $importe, $emp, $respV)
    {
        $this->set_idViaje($id);
        $this->set_destino($destino);
        $this->set_cantMaxPasajeros($cantMaxP);
        $this->set_importe($importe);
        $this->set_empresa($emp);
        $this->set_responsable($respV);
        // $this->set_colPasajeros($colPasajeros);
    }

    public function get_idViaje()
    {
        return $this->idViaje;
    }
    public function set_idViaje($idViaje)
    {
        $this->idViaje = $idViaje;
    }
    public function get_destino()
    {
        return $this->vDestino;
    }
    public function get_cantMaxPasajeros()
    {
        return $this->vCantMaxPasajeros;
    }

    public function get_empresa()
    {
        return $this->empresa;
    }
    public function get_importe()
    {
        return $this->vImporte;
    }
    public function get_colPasajeros()
    {
        return $this->colPasajeros;
    }
    public function get_responsable()
    {
        return $this->responsable;
    }
    public function getmensajeoperacion()
    {
        return $this->mensajeOperacion;
    }



    public function set_destino($vDestino)
    {
        $this->vDestino = $vDestino;
    }
    public function set_cantMaxPasajeros($vCantMaxPasajeros)
    {
        $this->vCantMaxPasajeros = $vCantMaxPasajeros;
    }
    public function set_colPasajeros($colPasajeros)
    {
        $this->colPasajeros = $colPasajeros;
    }
    public function set_responsable($responsable)
    {
        $this->responsable = $responsable;
    }
    public function set_empresa($empresa)
    {
        $this->empresa = $empresa;
    }

    public function set_importe($vImporte)
    {
        $this->vImporte = $vImporte;
    }



    public function verColeccionPasajeros()
    {
        $coleccion = $this->get_colPasajeros();
        $stringCol = "";
        for ($i = 0; $i < count($coleccion); $i++) {
            $stringCol .= $coleccion[$i];
        }
        return $stringCol;
    }


    public function setmensajeoperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }




    /**
     * Recupera los datos de un viaje por medio de la id
     * @param int $numeroEmpleado
     * @return true en caso de encontrar los datos, false en caso contrario 
     */
    public function BuscarViaje($idViaje)
    {
        $base = new BaseDatos();
        $consultaViaje = "Select * from viaje where idviaje=" . $idViaje;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViaje)) {
                if ($row = $base->Registro()) {



                    $empresa = new Empresa();
                    $empresa->Buscar($row['idempresa']);

                    $responsable = new ResponsableV();
                    $responsable->Buscar($row['rnumeroempleado']);

                    $this->cargar($idViaje, $row['vdestino'], $row['vcantmaxpasajeros'], $row['vimporte'], $empresa, $responsable);
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




    public function insertarViaje()
    {
        $base = new BaseDatos();
        $resp = false;


        $destino = $this->get_destino();
        $cantMaxP = $this->get_cantMaxPasajeros();
        $importe = $this->get_importe();
        $idEmpresa = $this->get_empresa()->get_idEmpresa();
        $numeroEmpleado = $this->get_responsable()->get_numeroEmpleado();




        $consultaInsertarViaje = "INSERT INTO viaje (vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte) 
                                    VALUES ('$destino', '$cantMaxP', '$idEmpresa', '$numeroEmpleado', '$importe')";
        // si se inicia correctamente la base de datos
        if ($base->Iniciar()) {
            // pasa la consulta al metodo y se ejecuta, si se ejecuta exitosamente retorna true
            if ($id = $base->devuelveIDInsercion($consultaInsertarViaje)) {
                $this->set_idViaje($id);
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

    public function listarViajes($condicion = "")
    {
        $arrayViajes = null;
        $base = new BaseDatos();
        $consultaViaje = "SELECT * FROM viaje";
        if ($condicion != "") {
            $consultaViaje = $consultaViaje . ' WHERE ' . $condicion;
        }
        $consultaViaje .= " order by vdestino";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViaje)) {
                $arrayViajes = [];
                while ($row = $base->Registro()) {
                    $idViaje = $row['idviaje'];
                    $destino = $row['vdestino'];
                    $cantidadMaxPasajeros = $row['vcantmaxpasajeros'];
                    $importe = $row['vimporte'];

                    $idEmpresa = $row['idempresa'];
                    $empresa = new Empresa();
                    $empresa->Buscar($idEmpresa);

                    $numeroEmpleado = $row['rnumeroempleado'];
                    $responsable = new ResponsableV();
                    $responsable->Buscar($numeroEmpleado);

                    $viaje = new Viaje();
                    $pasajeros = new Pasajeros();

                    $colPasajeros = $pasajeros->listarPasajeros("idviaje='" . $idViaje . "'");

                    // $empresa, $responsable, $colPasajeros
                    $viaje->cargar($idViaje, $destino, $cantidadMaxPasajeros, $importe, $empresa, $responsable);
                    $viaje->set_colPasajeros($colPasajeros);
                    array_push($arrayViajes, $viaje);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arrayViajes;
    }

    public function modificarViaje()
    {
        $resp = false;
        $base = new BaseDatos();

        $idViaje = $this->get_idViaje();
        $destino = $this->get_destino();
        $cantidadMax = $this->get_cantMaxPasajeros();
        $importe = $this->get_importe();


        $conusultaModificacionViaje  = "UPDATE viaje SET 
                                            vdestino= '$destino', 
                                            vcantmaxpasajeros='$cantidadMax', 
                                            vimporte= '$importe' 
                                            WHERE idviaje='$idViaje'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($conusultaModificacionViaje)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }


    public function eliminarViaje()
    {
        $base = new BaseDatos();
        $resp = false;
        $idViaje = $this->get_idViaje();
        $consultaEliminarViaje = "DELETE FROM viaje WHERE idviaje = '$idViaje'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEliminarViaje)) {
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
        $informacionViaje =

            "ID VIAJE: " . $this->get_idViaje() . "\n" .
            "DESTINO: " . $this->get_destino() . "\n" .
            "CANTIDAD MAXIMA PASAJEROS: " . $this->get_cantMaxPasajeros() . "\n" .
            "IMPORTE: " . $this->get_importe() . "\n";
        return $informacionViaje;
    }
}
