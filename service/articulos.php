<?PHP
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

header("Access-Control-Allow-Origin: *");
$autoloader = require_once dirname(__DIR__).'/service/vendor/autoload.php'; 
$autoloader->add('', __DIR__ . '/generated-classes/');
require './generated-conf/config.php';
use Propel\Runtime\Propel;


//en caso de json en vez de jsonp habría que habilitar CORS:
/*header("access-control-allow-origin: *");
$hostname_localhost ="mysql.hostinger.es";
$database_localhost ="u622154777_viaje";h
$username_localhost ="u622154777_viaje";
$password_localhost ="3l1TSzt0CT";*/

  /*try{
	$mysqli = new mysqli($hostname_localhost,$username_localhost,$password_localhost,$database_localhost);
	$query_search = "select * from ARTICULO;";
	//echo $query_search;
	$query_exec = mysqli_query($mysqli, $query_search);
	$json = array();	
		if(mysqli_num_rows($query_exec)){
			while($row=mysqli_fetch_array($query_exec)){
			$json[]=$row;
			}
		}		
		
		//echo $actualizar;
		//echo "update bandeja m set m.nuevo_mensaje  =0 where usuario =".$_POST['usuario'].";";
		$mysqli->close();

	} catch (Exception $e) {
	   // echo 'Excepción capturada: ',  $e->getMessage(), "\n";
	   echo 1;
	   
	}*/
	

if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
    
	 // echo '[{"0":"1","IDARTICULO":"1","1":"eJEMPLO","NOMBRE":"eJEMPLO","2":"SFGHD","MENSAJE":"SFGHD","3":"2016-06-08","FECHA":"2016-06-08","4":"JOSE","USUARIO":"JOSE"},{"0":"23","IDARTICULO":"23","1":"JAJAJ","NOMBRE":"JAJAJ","2":"JAJAJJA","MENSAJE":"JAJAJJA","3":"2016-06-21","FECHA":"2016-06-21","4":"HOLA","USUARIO":"HOLA"}]';

        $usuario = new Usuario();
        if(strcmp($_GET['tipo'],"login")==0){
		 $usuario->iniciarSesion($_GET['usuario'],$_GET['password']);
		}
		if(strcmp($_GET['tipo'],"viajes")==0){
		 $viaje = new Viaje();
		 $viaje->viajes();
		}
		if(strcmp($_GET['tipo'],"misViajes")==0){
		 $viaje = new Viaje();
		 $viaje->misViajes($_GET['usuario'],$_GET['password']);
		}
		if(strcmp($_GET['tipo'],"registrar")==0){
		$usuario = $usuario->registrar($_GET['usuario'],$_GET['nombre'],$_GET['password'],$_GET['apellido'],'http://viajesengrupo.esy.es/service/script.php?username=dghj&nombre=ghk&apellido=hgfjk&password=dgfhk&email=alexruedaromero94@hotmail.com&cars=Fiat&terms=on'); 
		}
		if(strcmp($_GET['tipo'],"nuevoViaje")==0){
		$viaje = new Viaje();
		$viaje->nuevoViaje($_GET['nombre'],$_GET['informacion'],$_GET['destino'],$_GET['precio'],$_GET['fecha_inicio'],$_GET['fecha_final'],$_GET['usuario'],$_GET['password']); 
		}


}


/*
switch($_POST['operacion']){
    case "0":
	try {
	/*$localhost = mysql_connect($hostname_localhost,$username_localhost,$password_localhost)
	or
	trigger_error(mysql_error(),E_USER_ERROR);*/
	
/*	$mysqli = new mysqli($hostname_localhost,$username_localhost,$password_localhost,$database_localhost);
	$query_search = "select * from ARTICULO;";
	//echo $query_search;
	$query_exec = mysqli_query($mysqli, $query_search);
	$json = array();	
		if(mysqli_num_rows($query_exec)){
			while($row=mysqli_fetch_array($query_exec)){
			$json[][]=$row;
			}
		}		
		
		//echo $actualizar;
		//echo "update bandeja m set m.nuevo_mensaje  =0 where usuario =".$_POST['usuario'].";";
		$mysqli->close();

		echo json_encode($json);
	} catch (Exception $e) {
	   // echo 'Excepción capturada: ',  $e->getMessage(), "\n";
	   //echo 1;
	   
	}
    break;*/
	
	


//}

?>