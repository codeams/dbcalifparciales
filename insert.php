<?php

  require "connect.php";

  $conexion = conectar();

  $query = 'INSERT INTO alumnos (id, matricula, nombrealumno, carrera, correoe, direccion, colonia, cpostal, telefono, fingresoalum, pwdalumno) VALUES (1, 00110811, "Alumno1", "LIS", "jcdm2207@hotmail.com", "DirecciónA1", "colonia1", "97111", "9991223344", "2000-08-01", "pwdalum01")';

  $respuesta = mysql_query( $query, $conexion );
  
  if(! $respuesta ) {
    die('No se ha podido insertar los datos: ' . mysql_error());
  }
  else echo "Los datos han sido insertados con éxito.";

  desconectar();