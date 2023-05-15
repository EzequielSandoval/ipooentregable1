<?php
class Pasajeros
{
    // registra almacena y representa informacion de pasajeros de un viaje 
    private $nombre;
    private $apellido;
    private $dni;
    private $telefono;
    private $numAsiento;
    private $numTicket;
    private $incremento;
    // metodo constructor
    public function __construct($nombre, $apellido, $dni, $telefono, $numAsiento, $numTicket, $incremento)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
        $this->telefono = $telefono;
        $this->numAsiento = $numAsiento;
        $this->numTicket = $numTicket;
        $this->incremento = $incremento;
    }

    // Funciones de retorno

    public function get_nombre()
    {
        return $this->nombre;
    }
    public function get_apellido()
    {
        return $this->apellido;
    }
    public function get_dni()
    {
        return $this->dni;
    }

    public function get_telefono()
    {
        return $this->telefono;
    }

    // funciones de seteo de datos

    public function set_nombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function set_apellido($apellido)
    {
        $this->apellido = $apellido;
    }
    public function set_dni($dni)
    {
        $this->dni = $dni;
    }
    public function set_telefono($telefono)
    {
        $this->telefono = $telefono;
    }


    public function get_numAsiento()
    {
        return $this->numAsiento;
    }

    public function set_numAsiento($numAsiento)
    {
        $this->numAsiento = $numAsiento;
    }



    public function get_numTicket()
    {
        return $this->numTicket;
    }

    public function set_numTicket($numTicket)
    {
        $this->numTicket = $numTicket;
    }

    public function set_incremento($incremento)
    {
        $this->incremento = $incremento;
    }


    public function darPorcentajeIncremento()
    {
        return $this->incremento;
    }


    // Retorno de datos por pantalla
    public function __toString()
    {
        $datosPasajero = "NOMBRE: " . $this->get_nombre() . "\n" .
            "APELLIDO: " . $this->get_apellido()  . "\n" .
            "DNI: " . $this->get_dni() . "\n" .
            "TELEFONO: " . $this->get_telefono() . "\n";
        "N Asiento: " . $this->get_numAsiento() . "\n" .
            "N Ticket: " . $this->get_numTicket() . "\n";
        "Incremento: " . $this->darPorcentajeIncremento() . "\n";
        return $datosPasajero;
    }
}
