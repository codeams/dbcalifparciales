<?php

  session_start();

  if ( isset( $_SESSION['session'] ) ) $session = $_SESSION['session'];
  else header('Location: index.php');

?>
<!doctype html>
<html>
<head>

  <meta charset='utf-8'>
  <title>Agregar: estudiante</title>

  <link rel='stylesheet' href='assets/add.css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet'>

</head>
<body>

  <h1>Agregar un estudiante</h1>

  <span class='error-message'></span>

  <input type='text' class='name' name='name' placeholder='Nombres'>
  <input type='text' class='last-name' name='last-name' placeholder='Apellidos'>
  <input type='text' class='student-id' name='student-id' placeholder='Matrícula'>
  <select name='career' class='career'>
    <option value='LIS'>Carrera: LIS</option>
    <option value='LCC'>Carrera: LCC</option>
    <option value='LIC'>Carrera: LIC</option>
  </select>
  <input type='text' class='email' name='email' placeholder='Correo electrónico'>
  <input type='text' class='address' name='address' placeholder='Dirección'>
  <input type='text' class='postal-code' name='postal-code' placeholder='Código postal'>
  <input type='text' class='telephone' name='telephone' placeholder='Teléfono'>
  <input type='text' class='admission-date' name='admission-date' placeholder='Fecha de ingreso'>
  <input type='button' class='add' value='Agregar'>

  <script src='assets/jquery.min.js'></script>
  <script src='assets/add.js'></script>

</body>
</html>
