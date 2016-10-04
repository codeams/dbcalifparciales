
/**
 * Event handler
 */

$( function() {

  /* -- Initial configuration -- */

  $.ajaxSetup({

    url: 'ajaxHandler.php',
    type: 'POST',
    dataType: 'JSON',
    beforeSend: function() {
      disableButtons( true );
    },
    error: function() {
      alert( 'No se ha podido completar la comunicación con el servidor.' );
    }

  });

  /* -- Vars -- */

  var $inputUsername =  $( '#username' );
  var $inputPassword =  $( '#password' );
  var $formLogin =      $( '#login' );

  /* -- Functions -- */

  // Secuencial process functions

  function loginRequest() {

    var username = $inputUsername.val();
    var password = $inputPassword.val();

    var isPasswordValid = password.length > 0;
    var isUsernameValid = username.length > 0;

    if ( isPasswordValid && isUsernameValid ) {

      var data = {
        'username': username,
        'password': password
      }

      sendRequest( 'login', data );

    }

  }

  // UI related functions

  function disableButtons( shouldItDisableThem ) {

    if ( shouldItDisableThem ) {
      $inputUsername.attr( 'disabled', 'disabled' );
      $inputPassword.attr( 'disabled', 'disabled' );
    }

    else {
      $inputUsername.removeAttr( 'disabled' );
      $inputPassword.removeAttr( 'disabled' );
    }

  }

  // Communication related functions

  function sendRequest( requestType, data ) {

    switch( requestType ) {

      case 'login':

        console.log( 'Requested login.' );

        $.ajax({
          'data' : { 'requestType' : 'login', 'username' : data.username, 'password' : data.password },
          'complete' : function( data ) { console.log( data ); disableButtons( false ); },
          'success' : function( data ) {

            var loginSuccess = data.success == 'true';

            if ( loginSuccess ) alert( 'Bienvenido' );
            else alert( data.errorDescription );

          }
        });

      break;

      case 'groupedRegistrarionsByTeacherId':
        console.log( 'Requested grouped registrarions.' );
      break;

      default:
        console.log( 'Invalid request.' );
      break;

    }

  }

  // Events

  $formLogin.on( 'submit', function() {

    loginRequest();
    return false;

  });

});
