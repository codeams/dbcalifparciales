
/**
 * Login JavaScript document
 * (c)2016 codeams@gmail.com
 */

$( function() {

  /* -- DOM access variables -- */

  var Dom = {
    $uiLocker :       $( '.ui-locker' ),
    $errorMessage :   $( '.error-message' ),
    $formLogin :      $( '#login' ),
    $inputTeacherId : $( '#teacherId' ),
    $inputPassword :  $( '#password' )
  };

  /* -- User Interface related functions -- */

  function lockUI() {
    Dom.$uiLocker.css( 'display', 'block' );
  };

  function unlockUI() {
    Dom.$uiLocker.css( 'display', 'none' );
  };

  function showErrorMessage( theMessage ) {
    hideErrorMessage();
    Dom.$errorMessage.text( theMessage );
    Dom.$errorMessage.show();
  };

  function hideErrorMessage() {
    Dom.$errorMessage.css( 'display', 'none' )
  };

  /* -- Procedural functions -- */

  function loginRequest() {

    var teacherId = Dom.$inputTeacherId.val();
    var password = Dom.$inputPassword.val();

    var isEmptyUsername = teacherId.length <= 0;
    var isEmptyPassword = password.length <= 0;

    if ( isEmptyUsername || isEmptyPassword ) return;

    $.ajax({

      url: 'requestHandler.php',
      type: 'POST',
      dataType: 'JSON',

      'data' : {
        'requestType' : 'login',
        'teacherId' : teacherId,
        'password' : password
      },

      beforeSend: function() {
        hideErrorMessage();
        lockUI();
      },

      'complete' : function() {
        unlockUI();
      },

      'success' : function( data ) {

        var loginSuccess = data.success == 'true';

        if ( loginSuccess ) window.location.replace('classes.php');
        else showErrorMessage( data.errorDescription );

      },

      error: function() {
        showErrorMessage( 'No se ha podido completar la comunicación con el servidor.' );
      }

    });

  };

  /* -- Event listeners -- */

  Dom.$formLogin.on( 'submit', function() {
    loginRequest();
    return false;
  });

});
