<?php
include_once "Pasajeros.php";
class PasajeroEspecial extends Pasajeros
{

    private $necesidadEspecial;
    private $sillaRuedas;
    private $asistencia;
    private $comidaEspecial;

    public function __construct($nombre, $apellido, $dni, $telefono, $numAsiento, $numTicket, $necesidadEspecial, $sillaRuedas, $asistencia, $comidaEspecial, $incremento)
    {
        // invocacion al constructor padre 
        parent::__construct($nombre, $apellido, $dni, $telefono, $numAsiento, $numTicket, $incremento);
        // nuevos atributos 

        $this->necesidadEspecial = $necesidadEspecial;
        $this->sillaRuedas = $sillaRuedas;
        $this->asistencia = $asistencia;
        $this->comidaEspecial = $comidaEspecial;
    }

    public function get_necesidadEspecial()
    {
        return $this->necesidadEspecial;
    }
    public function set_necesidadEspecial($necesidadEspecial)
    {
        $this->necesidadEspecial = $necesidadEspecial;
    }


    public function get_sillaRuedas()
    {
        return $this->sillaRuedas;
    }
    public function set_sillaRuedas($sillaRuedas)
    {
        $this->sillaRuedas = $sillaRuedas;
    }


    public function get_asistencia()
    {
        return $this->asistencia;
    }
    public function set_asistencia($asistencia)
    {
        $this->asistencia = $asistencia;
    }


    public function get_comidaEspecial()
    {
        return $this->comidaEspecial;
    }
    public function set_comidaEspecial($comidaEspecial)
    {
        $this->comidaEspecial = $comidaEspecial;
    }


    public function darPorcentajeIncremento()
    {
        $necEsp = $this->get_necesidadEspecial();
        $sillaRuedas = $this->get_sillaRuedas();
        $asistencia = $this->get_asistencia();
        $comidaEspecial = $this->get_comidaEspecial();
        if ($necEsp == true && $sillaRuedas == true && $asistencia == true && $comidaEspecial == true) {
            $this->set_incremento(0.30);
        } elseif ($necEsp == true || $sillaRuedas == true || $asistencia == true || $comidaEspecial == true) {
            $this->set_incremento(0.15);
        }
        parent::darPorcentajeIncremento();
    }


    public function __toString()
    {
        $informacionPasajeroEspecial = parent::__toString();
        $informacionPasajeroEspecial .= "NECESIDAD ESPECIAL: " . $this->get_necesidadEspecial() . "\n" .
            "SILLA DE RUEDAS: " . $this->get_sillaRuedas() . "\n" .
            "ASISTENCIA: " . $this->get_asistencia() . "\n" .
            "COMIDA ESPECIAL: " . $this->get_comidaEspecial() . "\n";
        return $informacionPasajeroEspecial;
    }
}
