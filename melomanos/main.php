<!-- CABECERA -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Melomanos</title>
        <link id="favicon" rel="icon" href="assets/imagenes/favicon.png" type="image/png"/>
        <link rel="stylesheet" type="text/css" href="assets/main.css">
    </head>
    <body>
      <?php
      require_once "services.php";
      $servicios = new services();
       ?>

        <header id="main-header">
            <div id="div-fotoCab"><a href="main.php">
                    <img id="foto-cabecera" src="./assets/imagenes/headphones.png"/></a>
            </div>
            <a id="logo-header" href="main.php">
                <span class="site-name">Melómanos</span>
            </a> <!-- / #logo-header -->

            <nav>
                <ul>
                    <li><a href="servicesParse.php?action=doLogout">Cerrar sesión</a></li>
                </ul>
            </nav><!-- / nav -->
	</header><!-- / #main-header -->
  <div id="left">
        <div class="nuevo-mensaje">
        <div id="formulario">
            <!--  FORMULARIO DE MENSAJE PERSONAL  -->
            <form action="servicesParse.php?action=sendPersonalMessage" method="post">
                <?php
                  $allUsers=$servicios->getUserNames();
                ?>
                <select name="receptor">
                    <option value="NULL"> --Selecciona un destinatario </option>
                    <?php
                    foreach($allUsers as $name){
                        echo '<option value="'.$name[0].'">'.$name[0].'</option>';
                    }
                    ?>
                </select>
                <div id="form-mensaje-ta">
                    <textarea rows="3" name="textoMensaje" placeholder="Escribe aquí tu mensaje personal"
                    maxlength="500"></textarea>
                </div>
                <button type="submit" value="Enviar">Enviar mensaje personal</button>
            </form>
        </div>
        </div>
        <?php
            $listaMensajes = $servicios->loadPrivateMessages();
         ?>
        <div class="mensajes">
            <h1>Mis mensajes personales</h1>
            <ul id="listaMensajes">
              <?php
                foreach($listaMensajes as $mensaje){
                  $timeStamp = $mensaje[2];
                  $timeStamp = date( "d-m-Y", strtotime($timeStamp));
                    echo '<li>'
                      . '<p id="emisorMensaje">'.$mensaje[3].'</p>'
                      . '<p id="contenidoMensaje">'.$mensaje[1].'</p>'
                      . '<p id="fechaMensaje">'.$timeStamp.'</p>'
                      . '</li>';
                }
              ?>
            </ul>
      </div>
  </div> <!-- FIN LEFT -->

  <div id="right">
        <div class="nuevo-mensaje">

        <div id="formulario">
            <form action="servicesParse.php?action=sendMessage" method="post">
                <div id="form-mensaje-ta">
                    <textarea rows="3" name="textoMensaje" placeholder="Escribe aquí tu mensaje para que todos lo lean"
                    maxlength="500"></textarea>
                </div>
                <button type="submit" value="Entrar">Enviar mensaje público</button>
            </form>
        </div>
        </div>
        <?php
            require_once "services.php";
            $servicios = new services();
            $listaMensajes = $servicios->loadPublicMessages();
         ?>
        <div class="mensajes">
            <h1>¿Qué han comentado el resto de usuarios?</h1>
            <ul id="listaMensajes">
              <?php
                foreach($listaMensajes as $mensaje){
                  $timeStamp = $mensaje[2];
                  $timeStamp = date( "d-m-Y", strtotime($timeStamp));
                    echo '<li>'
                      . '<p id="emisorMensaje">'.$mensaje[3].'</p>'
                      . '<p id="contenidoMensaje">'.$mensaje[1].'</p>'
                      . '<p id="fechaMensaje">'.$timeStamp.'</p>'
                      . '</li>';
                }
              ?>
            </ul>
      </div>
  </div> <!-- FIN RIGHT -->

  </body>
</html>
