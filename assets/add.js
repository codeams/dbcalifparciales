
$(function() {

  /* DOM access variables */

  var Dom = {
    $buttonAdd : $( '.add' ),
    $inputName : $( '.name' ),
    $inputLastName : $( '.last-name' ),
    $inputStudentId : $( '.student-id' ),
    $inputCareer : $( '.career' ),
    $inputEmail : $( '.email' ),
    $inputAddress : $( '.address' ),
    $inputPostalCode : $( '.postal-code' ),
    $inputTelephone : $( '.telephone' ),
    $inputAdmissionDate : $( '.admission-date' ),
    $errorMessage : $( '.error-message' )
  };

  /* User Interface related functions */

  function showErrorMessage( theMessage ) {
    Dom.$errorMessage.text( theMessage );
    Dom.$errorMessage.css( 'display', 'block' );
  };

  function hideErrorMessage() {
    Dom.$errorMessage.css( 'display', 'none' );
  };

  /* Procedural functions */

  function addStudent( data ) {

    var studentData = {

      name : Dom.$inputName.val(),
      'last-name' : Dom.$inputLastName.val(),
      'student-id': Dom.$inputStudentId.val(),
      career: Dom.$inputCareer.val(),
      email: Dom.$inputEmail.val(),
      address: Dom.$inputAddress.val(),
      'postal-code': Dom.$inputPostalCode.val(),
      telephone: Dom.$inputTelephone.val(),
      'admission-date': Dom.$inputAdmissionDate.val()

    };

    $.ajax({

      url: 'requestHandler.php',
      type: 'POST',
      dataType: 'JSON',

      data: {
        'requestType': 'addStudent',
        'studentData': studentData
      },

      beforeSend: function() {
        console.log( 'sending request' );
      },

      success: function( data ) {

        var updateSuccess = data.success === 'true';

        if ( updateSuccess ) {
          console.log( 'success' ); //window.location.replace( '' );
        } else {
          console.log( 'error' );
          showErrorMessage( data.errorDescription );
        }

      },

      error: function() {

      },

      complete: function( data ) {
        console.log( 'Completed:' );
        console.log( data );
      }

    });

  }

  /* Event declarations */

  Dom.$buttonAdd.on( 'click', function() {

    /* TODO: comprobar entradas válidas */
    addStudent();

  });

});
