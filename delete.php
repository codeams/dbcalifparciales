<?php
  
  require "connect.php";

  $conexion = conectar();

  $query = 'DELETE FROM alumnos WHERE id=1';

  $respuesta = mysql_query( $query, $conexion );
  
  if(! $respuesta ) {
    die('No se ha podido eliminar los datos: ' . mysql_error());
  }
  else echo 'Se han eliminado los datos con exito.';

  desconectar();