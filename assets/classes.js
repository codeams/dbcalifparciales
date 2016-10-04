
/**
 * Classes JavaScript document
 * (c)2016 codeams@gmail.com
 */

$( function() {

  /* -- DOM access variables -- */

  var Dom = {
    $logoutButton : $('.logout')
  };

  /* -- Event listeners -- */

  Dom.$logoutButton.on( 'click', function() {
    window.location.replace('logout.php');
  });

});
