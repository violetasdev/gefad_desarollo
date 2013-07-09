<?
/*--------------------------------------------------------------------------------------------------------------------------
  @ Derechos de Autor: Vea el archivo LICENCIA.txt que viene con la distribucion
---------------------------------------------------------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------------------------------------------------------
* @name          bloque.php 
* @author        Paulo Cesar Coronado
* @revision      Última revisión 12 de enero de 2009
/*--------------------------------------------------------------------------------------------------------------------------
* @subpackage		bloqueAdminSolicitudAprobarGiro
* @package		bloques
* @copyright    	Universidad Distrital Francisco Jose de Caldas
* @version      	0.0.0.1 - mayo 10 de 2013
* @author		Maritza Callejas Cely
* @author		Oficina Asesora de Sistemas
* @link			N/D
* @description  	Bloque para las solicitudes de aprobacion de giro. Implementa los casos
*			de uso: 
*			Solicitud aprobar Giro
*			
/*--------------------------------------------------------------------------------------------------------------------------*/
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

include_once($configuracion["raiz_documento"].$configuracion["clases"]."/bloque.class.php");
include_once("funcion.class.php");
include_once("sql.class.php");



//Clase
class bloqueAdminSolicitudAprobarGiro extends bloque
{

	 public function __construct($configuracion)
	{
 		$this->sql = new sql_adminSolicitudAprobarGiro();
 		$this->funcion = new funciones_adminSolicitudAprobarGiro($configuracion, $this->sql);
 		
	}
	
	
	function html($configuracion)
	{   //Rescatar datos de sesion
            $usuario = $this->funcion->rescatarValorSesion($configuracion, $this->funcion->acceso_db, "usuario");
            $id_usuario = $this->funcion->rescatarValorSesion($configuracion, $this->funcion->acceso_db, "id_usuario");
            $_REQUEST['opcion']=(isset($_REQUEST['opcion'])?$_REQUEST['opcion']:'');
            //$vigencia=(isset($_REQUEST['vigencia'])?$_REQUEST['vigencia']:date('Y'));
            $tema=(isset($tema)?$tema:'');
            switch ($_REQUEST['opcion'])
		{      case "revisarNominasGeneradas":
                                $this->funcion->revisarNominasGeneradas();
                                break;
	               case 'solicitar_aprobacion_giro':
                                $aprobados=array();
                                $total = (isset($_REQUEST['total_registros'])?$_REQUEST['total_registros']:0);
                                $cont=0;
                                for($i=0;$i<$total;$i++){
                                        if(isset($_REQUEST["id_nomina_".$i]))
                                                    {   $aprobados[$cont]['id_nomina']=$_REQUEST["id_nomina_".$i];
                                                        $aprobados[$cont]['vigencia']=$_REQUEST["vigencia_".$i];
                                                        $cont++;
                                                    }
                                    }
            	  		$this->funcion->revisarSolicitudAprobacionGiro($aprobados);
				break;
                      
                        default:
		  		$this->funcion->consultar();
                                break;	
				
		}//fin switch
		
	}// fin funcion html
	
	
	function action($configuracion)
	{   //echo "llego";exit;
		switch($_REQUEST['opcion'])
		{	
                     case 'solicitar_aprobacion_giro':
                            //recupera los datos para realizar la busqueda de usuario	
                          	$pagina = $configuracion["host"].$configuracion["site"]."/index.php?";
                                $variable = "pagina=" . $_REQUEST["pagina"];
                                //$variable.= "&opcion=" . $_REQUEST["opcion"];
                                foreach ($_REQUEST as $key => $value) 
                                    { if (!isset($_REQUEST[$configuracion['enlace']]) && $key != 'action' && $key != 'pagina' )  
                                                { $variable .= "&$key=" . $_REQUEST[$key];}
                                    }
                                include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
				$this->cripto = new encriptar();
				$variable = $this->cripto->codificar_url($variable,$configuracion);
				echo "<script>location.replace('".$pagina.$variable."')</script>";
                        break;


                      default: 
				//recupera los datos para realizar la busqueda de usuario	
                          	$pagina = $configuracion["host"].$configuracion["site"]."/index.php?";
                                $variable = "pagina=" . $_REQUEST["pagina"];
                                foreach ($_REQUEST as $key => $value) {
                                    if (!isset($_REQUEST[$configuracion['enlace']]) && $key != 'action' && $key != 'pagina') {
                                        $variable .= "&$key=" . $_REQUEST[$key];
                                    }
                                }
				include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
				$this->cripto = new encriptar();
				$variable = $this->cripto->codificar_url($variable,$configuracion);
				echo "<script>location.replace('".$pagina.$variable."')</script>";

				break;
		}//fin switch
	}//fin funcion action
	
	
}// fin clase bloquenom_adminNovedad
// @ Crear un objeto bloque especifico

$esteBloque = new bloqueAdminSolicitudAprobarGiro($configuracion);
if(isset($_REQUEST['cancelar']))
{   unset($_REQUEST['action']);		
	$pagina = $configuracion["host"].$configuracion["site"]."/index.php?";
	$variable = "pagina=nom_adminSolicitudAprobarGiroOrdenador";
	$variable .= "&opcion=consultar";
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
	$this->cripto = new encriptar();
	$variable = $this->cripto->codificar_url($variable,$configuracion);
	
	echo "<script>location.replace('".$pagina.$variable."')</script>";
}
//var_dump($_REQUEST);exit;
//echo "action".$_REQUEST['action'];exit;
if(!isset($_REQUEST['action']))
{
	$esteBloque->html($configuracion);
}
else
{
	$esteBloque->action($configuracion);

}


?>


