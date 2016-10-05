<?php

/* -- Parameter verification functions -- */

function areParametersValid( $parameters ) {

  if( !is_array( $parameters ) ) $parameters = array( $parameters );

  foreach ( $parameters as $parameter ) {

    $isNotValid = !isset( $_POST[$parameter] ) || $_POST[$parameter] == '';

    if ( $isNotValid ) return false;

  }

  return true;

}

function isParameterValid( $parameter ) {

  $isValid = isset( $_POST[$parameter] ) && $_POST[$parameter] != '';
  return $isValid;

}

/* -- Communication control functions -- */

function printData( $data = 'null' ) {

  print( json_encode( [ 'success' => 'true', 'data' => $data ] ) );
  exit();

}

function printError( $errorDescription ) {

  print( json_encode( [ 'success' => 'false', 'errorDescription' => $errorDescription ] ) );
  exit();

}

/* -- Procedural functions -- */

function createSession() {

  session_start();

  $_SESSION['session'] = [
    'teacherId' => 1727,
    'name' => 'Díaz Mendoza Julio César',
    'degree' => 'Ing.'
  ];

}

function authenticateUser() {

  $isEmptyLoginData = !areParametersValid( ['teacherId', 'password'] );
  if ( $isEmptyLoginData ) printError( 'Error de comunicación: No se han recibido los datos necesarios para iniciar sesión.' );
  else {
    $teacherId = $_POST['teacherId'];
    $password = $_POST['password'];
  }

  require 'DataBase.php';
  $dataBase = new DataBase( 'dbcalifparciales' );
  $dataBase->connect( 'root' );

  $isLoginDataValid = $dataBase->authenticateUser( $teacherId, $password );

  if ( $isLoginDataValid ) {
    createSession();
    printData( true );
  } else printError( 'Clave de profesor o contraseña incorrectos.' );

}

function updateStudentPartialGrades() {

  $isStudentDataValid = areParametersValid( [ 'studentId', 'partialGrades' ] );

  if ( $isStudentDataValid ) {
    $studentId = $_POST['studentId'];
    $partialGrades = $_POST['partialGrades'];
  } else printError( 'Error de comunicación: No se recibió la información necesaria para realizar la solicitud.' );

  require 'DataBase.php';
  $dataBase = new DataBase( 'dbcalifparciales' );
  $dataBase->connect( 'root' );

  $isUpdateSuccessful = $dataBase->updateStudentPartialGrades( $studentId, $partialGrades );

  if ( $isUpdateSuccessful ) printData( true );
  else printError( 'No se ha podido actualizar los datos.' );

}

/* -- Request type switch -- */

if ( isParameterValid( 'requestType' ) ) $requestType = $_POST['requestType'];
else printError( 'Error de comunicación: No se ha especificado un tipo de solicitud.' );

switch( $requestType ) {
  case 'authenticateUser': authenticateUser(); break;
  case 'updateStudentPartialGrades': updateStudentPartialGrades(); break;
  default: printError( 'Error de comunicación: Se desconoce el tipo de solicitud especificada.' ); break;
}
