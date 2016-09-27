<?php

  function conectar() {
    $servidor = "localhost";
    $usuario = "root";
    $baseDeDatos ="dbcalifparciales";

    $conexion = mysql_connect($servidor, $usuario);

    mysql_select_db($baseDeDatos) or die('No ha sido posible realizar la conexión.');

    return $conexion;
  }

  function desconectar() {
    mysql_close();
  }