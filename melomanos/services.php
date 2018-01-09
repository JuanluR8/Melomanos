<?php

session_start();

class services {

    public function doLogin() {

        $servidor = "localhost";
        $userBD = "user-melomanos";
        $pass = "melomanos";
        $database = "melomanos";

        require 'DAO.php';

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_MAGIC_QUOTES);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_MAGIC_QUOTES);
        $mysqli = new mysqli($servidor, $userBD, $pass, $database);

        if ( mysqli_connect_errno() ) {
            echo "Error de conexión a la BD: ".mysqli_connect_error();
            exit();
        }

        $dao = new DAO();
        $usuario = $dao->getUserByNombre($username, $mysqli);
        $mysqli->close();

        if($usuario != null && password_verify($password, $usuario['password'])){
            $_SESSION["nombre"] = $usuario['nombre'];
            return 'main.php';
        } else {
            $_SESSION["error"] = "Usuario o contraseña no válidos";
            return 'index.php';
        }
    }

    public function doRegister(){

        $servidor = "localhost";
        $userBD = "user-melomanos";
        $pass = "melomanos";
        $database = "melomanos";

        require 'DAO.php';
        $dao = new DAO();

        $nombre = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_MAGIC_QUOTES);
        $password = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_MAGIC_QUOTES);
        $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_MAGIC_QUOTES);

        $mysqli = new mysqli($servidor, $userBD, $pass, $database);
        $usuario = $dao->getUserByNombre($nombre, $mysqli);


        if($usuario == null){

            if ($password == $password2){

                $passHash = password_hash($password, PASSWORD_BCRYPT);

                if ( mysqli_connect_errno() ) {
                    echo "Error de conexión a la BD: ".mysqli_connect_error();
                    exit();
                }

                $dao->insertNewUser($mysqli, $nombre, $passHash);
                $mysqli->close();
                $_SESSION['nombre']=$nombre;

                return 'main.php';

            } else {
                $_SESSION["error"] = "Las contraseñas no coinciden";
                $mysqli->close();
                return 'index.php';
            }
        } else {
            $_SESSION["error"] = "Ya existe un usuario con ese nombre";
            $mysqli->close();
            return 'index.php';
        }
    }

    public function doLogout(){

        session_destroy();
        return 'index.php';
    }

    public function loadPublicMessages(){

      $servidor = "localhost";
      $userBD = "user-melomanos";
      $pass = "melomanos";
      $database = "melomanos";

      require_once 'DAO.php';
      $dao = new DAO();

      $mysqli = new mysqli($servidor, $userBD, $pass, $database);
      $listaMensajes = $dao->obtenerMensajesPublicos($mysqli);
      $mysqli->close();

      return $listaMensajes;
    }

    public function loadPrivateMessages(){

      $servidor = "localhost";
      $userBD = "user-melomanos";
      $pass = "melomanos";
      $database = "melomanos";

      $me = $_SESSION['nombre'];

      require_once 'DAO.php';
      $dao = new DAO();

      $mysqli = new mysqli($servidor, $userBD, $pass, $database);
      $listaMensajes = $dao->obtenerMensajesPrivados($mysqli, $me);
      $mysqli->close();

      return $listaMensajes;
    }

    public function sendMessage(){

      $servidor = "localhost";
      $userBD = "user-melomanos";
      $pass = "melomanos";
      $database = "melomanos";

      require 'DAO.php';
      $dao = new DAO();

      $nombre = $_SESSION['nombre'];
      $texto = filter_input(INPUT_POST, 'textoMensaje', FILTER_SANITIZE_MAGIC_QUOTES);

      $mysqli = new mysqli($servidor, $userBD, $pass, $database);

      if ( mysqli_connect_errno() ) {
          echo "Error de conexión a la BD: ".mysqli_connect_error();
          exit();
      }


      $dao->insertNewMessage($mysqli, $nombre, $texto);
      $mysqli->close();

      return 'main.php';
    }

    public function sendPersonalMessage(){

      $servidor = "localhost";
      $userBD = "user-melomanos";
      $pass = "melomanos";
      $database = "melomanos";

      require 'DAO.php';
      $dao = new DAO();

      $nombre = $_SESSION['nombre'];
      $receptor = $_POST['receptor'];
      $texto = filter_input(INPUT_POST, 'textoMensaje', FILTER_SANITIZE_MAGIC_QUOTES);

      $mysqli = new mysqli($servidor, $userBD, $pass, $database);

      if ( mysqli_connect_errno() ) {
          echo "Error de conexión a la BD: ".mysqli_connect_error();
          exit();
      }
      if (is_null($receptor) ){
        $dao->insertNewPersonalMessage($mysqli, $nombre, $receptor, $texto);
      }
      $mysqli->close();

      return 'main.php';
    }

    public function getUserNames(){

          $servidor = "localhost";
          $userBD = "user-melomanos";
          $pass = "melomanos";
          $database = "melomanos";

          $me = $_SESSION["nombre"];

          require_once 'DAO.php';
          $dao = new DAO();

          $mysqli = new mysqli($servidor, $userBD, $pass, $database);
          $listaUsuarios = $dao->getAllUsers($mysqli, $me);
          $mysqli->close();

          return $listaUsuarios;
        }
}
