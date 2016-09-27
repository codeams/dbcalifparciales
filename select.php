<?php

  require "connect.php";

  $conexion = conectar();

  $query = 'SELECT nombrealumno, matricula, carrera FROM alumnos WHERE id=2';

  $respuesta = mysql_query( $query, $conexion );
  
  if(! $respuesta ) {
    die('No se ha podido obtener los datos: ' . mysql_error());
  }
  else while ($fila = mysql_fetch_assoc($respuesta)) {
    echo '<div>Alumno: ' . $fila['nombrealumno'] . '</div><div>Matrícula: ' . $fila['matricula'] . '</div>';
  }

  desconectar();