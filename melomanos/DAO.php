<?php

class DAO {

    public function getUserByNombre($username, $mysqli){

      $query = sprintf("SELECT * FROM usuarios WHERE nombre = '$username'", $mysqli->real_escape_string($username));

      $rs = $mysqli->query($query)
          or die ($mysqli->error. " en la línea ".(__LINE__-1));

      $result = null;
      while($row = $rs->fetch_assoc()){
          $result = $row;
      }

      $rs->free();

      return $result;
  }

    public function getAllUsers($mysqli, $me){

      $query = "SELECT nombre FROM usuarios  WHERE nombre != '$me'  ORDER BY nombre";

      $rs = $mysqli->query($query)
                     or die ($mysqli->error. " en la línea ".(__LINE__-1));

      $result = [];
      for (;$tmp = $rs->fetch_array(MYSQLI_NUM);)
          $result[] = $tmp;

      $rs->free();

      return $result;

    }

    public function insertNewUser($mysqli, $nombre, $passHash) {

        $query = sprintf("SELECT * FROM usuarios WHERE nombre = '$nombre'", $mysqli->real_escape_string($nombre));

        $rs = $mysqli->query($query)
            or die ($mysqli->error. " en la línea ".(__LINE__-1));

        $result = null;
        while($row = $rs->fetch_assoc()){
            $result = $row;
        }

        $rs->free();

        if($result == null){
            $sql = "INSERT INTO usuarios (nombre, password)
                VALUES ('".$nombre."','". $passHash."')";

            $mysqli->query($sql)
                or die ($mysqli->error. " en la línea ".(__LINE__-1));
        }

        else {
            $_SESSION["error"] = "Usuario ya existente";
        }
    }

    public function insertNewMessage($mysqli, $nombre, $texto){

      $sql = "INSERT INTO mensajes (emisor, contenido)
              VALUES ('".$nombre."','". $texto."')
              ";

      $mysqli->query($sql)
               or die ($mysqli->error. " en la línea ".(__LINE__-1));

    }

    public function insertNewPersonalMessage($mysqli, $nombre, $receptor, $texto){
      $sql = "INSERT INTO mensajes (emisor, destinatario,contenido)
              VALUES ('".$nombre."','". $receptor."','".$texto."')
              ";

      $mysqli->query($sql)
               or die ($mysqli->error. " en la línea ".(__LINE__-1));
    }

    public function obtenerMensajesPublicos ($mysqli){

        $query = "SELECT * FROM mensajes WHERE destinatario IS NULL ORDER BY fecha DESC";

        $rs = $mysqli->query($query)
                       or die ($mysqli->error. " en la línea ".(__LINE__-1));

        $result = [];
        for (;$tmp = $rs->fetch_array(MYSQLI_NUM);)
            $result[] = $tmp;

        $rs->free();

        return $result;
    }

    public function obtenerMensajesPrivados ($mysqli, $me){

        $query = "SELECT * FROM mensajes WHERE destinatario='".$me."' ORDER BY fecha DESC";

        $rs = $mysqli->query($query)
                       or die ($mysqli->error. " en la línea ".(__LINE__-1));

        $result = [];
        for (;$tmp = $rs->fetch_array(MYSQLI_NUM);)
            $result[] = $tmp;

        $rs->free();

        return $result;
    }

}
