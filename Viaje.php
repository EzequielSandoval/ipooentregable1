<?php
class Viaje
{
    // Registra almacena y representa informacion referencia a viajes 
    // atributos: 
    private $codigoViaje;
    private $destinoViaje;
    private $cantMaxPasajeros;
    private $pasajeros = [];



    public function __construct($codigoViaje, $destinoViaje, $cantMaxPasajeros, $pasajeros)
    // Metodo constructor 
    {
        $this->codigoViaje = $codigoViaje;
        $this->destinoViaje = $destinoViaje;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
        $this->pasajeros = $pasajeros;
    }

    // retorna el codigo del viaje
    public function getCodigoViaje()
    {
        return $this->codigoViaje;
    }
    // retorna el destino del viaje
    public function getDestinoViaje()
    {
        return $this->destinoViaje;
    }
    // retorna el maximo de pasajeros del viaje
    public function getMaxPasajeros()
    {
        return $this->cantMaxPasajeros;
    }
    // retorna los datos de los pasajeros del viaje del viaje
    public function getPasajeros()
    {
        return $this->pasajeros;
    }


    // asignar el codigo del viaje  al atributo
    public function setCodigoViaje($codigoViaje)
    {
        $this->codigoViaje = $codigoViaje;
    }
    // asignar el destino del viaje al atributo
    public function setDestinoViaje($destinoViaje)
    {
        $this->destinoViaje = $destinoViaje;
    }
    // asignar el maximo de pasajeros del viaje al atributo
    public function setMaxPasajeros($cantMaxPasajeros)
    {
        $this->cantMaxPasajeros = $cantMaxPasajeros;
    }
    // asignar nuevos pasajeros
    public function setPasajeros($arrayPasajeros)
    {
        $this->pasajeros = $arrayPasajeros;
    }
    // asignar los datos de los pasajeros del viaje del viaje al atributo
    public function setDatosPasajeros($numeroPasajero, $tipoDato, $valorTipodato)
    {
        $this->pasajeros[$numeroPasajero][$tipoDato] = $valorTipodato;
    }
}
