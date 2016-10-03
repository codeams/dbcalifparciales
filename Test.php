<?php
  require 'DataBase.php';

  $db = new DataBase( 'dbcalifparciales' );
  $db->connect( 'root' );

  # Seleccionar:
  #$respuesta = $db->seleccionar("alumnos", ["id", "nombrealumno", "correoe"], ["id" => 2]);

  # Agregar:
  # $columnas = ["id", "matricula", "nombrealumno", "carrera", "correoe", "direccion", "colonia", "cpostal", "telefono", "fingresoalum", "pwdalumno"];
  # $valores = [1, 00110811, "Alumno1", "LIS", "jcdm2207@hotmail.com", "DireccionA1", "colonia1", "97111", "9991223344", "2000-08-01", "pwdalum01"];
  # $respuesta = $db->insertar( "alumnos", $columnas, $valores );

  # Eliminar:
  #$respuesta = $db->eliminar("alumnos", ['id' => 1, 'cpostal' => '97111']);

  $QueryOutput = $db->selectRows( 'alumnos', ['carrera', 'nombrealumno'], 'id = 4' );

  if (! $QueryOutput['success'] ) die( 'MySQL error: ' . $db->getErrorMessage() );

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
      <?php
        foreach ( $QueryOutput['selectedRows'] as $row ) {

          $indexAttributes = 0;

          foreach ( $row as $attribute => $attributeValue ) {

            if ( $indexAttributes > 0 ) echo ', ';

            echo "<span>$attribute = $attributeValue</span>";
            $indexAttributes++;

          }

          echo '<br>';

        }
      ?>
    </div>
  </body>
</html>
