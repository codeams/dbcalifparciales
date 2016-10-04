
/**
 * Classes JavaScript document
 * (c)2016 codeams@gmail.com
 */

$( function() {

  /* -- DOM access variables -- */

  var Dom = {
    $buttonLogout : $( '.logout' ),
    $divClass : $( '.class' )
  };

  /* -- Event listeners -- */

  Dom.$buttonLogout.on( 'click', function() {
    window.location.replace('logout.php');
  });

  Dom.$divClass.on( 'click', function() {
    $( this ).toggleClass( 'active' );
  });

});
