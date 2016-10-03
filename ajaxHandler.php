<?php

  function areParametersValid( $parameters ) {

    if( !is_array( $parameters ) ) $parameters = array( $parameters );

    foreach ( $parameters as $parameter ) {

      $isNotValid = !isset( $_GET[$parameter] ) || $_GET[$parameter] == '';

      if ( $isNotValid ) return false;

    }

    return true;

  }

  function isParameterValid( $parameter ) {

    $isValid = isset( $_GET[$parameter] ) && ( $_GET[$parameter] != '' );
    return $isValid;

  }

  function printJson( $success, $data ) {

    if ( $success ) $success = 'true';
    else $success = 'false';

    print( json_encode( [ 'success' => $success, 'data' => $data ] ) );
    exit();

  }

  function getRegistrarionsByTeacherId() {

    require 'DataBase.php';

    $db = new DataBase( 'dbcalifparciales' );
    $db->connect( 'root' );

    $classRegistrations = $db->getRegistrarionsByTeacherId( $_GET['teacherId'] );

    $areClassRegistrarions = count( $classRegistrations ) > 0;

    if ( $areClassRegistrarions ) {

      $groupedRegistrarions = $db->groupRegistrarionsBySubjects( $classRegistrations );
      printJson( true, $groupedRegistrarions );

    } else printJson( true, 'null' );

  }

  if ( isParameterValid( 'requestType' ) ) $requestType = $_GET['requestType'];
  else die( 'Error de comunicación.' );

  switch( $requestType ) {

    case 'getRegistrarionsByTeacherId': getRegistrarionsByTeacherId(); break;
    default: die( 'Error de comunicación.' ); break;

  }
