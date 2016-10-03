<?php

  $isTeacherIdDefined = isset( $_GET['id'] ) && !is_null( $_GET['id'] );

  if ( $isTeacherIdDefined ) $teacherID = $_GET['id'];
  else die('Ingresa por URL una id de profesor. ?id=clvprof.');

  require 'DataBase.php';

  $db = new DataBase( 'dbcalifparciales' );
  $db->connect( 'root' );

  $classRegistrations = $db->getRegistrarionsByTeacherID( $teacherID );

  if ( $classRegistrations['success'] ) {

    $groupedRegistrarions = $db->groupRegistrarionsBySubjects( $classRegistrations['classRegistrations'] );

  } else die( 'MySQL error: ' . $db->getErrorMessage() );

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <title>dbcalifparciales</title>
  </head>
  <body>
    <div><?php print( json_encode( $groupedRegistrarions ) ); ?></div>
  </body>
</html>
