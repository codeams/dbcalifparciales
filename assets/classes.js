
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
          theRegistrarionObject['cpar' + partialGradeIndex ] = $( thePartialGrade ).val();
        });

      });

    });

    console.log( gradesMap );

  }

  function comparePartialGradeMaps( mapOne, mapTwo ) {

  }

  /* -- Event listeners -- */

  Dom.$buttonLogout.on( 'click', function() {
    window.location.replace('logout.php');
  });

  Dom.$divClassData.on( 'click', function() {
    $( this ).toggleClass( 'active' );
  });

  $( '.save' ).on( 'click', function() {

    getPartialGradesMap();

  });

});
