<?php
  class Alumno {
    private id;
    private matricula;
    private nombre;
    private carrera;
    private correo;
    private direccion;
    private colonia;
    private codigoPostal;
    private telefono;
    private fechaIngreso;
    private contrasena;

    public function __construct($datos) {
      $this->$id = $datos['id'];
      $this->$matricula = $datos['matricula'];
      $this->$nombre = $datos['nombre'];
      $this->$carrera = $datos['carrera'];
      $this->$correo = $datos['correo'];
      $this->$direccion = $datos['direccion'];
      $this->$colonia = $datos['colonia'];
      $this->$codigoPostal = $datos['codigoPostal'];
      $this->$telefono = $datos['telefono'];
      $this->$fechaIngreso = $datos['fechaIngreso'];
      $this->$contrasena = $datos['contrasena'];
    }

    public function getId() {
      return $this->id;
    }

    public function getMatricula() {
      return $this->matricula;
    }

    public function getNombre() {
      return $this->nombre;
    }

    public function getCarrera() {
      return $this->carrera;
    }

    public function getCorreo() {
      return $this->correo;
    }

    public function getDireccion() {
      return $this->direccion;
    }

    public function getColonia() {
      return $this->colonia;
    }

    public function getCodigoPostal() {
      return $this->codigoPostal;
    }

    public function getTelefono() {
      return $this->telefono;
    }

    public function getFechaIngreso() {
      return $this->fechaIngreso;
    }

    public function getContrasena() {
      return $this->contrasena;
    }

  }