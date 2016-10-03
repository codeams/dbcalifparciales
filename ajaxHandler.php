<?php

  function printJson( $data ) {

    print( json_encode( [ 'success' => 'true', 'data' => $data ] ) );
    exit();

  }

  function isValid( $variable ) {

    $isValid = isset( $variable ) && !is_null( $variable ) && $variable != '';
    return $isValid;

  }

  function getRegistrarionsByTeacherId() {

    require 'DataBase.php';

    $db = new DataBase( 'dbcalifparciales' );
    $db->connect( 'root' );

    $classRegistrations = $db->getRegistrarionsByTeacherId( $_GET['teacherId'] );
    $areClassRegistrarions = !is_null( $classRegistrations );

    if ( $areClassRegistrarions ) {

      $groupedRegistrarions = $db->groupRegistrarionsBySubjects( $classRegistrations );

    } else die( "MySQL error: $db->getErrorMessage()" );

    printJson( $groupedRegistrarions );

  }

  switch( $_GET['requestType'] ) {

    case 'getRegistrarionsByTeacherId': getRegistrarionsByTeacherId(); break;
    default: errorIn('communication'); break;

  }
