<?php session_start(); ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Melomanos</title>
        <link id="favicon" rel="icon" href="assets/imagenes/favicon.png" type="image/png"/>
        <link rel="stylesheet" type="text/css" href="assets/index.css">
    </head>

    <body>
        <!--    TITULO  -->
        <div id="titulo-portada">
            <img src="assets/imagenes/headphones.png">
            <h1>    Melómanos   </h1>
            <p> Un sitio donde compartir y descubrir nueva música </p>
            <p class="err-msg">
            <?php
            if(isset($_SESSION['error'])){
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            }
            ?>
            </p>
        </div>

        <div id="formularios">

            <!--  ENTRAR  -->
            <div id="EntrarForm">
                <h2>¿Ya registrado?</h2>
                <form action="servicesParse.php?action=doLogin" method="post">
                    <input type="text" name="username" placeholder="Nombre"><br>
                    <input type="password" name="password" placeholder="Contraseña"><br>
                    <button type="submit" value="Entrar">Entrar</button>
                </form>
            </div>

            <!--  REGISTRAR  -->
            <div id="RegistrarForm">
                <h2>¿Eres nuevo?</h2>
                <form action="servicesParse.php?action=doRegister" method="post">
                    <input type="text" name="username" placeholder="Nombre"><br>
                    <input type="password" name="password1" placeholder="Contraseña"><br>
                    <input type="password" name="password2" placeholder="Repita la contraseña"><br>
                    <button type="submit" value="Aceptar">Registrarme</button>
                </form>
            </div>

        </div>

    </body>

</html>
