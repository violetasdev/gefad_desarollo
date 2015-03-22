<?

/* --------------------------------------------------------------------------------------------------------------------------
  @ Derechos de Autor: Vea el archivo LICENCIA.txt que viene con la distribucion
  --------------------------------------------------------------------------------------------------------------------------- */
/* --------------------------------------------------------------------------------------------------------------------------
 * @name          bloque.php 
 * @author        Paulo Cesar Coronado
 * @revision      Última revisión 12 de enero de 2009
  /*--------------------------------------------------------------------------------------------------------------------------
 * @subpackage		bloqueAdminUsuario
 * @package		bloques
 * @copyright    	Universidad Distrital Francisco Jose de Caldas
 * @version      	0.0.0.1 - Agosto 14 de 2009
 * @author		Maritza Callejas Cely
 * @author			Oficina Asesora de Sistemas
 * @link			N/D
 * @description  	Bloque para gestionar los usuarios del sistema Portal DW. Implementa los casos
 * 			de uso: 
 * 			Registrar cuenta de Usuario
 * 			Editar Datos de Usuario
 * 			Consultar Usuario
 * 			Cambiar el estado del Usuario
 * 			Cambiar Contraseña
  /*-------------------------------------------------------------------------------------------------------------------------- */
if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/bloque.class.php");

include_once("funcion.class.php");
include_once("sql.class.php");

//Clase
class bloqueAdminGeneral extends bloque {

    public function __construct($configuracion) {
        //include_once($configuracion["raiz_documento"].$configuracion["clases"]."/funcionGeneral.class.php");
        $this->sql = new sql_adminGeneral();
        $this->funcion = new funciones_adminGeneral($configuracion, $this->sql);
    }

    function html($configuracion) {
        //Rescatar datos de sesion
        $usuario = $this->funcion->rescatarValorSesion($configuracion, $this->funcion->acceso_db, "usuario");
        $id_usuario = $this->funcion->rescatarValorSesion($configuracion, $this->funcion->acceso_db, "id_usuario");
        switch ($_REQUEST['opcion']) {
            case "editar":
                //Editar los datos básicos del usuario
                $this->funcion->editarRegistro($configuracion, $id_usuario);
                break;

            case "cambiar_clave":
                //Cambiar clave o contraseña del usuario
                $this->funcion->editarRegistro($configuracion, $id_usuario);
                break;

            default:
                //Consultar usuario
//				$this->funcion->consultarUsuario($configuracion,"");
                break;
        }//fin switch
    }

// fin funcion html

    function action($configuracion) {
        switch ($_REQUEST['opcion']) {
            case "editar":
                $this->funcion->editarUsuario($configuracion);
                break;
            case "cambiar_clave":
                $this->funcion->editarContrasena($configuracion);
                break;
            default:

                break;
        }//fin switch
    }

//fin funcion action
}

// fin clase bloqueAdminGeneral
// @ Crear un objeto bloque especifico

$esteBloque = new bloqueAdminGeneral($configuracion);


if (isset($_REQUEST['cancelar'])) {

    include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/funcionGeneral.class.php");
    //Rescatar datos de sesion
    $usuario = $esteBloque->funcion->rescatarValorSesion($configuracion, $esteBloque->funcion->acceso_db, "usuario");
    $id_usuario = $esteBloque->funcion->rescatarValorSesion($configuracion, $esteBloque->funcion->acceso_db, "id_usuario");

    $usuario_sql = $esteBloque->sql->cadena_sql($configuracion, $this->acceso_db, "pagina_subsistema", $id_usuario);
    //echo "<br>sql  ".$usuario_sql;
    $usu = $esteBloque->funcion->ejecutarSQL($configuracion, $esteBloque->funcion->acceso_db, $usuario_sql, "busqueda");

    if ($usu)
        $variable = "pagina=" . $usu[0][3];
    //echo "<br>variab   ".$variable;
    $pagina = $configuracion["host"] . $configuracion["site"] . "/index.php?";
    include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/encriptar.class.php");
    $this->cripto = new encriptar();
    $variable = $this->cripto->codificar_url($variable, $configuracion);
    unset($_REQUEST['action']);
    echo "<script>location.replace('" . $pagina . $variable . "')</script>";
}


if (!isset($_REQUEST['action'])) {
    $esteBloque->html($configuracion);
} else {
    $esteBloque->action($configuracion);
}
?>


