
/**
 * Classes JavaScript document
 * (c)2016 codeams@gmail.com
 */

$( function() {

  /* -- DOM access variables -- */

  var Dom = {
    $buttonLogout : $( '.logout' ),
    $divClassData : $( '.class-data' )
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

  function comparePartialGradeMaps( mapOne, mapTwo ) {

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

          registrationsToUpdate[ indexRegistration ] = {};

          $.each( partialGrades, function( indexPartialGrade, thePartialGrade ) {

            registrationsToUpdate[ indexRegistration ][ indexPartialGrade ] = $( '#' + indexRegistration + '-' + indexPartialGrade).val();

          });

        }

      });

    });

    return registrationsToUpdate;

  }

  /* -- Event listeners -- */

  Dom.$buttonLogout.on( 'click', function() {
    window.location.replace('logout.php');
  });

  Dom.$divClassData.on( 'click', function() {
    $( this ).parent().toggleClass( 'active' );
  });

  $( '.save' ).on( 'click', function() {

    var newPartialGradesMap = getPartialGradesMap();
    // console.log( comparePartialGradeMaps( initialPartialGradesMap, newPartialGradesMap ) );

  });

  var initialPartialGradesMap = getPartialGradesMap();
  // console.log( initialPartialGradesMap );

});
