
<?

/*
  ############################################################################
  #    UNIVERSIDAD DISTRITAL Francisco Jose de Caldas                        #
  #    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
  ############################################################################
 */
/* --------------------------------------------------------------------------------------------------------------------------
  @ Derechos de Autor: Vea el archivo LICENCIA.txt que viene con la distribucion
  --------------------------------------------------------------------------------------------------------------------------- */
/* ---------------------------------------------------------------------------------------
  |				Control Versiones				    	|
  ----------------------------------------------------------------------------------------
  | fecha      |        Autor            | version     |              Detalle            |
  ----------------------------------------------------------------------------------------
  | 18/05/2013 | Violet Sosa             | 0.0.0.1     |                                 |
  ----------------------------------------------------------------------------------------
  | 02/08/2013 | Violet Sosa             | 0.0.0.2     |                                 |
  ----------------------------------------------------------------------------------------
 */

/* --------------------------------------------------------------------------------------------------------------------------
  @ Derechos de Autor: Vea el archivo LICENCIA.txt que viene con la distribucion
  --------------------------------------------------------------------------------------------------------------------------- */


if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/funcionGeneral.class.php");
include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/navegacion.class.php");
include_once("html.class.php");

class funciones_formIPC extends funcionGeneral {

    function __construct($configuracion, $sql) {
        //[ TO DO ]En futuras implementaciones cada usuario debe tener un estilo		
        //include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
        include ($configuracion["raiz_documento"] . $configuracion["estilo"] . "/basico/tema.php");
        include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/encriptar.class.php");
        include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/log.class.php");

        $this->cripto = new encriptar();
        $this->log_us = new log();
        $this->tema = $tema;
        $this->sql = $sql;

        //Conexion General
        $this->acceso_db = $this->conectarDB($configuracion, "mysqlFrame");

        //Conexión a Postgres -
        $this->acceso_indice = $this->conectarDB($configuracion, "cuotas_partes");
        //Datos de sesion

        $this->usuario = $this->rescatarValorSesion($configuracion, $this->acceso_db, "id_usuario");
        $this->identificacion = $this->rescatarValorSesion($configuracion, $this->acceso_db, "identificacion");

        $this->configuracion = $configuracion;

        $this->html_formIPC = new html_formIPC($configuracion);
    }

    function mostrarFormulario() {

        $this->html_formIPC->formularioIPC();
    }

    function ConsultarIndice() {
        $parametros = "";
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_indice, "Consultar", $parametros);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_indice, $cadena_sql, "busqueda");
        $this->html_formIPC->tablaIPC($datos);
    }

    function procesarFormulario($datos) {

        foreach ($datos as $key => $value) {

            if ($datos[$key] == "") {
                echo "<script type=\"text/javascript\">" .
                "alert('Formulario NO diligenciado correctamente');" .
                "</script> ";
                $pagina = $this->configuracion["host"] . $this->configuracion["site"] . "/index.php?";
                $variable = 'pagina=reportesCuotaFormularis';
                $variable.='&opcion=';
                $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                echo "<script>location.replace('" . $pagina . $variable . "')</script>";
                exit;
            }
        }

        if (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $datos['fecha_consultar'])) {

            echo "<script type=\"text/javascript\">" .
            "alert('Formato fecha diligenciado incorrectamente');" .
            "</script> ";
            $pagina = $this->configuracion["host"] . $this->configuracion["site"] . "/index.php?";
            $variable = 'pagina=formularioIPC';
            $variable.='&opcion=';
            $variable = $this->cripto->codificar_url($variable, $this->configuracion);
            echo "<script>location.replace('" . $pagina . $variable . "')</script>";
            exit;
        }

        $parametros = "";
        $anio = substr($datos['fecha_consultar'], 6, 10);
    
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_indice, "VeriAnio", $parametros);
        $verificacion = $this->ejecutarSQL($this->configuracion, $this->acceso_indice, $cadena_sql, "busqueda");

        foreach ($verificacion as $key => $value) {
            $Ani_ = $verificacion[$key]['fecha'];
            $Ani_ = substr($Ani_, 0, 4);

            if ($anio == $Ani_) {

                echo "<script type=\"text/javascript\">" .
                "alert('El año ya registra indice.');" .
                "</script> ";
                $pagina = $this->configuracion["host"] . $this->configuracion["site"] . "/index.php?";
                $variable = "pagina=formularioIPC";
                $variable .= "&opcion=";
                $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                echo "<script>location.replace('" . $pagina . $variable . "')</script>";
                exit;
            }
        }

        $parametros2 = array(
            'Fecha' => (isset($datos['fecha_consultar']) ? $datos['fecha_consultar'] : ''),
            'Indice_IPC' => (isset($datos['indice_Ipc']) ? $datos['indice_Ipc'] : ''),
            'Suma_fijas' => (isset($datos['sum_fj']) ? $datos['sum_fj'] : ''),);
        

        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_indice, "insertarIPC", $parametros2);
        $datos_registrados = $this->ejecutarSQL($this->configuracion, $this->acceso_indice, $cadena_sql, "busqueda");
        
        $registro[0] = "GUARDAR";
                    $registro[1] = $parametros2['Fecha'] . '|' . $parametros2['Indice_IPC'] . '|' . $parametros2['Suma_fijas']; //
                    $registro[2] = "CUOTAS_PARTES_IPC";
                    $registro[3] = $parametros2['Fecha'] . '|' . $parametros2['Indice_IPC'] . '|' . $parametros2['Suma_fijas']; //
                    $registro[4] = time();
                    $registro[5] = "Registra datos básicos indice IPC para el ";
                    $registro[5] .= " Periodo =" . $parametros2['Fecha'];
                    $this->log_us->log_usuario($registro, $this->configuracion);


        $pagina = $this->configuracion["host"] . $this->configuracion["site"] . "/index.php?";
        $variable = "pagina=formularioIPC";
        $variable .= "&opcion=";
        $variable = $this->cripto->codificar_url($variable, $this->configuracion);
        echo "<script>location.replace('" . $pagina . $variable . "')</script>";
    }

}

?>