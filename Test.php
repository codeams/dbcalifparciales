<?php
  require "DataBase.php";

  $db = new DataBase("dbcalifparciales");
  $db->conectar();
  $respuesta = $db->seleccionar("alumnos", ["id", "nombrealumno", "correoe"], ["id" => 2]);
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
      <span class='label'>Resultado: </span>
      <span class='answer'><?php echo $respuesta; ?></span>
    </div>
  </body>
</html>
<?php
