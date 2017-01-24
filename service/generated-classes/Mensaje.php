<?php

use Base\Mensaje as BaseMensaje;
use Map\MensajeTableMap;
use Map\ViajeMensajesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
/**
 * Skeleton subclass for representing a row from the 'mensaje' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Mensaje extends BaseMensaje
{

	public function escribirMensaje($descripcion,$asunto,$usuarioId,$password)
	{
	  // get the PDO connection object from Propel
	  
	  $con = Propel::getWriteConnection(MensajeTableMap::DATABASE_NAME);
	   
	  $usuarios = UsuarioQuery::create()->filterByIdusuario($usuarioId)->filterByPassword($password)->find();

	  $con->beginTransaction();

	  try {
	  $resultado = json_encode(["exito" => false]);
		// remove the amount from $fromAccount
	  foreach($usuarios as $usu){
		$this->setUsuario($usu);
		$this->setDescripcion($descripcion);
		$this->setAsunto($asunto);
		$this->save($con);
		$resultado = json_encode(["exito" => true]);
		}
		$con->commit();
		
		echo $resultado;

	  } catch (Exception $e) {
		$con->rollback(); //en caso de que se produzca alguna excepcion la transacción será cancelada
		$resultado = json_encode(["exito" => false]);
		echo $resultado;
		throw $e;
	  }
	}
	

	
	public function mensajes(){
		//$mensajes = MensajeQuery::create()->limit(1);
	    
		/*$viajes = ViajeMensajeQuery::create();
		  
		$mensajes1 = MensajeQuery::create('Mensaje')
		  ->where('Mensaje.idmensaje NOT IN ?',array(123, 1, 563))
		  ->find();*/
         /* $not_in_query = 'SELECT * FROM %s WHERE %s NOT IN (
			SELECT %s
			FROM %s)';
			
			$not_in_query = sprintf(
				$not_in_query,
				MensajeTableMap::COL_IDMENSAJE,
				ViajeMensajesTableMap::COL_IDMENSAJE
				MensajeTableMap::COL_IDMENSAJE,
				ViajeMensajesTableMap::COL_IDMENSAJE,
				ViajeMensajesTableMap::TABLE_NAME
				);
				
  $c->add(MensajeTableMap::COL_IDMENSAJE, $not_in_query, Criteria::CUSTOM);*/
 /* $con = Propel::getConnection();
  $c = new Criteria();
$c->addJoin(MensajeTableMap::COL_IDMENSAJE,ViajeMensajesTableMap::COL_IDMENSAJE, Criteria::LEFT_JOIN);
$c->add(MensajeTableMap::COL_IDMENSAJE, NULL, Criteria::ISNULL);
 
$mensajes1 = $c->doSelect();*/
		  
	/*SELECT * FROM mensaje m LEFT JOIN viaje_mensajes mg ON mg.idmensaje = m.idmensaje WHERE mg.idmensaje IS NULL	  */
    /*SELECT * FROM mensaje m WHERE idmensaje NOT IN (SELECT DISTINCT(idmensaje) FROM viaje_mensajes)*/
							   
	try {

	  $mensajes = MensajeQuery::create()->useViajeMensajesQuery(null, Criteria::LEFT_JOIN)
                                   ->filterByIdmensaje(null,Criteria::ISNULL)
                               ->endUse()
                               ->find(); 
							   
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
}
