<?php
  require 'DataBase.php';

  $db = new DataBase('dbcalifparciales');
  $db->conectar();

  # Seleccionar:
  #$respuesta = $db->seleccionar("alumnos", ["id", "nombrealumno", "correoe"], ["id" => 2]);

  # Agregar:
  # $columnas = ["id", "matricula", "nombrealumno", "carrera", "correoe", "direccion", "colonia", "cpostal", "telefono", "fingresoalum", "pwdalumno"];
  # $valores = [1, 00110811, "Alumno1", "LIS", "jcdm2207@hotmail.com", "DireccionA1", "colonia1", "97111", "9991223344", "2000-08-01", "pwdalum01"];
  # $respuesta = $db->insertar( "alumnos", $columnas, $valores );

  # Eliminar:
  #$respuesta = $db->eliminar("alumnos", ['id' => 1, 'cpostal' => '97111']);

  $respuesta = $db->seleccionar('alumnos', ['id'], ['id'=>4]);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <title>dbcalifparciales</title>
    <link rel='stylesheet' href='/css/master.css' media='screen' title='no title'>
  </head>
  <body>
    <div>
      <span class='answer'><?php echo $respuesta; ?></span>
    </div>
  </body>
</html>
<?php
