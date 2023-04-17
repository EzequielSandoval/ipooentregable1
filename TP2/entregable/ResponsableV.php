<?php
class ResponsableV
{
    private $nombreResponsable;
    private $apellidoResponsable;
    private $numeroEmpleado;
    private $numeroLicencia;


    public function __construct($nombreResponsable, $apellidoResponsable, $numeroEmpleado, $numeroLicencia)
    {
        $this->nombreResponsable = $nombreResponsable;
        $this->apellidoResponsable = $apellidoResponsable;
        $this->numeroEmpleado = $numeroEmpleado;
        $this->numeroLicencia = $numeroLicencia;
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

    public function __toString()
    {
        $datosResponsable = "Numero empleado: " . $this->get_numeroEmpleado() . "\n" .
            "Numero licencia: " . $this->get_numeroLicencia() . "\n" .
            "Nombre: " . $this->get_nombreResponsable() . "\n" .
            "Apellido: " . $this->get_apellidoResponsable() . "\n";
        return $datosResponsable;
    }
}
