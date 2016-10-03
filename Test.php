<?php

  $isTeacherIdDefined = isset( $_GET['id'] ) && !is_null( $_GET['id'] ) && $_GET['id'] != '';

  if ( $isTeacherIdDefined ) $teacherID = $_GET['id'];
  else die('Ingresa por URL una id de profesor. ?id=clvprof.');

  require 'DataBase.php';

  $db = new DataBase( 'dbcalifparciales' );
  $db->connect( 'root' );

  $classRegistrations = $db->getRegistrarionsByTeacherId( $teacherID );
  $areClassRegistrarions = !is_null( $classRegistrations );

  if ( $areClassRegistrarions ) {

    $groupedRegistrarions = $db->groupRegistrarionsBySubjects( $classRegistrations );

    $jsonEncodedGroupedRegistrations = json_encode( $groupedRegistrarions );

  } else die( 'MySQL error: ' . $db->getErrorMessage() );

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <title>dbcalifparciales</title>
  </head>
  <body>
    <div><?php print( $jsonEncodedGroupedRegistrations ); ?></div>
  </body>
</html>
