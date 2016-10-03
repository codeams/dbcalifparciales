<!doctype html>
<html>
  <head>
    <meta charset='utf-8'>
    <title>Iniciar sesión</title>
    <link rel='stylesheet' href='assets/styles.css'>
  </head>
  <body>

    <h1>Iniciar sesión</h1>

    <p>Utilice su cuenta UADY.<br>
    <a href='#'>¿Qué es esto?</a></p>

    <form id='login' name='login' action=''>

      <input type='text' id='username' name='username' placeholder='Clave de profesor'>
      <input type='password' id='password' name='password' placeholder='Contraseña'>
      <label><input type='checkbox' id='keepSession' name='keepSession' checked='checked'> Mantener mi sesión iniciada</label>
      <input type='submit' id='submit' name='submit' value='Iniciar sesión'>

      <p><a href='#'>He olvidado mi clave de profesor</a></p>
      <p><a href='#'>He olvidado mi contraseña</a></p>

    </form>

    <script src='assets/jquery.min.js'></script>
    <script src='assets/event-handler.js'></script>
    <script src='assets/ajax-handler.js'></script>

  </body>
</html>
