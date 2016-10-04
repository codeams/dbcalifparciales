<?php

  session_start();

  if ( isset( $_SESSION['session'] ) ) $session = $_SESSION['session'];
  else header('Location: index.php');

  $teacherId = $session['teacherId'];

  require 'DataBase.php';

  $dataBase = new DataBase( 'dbcalifparciales' );
  $dataBase->connect( 'root' );

  $classRegistrations = $dataBase->getRegistrarionsByTeacherId( $teacherId );

  $areClassRegistrarions = count( $classRegistrations ) > 0;

  if ( $areClassRegistrarions ) {
    $groupedRegistrarions = $dataBase->groupRegistrarionsBySubjects( $classRegistrations );
  } else $groupedRegistrarions = null;

?>
<!doctype html>
<html><head>

    <meta charset='utf-8'>
    <title>Tus grupos</title>

    <link rel='stylesheet' href='assets/classes.css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet'>

</head><body class='classes'>

  <div class='content-wrapper'>

    <div class='nav'>
      <div class='title'>

        <span class='welcome-text'>Bienvenido</span>
        <span class='name'><?php echo $session['name']; ?></span>

        <div class='options-panel'>
          <span class='save'>guardar</span>
          <span class='logout'>salir</span>
        </div>

      </div>
    </div>

    <?php foreach ( $groupedRegistrarions as $class ) : ?>

      <div class='class' id='<?php echo $class['clvasig']; ?>'>

        <div class='class-data'>
          <span class='class-name'><?php echo $class['clvasig']; ?></span>
          <span class='students-count'><?php echo count( $class['registrarions'] ); ?> alumnos</span>
        </div>

        <div class='registrarions'>
        <?php foreach ( $class['registrarions'] as $registrarion ) : ?>

          <div class='registrarion' id='<?php echo $registrarion['matricula']; ?>'>
            <div class='student-data'>
              <span class='student-id'><?php echo $registrarion['matricula']; ?></span>
              <span class='student-name'><?php echo $registrarion['nombrealumno']; ?></span>
            </div>
            <div class='grades'>
              <input type='text' class='partial-grade' id='<?php echo $registrarion['matricula']; ?>-cpar1' value='<?php echo $registrarion['cpar1']; ?>'>
              <input type='text' class='partial-grade' id='<?php echo $registrarion['matricula']; ?>-cpar2' value='<?php echo $registrarion['cpar2']; ?>'>
              <input type='text' class='partial-grade' id='<?php echo $registrarion['matricula']; ?>-cpar3' value='<?php echo $registrarion['cpar3']; ?>'>
              <input type='text' class='partial-grade' id='<?php echo $registrarion['matricula']; ?>-cpar4' value='<?php echo $registrarion['cpar4']; ?>'>
              <input type='text' class='partial-grade' id='<?php echo $registrarion['matricula']; ?>-cpar5' value='<?php echo $registrarion['cpar5']; ?>'>
              <input type='text' class='partial-grade' id='<?php echo $registrarion['matricula']; ?>-cpar6' value='<?php echo $registrarion['cpar6']; ?>'>
            </div>
          </div>

        <?php endforeach; ?>
        </div>

      </div>

    <?php endforeach; ?>

  </div>

  <script src='assets/jquery.min.js'></script>
  <script src='assets/classes.js'></script>

</body></html>
