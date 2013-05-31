<?

/* --------------------------------------------------------------------------------------------------------------------------
  @ Derechos de Autor: Vea el archivo LICENCIA.txt que viene con la distribucion
  --------------------------------------------------------------------------------------------------------------------------- */
/* --------------------------------------------------------------------------------------------------------------------------
 * @name          bloque.php 
 * @author        Paulo Cesar Coronado
 * @revision      Última revisión 12 de enero de 2009
  /*--------------------------------------------------------------------------------------------------------------------------
 * @subpackage		bloqueAdminNovedad
 * @package		bloques
 * @copyright    	Universidad Distrital Francisco Jose de Caldas
 * @version      	0.0.0.1 - Febrero 14 de 2013
 * @author		Maritza Callejas Cely
 * @author			Oficina Asesora de Sistemas
 * @link			N/D
 * @description  	Bloque para gestionar las novedades del sistema de contratación. Implementa los casos
 * 			de uso: 
 * 			Consultar novedades de contratista
 * 			Registrar novedad de contratista
  /*-------------------------------------------------------------------------------------------------------------------------- */
if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/bloque.class.php");
include_once("funcion.class.php");
include_once("sql.class.php");

//Clase
class bloqueAdminCuentaCobro extends bloque {

    public function __construct($configuracion) {
        $this->sql = new sql_adminCuentaCobro();
        $this->funcion = new funciones_adminCuentaCobro($configuracion, $this->sql);
    }

    function html($configuracion) {
        //Rescatar datos de sesion
        $_REQUEST['opcion'] = (isset($_REQUEST['opcion']) ? $_REQUEST['opcion'] : '');
        $tema = (isset($tema) ? $tema : '');

        switch ($_REQUEST['opcion']) {
            case "verificar":
                $this->funcion->consultarHistoria();
                break;

            
        }//fin switch
    }

// fin funcion html

    function action($configuracion) {

        var_dump($_REQUEST);exit;
        switch ($_REQUEST['opcion']) {


           default:
                //Consultar 
                $this->funcion->consultar();
                break;
        }//fin switch
    }

//fin funcion action
}

// fin clase bloquenom_adminNovedad
// @ Crear un objeto bloque especifico
//echo "bloque";
//var_dump($configuracion);
$esteBloque = new bloqueAdminCuentaCobro($configuracion);



if (isset($_REQUEST['cancelar'])) {
    unset($_REQUEST['action']);
    $pagina = $configuracion["host"] . $configuracion["site"] . "/index.php?";
    $variable = "pagina=cuentaCobro";
    $variable .= "&opcion=consultar";
    include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/encriptar.class.php");
    $this->cripto = new encriptar();
    $variable = $this->cripto->codificar_url($variable, $configuracion);

    echo "<script>location.replace('" . $pagina . $variable . "')</script>";
}
 
    
//echo "action".$_REQUEST['action'];exit;
if (!isset($_REQUEST['action'])) {
    $esteBloque->html($configuracion);
} else {

    $esteBloque->action($configuracion);
}

?>


