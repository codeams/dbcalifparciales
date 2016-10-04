<?php

  /* -- Data verification functions -- */

  function areParametersValid( $parameters ) {

    if( !is_array( $parameters ) ) $parameters = array( $parameters );

    foreach ( $parameters as $parameter ) {

      $isNotValid = !isset( $_POST[$parameter] ) || $_POST[$parameter] == '';

      if ( $isNotValid ) return false;

    }

    return true;

  }

  function isParameterValid( $parameter ) {

    $isValid = isset( $_POST[$parameter] ) && ( $_POST[$parameter] != '' );
    return $isValid;

  }

  /* -- Request/Answer managing functions -- */

  function printJson( $success, $data = 'null' ) {

    if ( $success ) $success = 'true';
    else $success = 'false';

    print( json_encode( [ 'success' => $success, 'data' => $data ] ) );
    exit();

  }

  function printError( $errorDescription ) {

    print( json_encode( [ 'success' => false, 'errorDescription' => $errorDescription ] ) );
    exit();

  }

  /* -- Sequential actions functions -- */

  function getRegistrarionsByTeacherId() {

    require 'DataBase.php';

    $db = new DataBase( 'dbcalifparciales' );
    $db->connect( 'root' );

    $classRegistrations = $db->getRegistrarionsByTeacherId( $_POST['teacherId'] );

    $areClassRegistrarions = count( $classRegistrations ) > 0;

    if ( $areClassRegistrarions ) {

      $groupedRegistrarions = $db->groupRegistrarionsBySubjects( $classRegistrations );
      printJson( true, $groupedRegistrarions );

    } else printJson( true, 'null' );

  }

  function login() {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $isUsernameValid = $username == '1727';
    $isPasswordValid = $password == '123';

    if ( $isUsernameValid && $isPasswordValid ) printJson( true );
    else printError( 'Nombre de usuario o contraseña incorrectos.' );

  }

  /* -- Core program -- */

  if ( isParameterValid( 'requestType' ) ) $requestType = $_POST['requestType'];
  else printError( 'Error de comunicación: No se ha entendido el tipo de solicitud.' );

  switch( $requestType ) {

    case 'getRegistrarionsByTeacherId': getRegistrarionsByTeacherId(); break;
    case 'login': login(); break;
    default: printError( 'Error de comunicación: Se ha hecho un tipo de solicitud no válida.' ); break;

  }
