
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
      hideErrorMessage();
      lockUI( true );
    },
    error: function() {
      alert( 'No se ha podido completar la comunicación con el servidor.' );
    }

  });

  /* -- Vars -- */
  var id;

  var $body =               $('body');
  var $divUiLocker =        $('.ui-locker');
  var $divContentWrapper =  $('.content-wrapper');

  var $inputUsername =      $( '#username' );
  var $inputPassword =      $( '#password' );
  var $formLogin =          $( '#login' );
  var $divErrorMessage =    $( '.error-message' );

  /* -- Functions -- */

  // Secuencial process functions

  function loginRequest() {

    var username = $inputUsername.val();
    var password = $inputPassword.val();

    id = username;

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

  function goToHomePage() {

    console.log('Moving to the home page.');

    $divContentWrapper.html('');

    var preClassesContent = "<div class='welcome-message'>Bienvenido " + id + '</div>\n';
    preClassesContent += "<div class='page-title'>Estos son tus grupos:</div>\n";
    preClassesContent += "<div class='classes'>";

    $divContentWrapper.append(preClassesContent);

    $.ajax({
      'data' : { 'requestType' : 'getRegistrarionsByTeacherId', 'teacherId' : id },
      'complete' : function( data ) { console.log( data ); lockUI( false ); },
      'success' : function( data ) {

        var requestSuccess = data.success == 'true';

        if ( requestSuccess ) {

          $.each( data.data, function( indexClass, theClass ) {

            console.log( theClass );

            var classContent = "<div class='class' id='"+ theClass.clvasig +"'>";
            classContent += "<div class='class-name'>Asignatura: "+ theClass.clvasig +"</div>";
            classContent += "</div>";

            $divContentWrapper.append(classContent);

          });

        } else showErrorMessage( data.errorDescription );

      }
    });

    $divContentWrapper.append("</div>");

  }

  // UI related functions

  function lockUI( shouldItLockTheUI ) {

    if ( shouldItLockTheUI ) $divUiLocker.css( 'display', 'block' );
    else $divUiLocker.css( 'display', 'none' );

  }

  function showErrorMessage( message ) {

    hideErrorMessage();
    $divErrorMessage.text( message );
    $divErrorMessage.show();

  }

  function hideErrorMessage() {
    $divErrorMessage.css( 'display', 'none' )
  }

  // Communication related functions

  function sendRequest( requestType, data ) {

    switch( requestType ) {

      case 'login':

        $.ajax({
          'data' : { 'requestType' : 'login', 'username' : data.username, 'password' : data.password },
          'complete' : function( data ) { console.log( data ); lockUI( false ); },
          'success' : function( data ) {

            var loginSuccess = data.success == 'true';

            if ( loginSuccess ) {

                name = data.name;
                goToHomePage();

            } else showErrorMessage( data.errorDescription );

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

  /* -- Events -- */

  $formLogin.on( 'submit', function() {

    loginRequest();
    return false;

  });

});
