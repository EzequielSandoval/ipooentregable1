<?php
include_once "Pasajeros.php";
class PasajeroVip extends Pasajeros
{
    private $numViajeFrecuente;
    private $cantMillas;

    // Constructor de la clase PasajeroVip
    public function __construct($nombre, $apellido, $dni, $telefono, $numAsiento, $numTicket, $numViajeFrecuente, $cantMillas, $incremento)
    {
        // Invocacion al constructor padre
        parent::__construct($nombre, $apellido, $dni, $telefono, $numAsiento, $numTicket, $incremento);
        //se agregan los nuevo atributos
        $this->numViajeFrecuente = $numViajeFrecuente;
        $this->cantMillas = $cantMillas;
    }

    public function get_numViajeFrecuente()
    {
        return $this->numViajeFrecuente;
    }

    public function set_numViajeFrecuente($numViajeFrecuente)
    {
        $this->numViajeFrecuente = $numViajeFrecuente;
    }


    public function get_cantMillas()
    {
        return $this->cantMillas;
    }
    public function set_cantMillas($cantMillas)
    {
        $this->cantMillas = $cantMillas;
    }

    public function darPorcentajeIncremento()
    {
        $cantidadMillas = $this->get_cantMillas();

        if ($cantidadMillas > 300) {
            $this->set_incremento(0.3);
        } else {
            $this->set_incremento(0.35);
        }
        parent::darPorcentajeIncremento();
    }

    public function __toString()
    {
        $informacionVip = parent::__toString();
        $informacionVip .= "Num Viajero Frecuente: " . $this->get_numViajeFrecuente() . "\n" .
            "Cantidad millas acumuladas" . $this->get_cantMillas() . "\n";
        return $informacionVip;
    }
}
