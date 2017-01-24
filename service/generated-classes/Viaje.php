<?php

use Base\Viaje as BaseViaje;
use Map\GrupoViajeTableMap;
use Map\ViajeTableMap;
use Map\ViajeUsuarioTableMap;
use Propel\Runtime\Propel;
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');
/**
 * Skeleton subclass for representing a row from the 'viaje' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Viaje extends BaseViaje
{


  	public function nuevoViaje($nombre,$informacion,$destino,$precio,$fecha_inicio,$fecha_final,$usuarioId,$password)
	{
	 $usuario = UsuarioQuery::create()->filterByIdusuario($usuarioId)->filterByPassword($password)->find();
	  // get the PDO connection object from Propel

	  $con = Propel::getWriteConnection(ViajeTableMap::DATABASE_NAME);

	 // $usuario = new Usuario();

	  //$usuario->datosUsuario($usuarioId,$password);

	  $con->beginTransaction();

	  try {
		// remove the amount from $fromAccount
		$resultado = json_encode(["exito" => false]);
		foreach($usuario as $usu) {
		$this->setNombre($nombre);
		$informacion = stripcslashes(nl2br(htmlentities($informacion, ENT_HTML5 , "UTF-8")));
		$informacion = html_entity_decode($informacion);
		$this->setInformacion($informacion);
		$this->setDestino($destino);
		$this->setPrecio($precio);
		$this->setUsuarios($usuario);
		$this->setFechaInicio($fecha_inicio);
		$this->setFechaFinal($fecha_final);
		$this->setPrecio($precio);
		$this->save($con);

		$resultado = json_encode(["exito" => true]);
		}
		$con->commit();

		echo $resultado;
	  } catch (Exception $e) {
		$con->rollback(); //en caso de que se produzca alguna excepcion la transacci�n ser� cancelada
		$resultado = json_encode(["exito" => false]);
		echo $resultado;
		throw $e;
	  }
	}


  	public function viajes(){
		$viajes = ViajeQuery::create()->find();

	try {
		foreach($viajes as $viaje) {
		  $informacion = html_entity_decode($viaje->getInformacion());
		  if(strlen($informacion)>500){
			$informacion = substr($informacion,0,500);
			$informacion = $informacion.'...';
		  }

		  $viaje->setInformacion($informacion);

		  $json[] = $viaje->toArray();

		  //$json[][0] = $viaje->getNombre();
		}

		echo json_encode($json);

		//echo $resultado;
	  } catch (Exception $e) {

		//echo $resultado;
		//throw $e;
	  }

  }

  	public function misViajes($idusuario,$password){
		$usuario = new Usuario();
		$usuario->datosUsuario($usuarioId,$password);

		$viajes = MensajeQuery::create()->filterByUsuario($usuario);

	try {
		foreach($viajes as $viaje) {
		  $json[] = $viaje->toJSON();
		}

		echo json_encode($json);
		//echo $resultado;
	  } catch (Exception $e) {

		//echo $resultado;
		//throw $e;
	  }

  }

  public function viajeInformacion($idviaje,$usuarioId,$password){

  try {
     $viaje = ViajeQuery::create()->filterByIdviaje($idviaje)->findOne();
     $apuntado = $viaje->usuarioApuntado($usuarioId,$password);
     $apuntados = $viaje->getUsuarios()->getPrimaryKeys();
     $viaje = $viaje->toArray();
     $viaje['amigos'] = $apuntados;
     $viaje['apuntado']=$apuntado;
     echo json_encode($viaje);
    //echo $resultado;
    } catch (Exception $e) {

    //echo $resultado;
    //throw $e;
  }

  }

  public function usuarioApuntado($usuarioId,$password){
     $usuario = UsuarioQuery::create()->filterByIdusuario($usuarioId)->filterByPassword($password)->findOne();

     return $this->getUsuarios()->contains($usuario);
  }

public function escribirMensaje($descripcion,$asunto,$idviaje,$usuarioId,$password){
		$con = Propel::getWriteConnection(ViajeTableMap::DATABASE_NAME);
		$usuario = UsuarioQuery::create()->filterByIdusuario($usuarioId)->filterByPassword($password)->find();

		$viajes = ViajeQuery::create()->filterByIdviaje($idviaje)->findOne();

		$mensaje = new Mensaje();
		$mensaje->escribirMensaje($descripcion,$asunto,$usuarioId,$password);

		$con->beginTransaction();
	try {

		$viajes->addMensaje($mensaje);

    $viajes->save($con);
		$con->commit();

		echo $resultado;
	  } catch (Exception $e) {
		$con->rollback(); //en caso de que se produzca alguna excepcion la transacci�n ser� cancelada
		$resultado = json_encode(["exito" => false]);
		echo $resultado;
		throw $e;
	  }

  }


  public function mensajes($idviaje){
    //$mensajes = MensajeQuery::create()->limit(1);

  try {
    $viajes = ViajeQuery::create()->filterByIdviaje($idviaje)->findOne();

    $mensajes = $viajes->getMensajes();

    foreach($mensajes as $mensaje) {
      $json[] = $mensaje->toArray();
    }

    echo json_encode($json);
    //echo $resultado;
    } catch (Exception $e) {

    //echo $resultado;
    echo 'Falló la conexión: ' . $e->getMessage();
    }

  }

  public function añadirParticipante($idviaje, $idusuario,$password){
      $con = Propel::getWriteConnection(ViajeTableMap::DATABASE_NAME);
		   $usuario = UsuarioQuery::create()->filterByIdusuario($usuarioId)->filterByPassword($password)->findOne();
       $viaje = ViajeQuery::create()->filterByIdviaje($idviaje)->findOne();

       	$con->beginTransaction();
       	try {
          if(!$viaje->usuarioApuntado($idusuario,$password)){
           		$viaje->addUsuario($usuario);

              $viaje->save($con);
           		$con->commit();
              echo json_encode(["exito" => true]);
          }else{
            echo json_encode(["exito" => false]);
          }

       	  } catch (Exception $e) {
       		$con->rollback(); //en caso de que se produzca alguna excepcion la transacci�n ser� cancelada
       		echo json_encode(["exito" => false]);
       		throw $e;
       	  }


  }

  public function eliminarParticipante($idviaje, $idusuario,$password){
      $con = Propel::getWriteConnection(ViajeTableMap::DATABASE_NAME);
       $usuario = UsuarioQuery::create()->filterByIdusuario($usuarioId)->filterByPassword($password)->findOne();
       $viaje = ViajeQuery::create()->filterByIdviaje($idviaje)->findOne();

        $con->beginTransaction();
        try {
          if($viaje->usuarioApuntado($idusuario,$password)){
              $viaje->removeMensajeUsuario($usuario);

              $viaje->save($con);
              $con->commit();
              echo json_encode(["exito" => true]);
          }else{
            echo json_encode(["exito" => false]);
          }

          } catch (Exception $e) {
          $con->rollback(); //en caso de que se produzca alguna excepcion la transacci�n ser� cancelada
          echo json_encode(["exito" => false]);
          throw $e;
          }


  }

}
