<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=UTF-8');
$autoloader = require_once dirname(__DIR__).'/service/vendor/autoload.php';
$autoloader->add('', __DIR__ . '/generated-classes/');
require './generated-conf/config.php';
use Propel\Runtime\Propel;

/*
$author = new Author();
$author->setFirstName("Leo");
$author->setLastName("Tolstoy");
// no need to save the author yet

$publisher = new Publisher();
$publisher->setName("Viking Press");
// no need to save the publisher yet

$book = new Book();
$book->setTitle("War & Peace");
$book->setIsbn("0140444173");
$book->setPublisher($publisher);
$book->setAuthor($author);
$book->save();

$book = BookQuery::create()
  ->filterByISBN('0140444173')
  ->useAuthorQuery() // returns a new AuthorQuery instance
    ->filterByFirstName('Leo') // this is an AuthorQuery method
  ->endUse() // merges the Authorquery in the main Bookquery and returns the BookQuery
  ->orderByTitle()
  ->limit(10)
  ->find();

var_dump($book);*/





if(strcmp($_POST['tipo'],"nuevoViaje")==0){
		$viaje = new Viaje();
		$viaje->nuevoViaje($_POST['nombre'],$_POST['informacion'],$_POST['destino'],$_POST['precio'],$_POST['fecha_inicio'],$_POST['fecha_final'],$_POST['usuario'],$_POST['password']);
}

   $usuario = new Usuario();

        if(strcmp($_GET['tipo'],"login")==0){
		 $usuario->iniciarSesion($_GET['usuario'],$_GET['password']);
		}

		if(strcmp($_GET['tipo'],"viajes")==0){
		 $viaje = new Viaje();
		 $viaje->viajes();
		}

		if(strcmp($_GET['tipo'],"registrar")==0){
		$usuario = $usuario->registrar($_GET['username'],$_GET['nombre'],$_GET['password'],$_GET['apellido'],'http://viajesengrupo.esy.es/service/script.php?username=dghj&nombre=ghk&apellido=hgfjk&password=dgfhk&email=alexruedaromero94@hotmail.com&cars=Fiat&terms=on',$_GET['email']);
		}
if(strcmp($_GET['tipo'],"nuevoViaje")==0){
		$viaje = new Viaje();
		$viaje->nuevoViaje($_GET['nombre'],$_GET['informacion'],$_GET['destino'],$_GET['precio'],$_GET['fecha_inicio'],$_GET['fecha_final'],$_GET['usuario'],$_GET['password']);
		}

			if(strcmp($_GET['tipo'],"misViajes")==0){
		 $viaje->misViajes($_POST['usuario'],$_POST['password']);
		}
		if(strcmp($_GET['tipo'],"viajeInformacion")==0){
		$viaje = new Viaje();
		 $viaje->viajeInformacion($_GET['idviaje'],$_GET['usuario'],$_GET['password']);
		}

		if(strcmp($_GET['tipo'],"nuevomensaje")==0){
		 $mensaje = new Mensaje();
		 $mensaje->escribirMensaje($_GET['descripcion'],$_GET['asunto'],$_GET['usuario'],$_GET['password']);
		}

    if(strcmp($_GET['tipo'],"nuevomensajeviaje")==0){
     $mensajesviaje = new Viaje();
     $mensajesviaje->escribirMensaje($_GET['descripcion'],$_GET['asunto'],$_GET['idviaje'],$_GET['usuario'],$_GET['password']);
    }


		if(strcmp($_GET['tipo'],"mensajes")==0){
				 $mensaje = new Mensaje();
		 $mensaje->mensajes();
		}

    if(strcmp($_GET['tipo'],"mensajesviaje")==0){
				 $mensaje = new Viaje();
		 $mensaje->mensajes($_GET['idviaje']);
		}

		if(strcmp($_GET['tipo'],"perfil")==0){
				 $mensaje = new Viaje();
		 $mensaje->mensajes($_GET['idviaje']);
		}

//ECHO json_encode(["exito" => false]);

 /*









        $viaje = new Viaje();

		if(strcmp($_GET['tipo'],"viajes")==0){

		 $viaje->viajes();
		}





function array_key_exists_r($keys, $search_r)
{

	echo $search_r;
	$keys_r = explode('|',$keys);
	foreach($keys_r as $key)
	if(!array_key_exists($key,$search_r))
	return false;
	return true;

}*/
