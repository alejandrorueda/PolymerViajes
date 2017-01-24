<?php

use Base\Usuario as BaseUsuario;
use Map\UsuarioTableMap;
use Propel\Runtime\Propel;
/**
 * Skeleton subclass for representing a row from the 'usuario' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Usuario extends BaseUsuario
{
     public function registrar($idusuario,$nombre,$password,$apellidos,$avatar,$email){
	 $con = Propel::getWriteConnection(UsuarioTableMap::DATABASE_NAME);

	  $con->beginTransaction();

	  try {
	    $perfil = new Perfil();
		// remove the amount from $fromAccount
		$this->setIdusuario($idusuario);
		$this->setNombre($nombre);
		$this->setPassword($password);
		$this->setApellidos($apellidos);
		$this->setAvatar($avatar);
		$this->setEmail($email);
		$this->setPerfil($perfil);
		$this->save($con);

		$con->commit();
		echo json_encode(["res" => "El registro se ha realizado con exito"]);
	  } catch (Exception $e) {

		$con->rollback(); //en caso de que se produzca alguna excepcion la transacción será cancelada
		echo json_encode(["res" => "El nombre de usuario ya esta en uso"]);
		throw $e;
	  }
  }

    public function iniciarSesion($idusuario,$password){
    $usuario = UsuarioQuery::create()->filterByIdusuario($idusuario)->filterByPassword($password)->find();

	try {
		$resultado = json_encode(["exito" => false]);

		foreach($usuario as $usu) {
		  $resultado = json_encode(["idusuario" => $usu->getIdusuario(),"nombre" => $usu->getNombre(),"password" => $usu->getPassword(),"exito"=>true]);
		}
		echo $resultado;
	  } catch (Exception $e) {

		echo $resultado;
		//throw $e;
	  }

  }


   public function datosUsuario($idusuario,$password){
    $usuario = UsuarioQuery::create()->filterByIdusuario($idusuario)->filterByPassword($password)->find();

	try {
		$resultado = json_encode(["exito" => false]);


		foreach($usuario as $usu) {
		  //unset($this);

		  //$this1 = $usu;
		  //$usu["exito"]=true;
		  $resultado = $usu->toJSON();
		}

		return $usuario;
		//echo $resultado;
	  } catch (Exception $e) {

		return $usuario;
		//echo $resultado;
		//throw $e;
	  }

  }

  public function informacionPerfil($idusuario,$password){
   $usuario = UsuarioQuery::create()->filterByIdusuario($idusuario)->findOne();
   $iniciado = UsuarioQuery::create()->filterByIdusuario($idusuario)->filterByPassword($password)->find();

   $perfil = $usuario->getPerfil();

   $informacion = array_merge($usuario->toArray(),$perfil->toArray());
   try {
     //$exito = json_encode(["exito" => false]);
      $exito = false;

     foreach($iniciado as $ini) {
       $exito = true;
     }

     $informacion['exito']=$exito;

     echo json_encode($informacion);

     //echo $resultado;
     } catch (Exception $e) {
     $exito = false;
     //echo $resultado;
     //throw $e;
     }

 }

}
