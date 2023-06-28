<?php
class Empresa
{
    private $idEmpresa;
    private $eNombre;
    private $eDireccion;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->idEmpresa = '';
        $this->eNombre = '';
        $this->eDireccion = '';
        $this->mensajeOperacion = '';
    }
    public function cargar($idEmp, $nombreEmp, $direccionEmp)
    {
        $this->set_idEmpresa($idEmp);
        $this->set_nombre($nombreEmp);
        $this->set_direccion($direccionEmp);
    }
    public function get_idEmpresa()
    {
        return $this->idEmpresa;
    }
    public function set_idEmpresa($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;
    }

    public function get_nombre()
    {
        return $this->eNombre;
    }
    public function set_nombre($eNombre)
    {
        $this->eNombre = $eNombre;
    }

    public function get_direccion()
    {
        return $this->eDireccion;
    }
    public function set_direccion($eDireccion)
    {
        $this->eDireccion = $eDireccion;
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
     * Recupera los datos de uan empresa usando el id
     * @param int $idEmpresa
     * @return true en caso de encontrar los datos, false en caso contrario 
     */
    public function Buscar($idEmpresa)
    {
        $base = new BaseDatos();
        $consultaEmpresa = "Select * from empresa where idempresa=" . $idEmpresa;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEmpresa)) {
                if ($row = $base->Registro()) {

                    $this->cargar($idEmpresa, $row['enombre'], $row['edireccion']);
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



    public function insertarEmpresa()
    {
        $base = new BaseDatos();
        $resp = false;

        $idEmpresa = $this->get_idEmpresa();
        $eNombre = $this->get_nombre();
        $eDireccion = $this->get_direccion();

        $consultaInsertarEmpresa = "INSERT INTO empresa (idempresa, enombre, edireccion) 
                                    VALUES ('$idEmpresa', '$eNombre', '$eDireccion')";
        // si se inicia correctamente la base de datos
        if ($base->Iniciar()) {
            // pasa la consulta al metodo y se ejecuta, si se ejecuta exitosamente retorna true
            if ($id = $base->devuelveIDInsercion($consultaInsertarEmpresa)) {
                $this->set_idEmpresa($id);
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

    public function listarEmpresas($condicion = "")
    {
        $arrayEmpresa = null;
        $base = new BaseDatos();
        $conusultaEmpresas = "SELECT * FROM empresa";
        if ($condicion != "") {
            $conusultaEmpresas = $conusultaEmpresas . ' WHERE ' . $condicion;
        }
        $conusultaEmpresas .= " order by enombre";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($conusultaEmpresas)) {
                $arrayEmpresa = [];
                while ($row = $base->Registro()) {
                    $idEmpresa = $row['idempresa'];
                    $nombre =  $row['enombre'];
                    $direccion = $row['edireccion'];

                    $empresa = new Empresa();
                    $empresa->cargar($idEmpresa, $nombre, $direccion);
                    array_push($arrayEmpresa, $empresa);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arrayEmpresa;
    }

    public function modificarEmpresa()
    {
        $resp = false;
        $base = new BaseDatos();

        $nombreEmpresa = $this->get_nombre();
        $direccionEmpresa = $this->get_direccion();
        $idEmpresa = $this->get_idEmpresa();

        $conusultaModificacionEmpresa  = "UPDATE empresa SET 
                                            edireccion= '$direccionEmpresa', 
                                            enombre='$nombreEmpresa' 
                                            WHERE idempresa='$idEmpresa'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($conusultaModificacionEmpresa)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }


    public function eliminarEmpresa()
    {
        $base = new BaseDatos();
        $resp = false;
        $idEmpresa = $this->get_idEmpresa();
        $consultaEliminarEmpresa = "DELETE FROM empresa WHERE idempresa = '$idEmpresa'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEliminarEmpresa)) {
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
        $informacionEmpresa =
            "ID EMPRESA: " . $this->get_idEmpresa() . "\n" .
            "NOMBRE: " . $this->get_nombre() . "\n" .
            "DIRECCION: " . $this->get_direccion() . "\n";

        return $informacionEmpresa;
    }
}
