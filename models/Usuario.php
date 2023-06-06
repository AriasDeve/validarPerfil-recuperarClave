<?php

require_once 'Conexion.php';

class Usuario extends Conexion{

  private $conexion;

  public function __CONSTRUCT(){
    $this->conexion = parent::getConexion();
  }

  public function login($nombreUsuario = ''){
    try{
      $consulta = $this->conexion->prepare("SELECT * FROM usuarios WHERE nombreusuario = ?");
      $consulta->execute(array($nombreUsuario));

      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function searchUser($nombreUsuario = ''){
    try{
      $sql = ("SELECT idusuario,apellidos,nombres,email FROM usuarios WHERE nombreusuario = ? AND estado = '1'");
      $consulta = $this->conexion->prepare($sql);
      $consulta->execute(array($nombreUsuario));

      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function registraRecuperacion($data = []){
    try{
      $consulta = $this->conexion->prepare("CALL spu_registra_claverecuperacion(?, ?, ?)");
      $consulta->execute(
        array(
          $data['idusuario'],
          $data['email'],
          $data['clavegenerada']
      ));

      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }



}