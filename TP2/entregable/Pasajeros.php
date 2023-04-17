<?php
class Pasajeros
{
    // registra almacena y representa informacion de pasajeros de un viaje 
    private $nombre;
    private $apellido;
    private $dni;
    private $telefono;


    // metodo constructor
    public function __construct($nombre, $apellido, $dni, $telefono)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
        $this->telefono = $telefono;
    }



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


    public function __toString()
    {
        $datosPasajero = "NOMBRE: " . $this->get_nombre() . "\n" .
            "APELLIDO: " . $this->get_apellido()  . "\n" .
            "DNI: " . $this->get_dni() . "\n" .
            "TELEFONO: " . $this->get_telefono() . "\n";
        return $datosPasajero;
    }
}
