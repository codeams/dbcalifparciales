
/**
 * Classes JavaScript document
 * (c)2016 codeams@gmail.com
 */

$( function() {

  /* -- DOM access variables -- */

  var Dom = {
    $uiLocker :     $( '.ui-locker' ),
    $buttonSave :   $( '.save' ),
    $buttonLogout : $( '.logout' ),
    $divClassData : $( '.class-data' ),
    $errorMessage : $( '.error-message' )
  };

  /* -- User Interface related functions -- */

  function lockUI() {
    Dom.$uiLocker.css( 'display', 'none' );
    Dom.$buttonSave.text( 'guardando...' );
  };

  function unlockUI() {
    Dom.$uiLocker.css( 'display', 'none' );
    Dom.$buttonSave.text( 'guardar' );
  };

  function showErrorMessage( theMessage ) {
    Dom.$errorMessage.text( theMessage );
    Dom.$errorMessage.css( 'display', 'block' );
  };

  function hideErrorMessage() {
    Dom.$errorMessage.css( 'display', 'none' );
  };

  /* -- Procedural functions -- */

  function getPartialGradesMap() {

    var classes = $( '.class' );
    var gradesMap = {};

    var thereAreNoClasses = classes.length === 0;

    if ( thereAreNoClasses ) return {};

    $.each( classes, function( classIndex, theClass ) {

      var $theClass = $( theClass );
      gradesMap[ $theClass.attr('id') ] = {};
      var theClassObject = gradesMap[ $theClass.attr('id') ];

      var $registrarions = $theClass.find( '.registrarion' );

      $.each( $registrarions, function( registrarionIndex, theRegistrarion ) {

        theClassObject[ $( theRegistrarion ).attr( 'id' ) ] = {};
        var theRegistrarionObject = theClassObject[ $( theRegistrarion ).attr( 'id' ) ];

        var $partialGrades = $( theRegistrarion ).find( '.partial-grade' );

        $.each( $partialGrades, function( partialGradeIndex, thePartialGrade ) {
          theRegistrarionObject['cpar' + (partialGradeIndex + 1) ] = $( thePartialGrade ).val();
        });

      });

    });

    return gradesMap;

  }

  function comparePartialGradesMaps( mapOne, mapTwo ) {

    var classes = mapOne;
    registrationsToUpdate = {};

    $.each( classes, function( indexClass, theClass ) {

      var registrarions = theClass;

      $.each( registrarions, function( indexRegistration, theRegistrarion ) {

        var partialGrades = theRegistrarion;
        var isRegistrationModified = false;

        $.each( partialGrades, function( indexPartialGrade, thePartialGrade ) {

          var partialGradeMapOne = mapOne[indexClass][indexRegistration][indexPartialGrade];
          var partialGradeMapTwo = mapTwo[indexClass][indexRegistration][indexPartialGrade];
          var partialGradesAreDifferent = partialGradeMapOne != partialGradeMapTwo;

          if ( partialGradesAreDifferent ) isRegistrationModified = true;

        });

        if ( isRegistrationModified ) {

          registrationsToUpdate[ indexRegistration ] = {
            classId : indexClass,
            partialGrades : {}
          };

          $.each( partialGrades, function( indexPartialGrade, thePartialGrade ) {

            registrationsToUpdate[ indexRegistration ][ 'partialGrades' ][ indexPartialGrade ] = $( '#' + indexClass + '-' +indexRegistration + '-' + indexPartialGrade).val();

          });

        }

      });

    });

    return registrationsToUpdate;

  }

  function updateStudentPartialGrades() {

    var newPartialGradesMap = getPartialGradesMap();
    var registrationsToUpdate = comparePartialGradesMaps( initialPartialGradesMap, newPartialGradesMap );

    $.each( registrationsToUpdate, function( studentId, theRegistrarion ) {

      $.ajax({

        url: 'requestHandler.php',
        type: 'POST',
        dataType: 'JSON',

        'data' : {
          'requestType' : 'updateStudentPartialGrades',
          'studentId' : studentId,
          'classId' : theRegistrarion.classId,
          'partialGrades' : theRegistrarion.partialGrades
        },

        beforeSend: function() {
          lockUI();
        },

        'complete' : function() {
          unlockUI();
        },

        'success' : function( data ) {

          var updateSuccess = data.success == 'true';

          if ( updateSuccess ) window.location.replace( '' );
          else showErrorMessage( data.errorDescription );

        },

        error: function() {
          showErrorMessage( 'No se ha podido completar la comunicación con el servidor.' );
        }

      });

    });

  };

  /* -- Event listeners -- */

  Dom.$buttonLogout.on( 'click', function() {
    window.location.replace('logout.php');
  });

  Dom.$divClassData.on( 'click', function() {
    $( this ).parent().toggleClass( 'active' );
  });

  Dom.$buttonSave.on( 'click', function() {
    updateStudentPartialGrades();
  });

  var initialPartialGradesMap = getPartialGradesMap();

});
