<?php

namespace Model;

class Admin extends ActiveRecord
{
  // Base de Datos 
  protected static $tabla = "usuarios";
  protected static $columnasDB = ["id", "email", "password"];

  public $id;
  public $email;
  public $password;

  public function __construct($args = [])
  {
    $this->id = $args["id"] ?? null;
    $this->email = $args["email"] ?? "";
    $this->password = $args["password"] ?? "";
  }

  public function validar()
  {
    if (!$this->email) {
      self::$errores[] = "El email es Obligatorio";
    }
    if (!$this->password) {
      self::$errores[] = "El password es Obligatorio";
    }

    return self::$errores;
  }

  public function existeUsuario()
  {
    // Revisar si un usuario existe o no
    $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

    $resultado = self::$db->query($query);

    if (!$resultado->num_rows) {
      self::$errores[] = "El usuario no existe";
      return;
    }
    return $resultado;
  }

  public function comprobarPassword($resultado)
  {
    $usuario = $resultado->fetch_object();

    $autentificado = password_verify($this->password, $usuario->password);

    if (!$autentificado) {
      self::$errores[] = "El Password es incorrecto";
    }
    return $autentificado;
  }

  public function autenticar()
  {
    session_start();

    //Llenar el arreglo de session
    $_SESSION["usuario"] = $this->email;
    $_SESSION["login"] = true;

    header("Location: /admin");
  }
}
