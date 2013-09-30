
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

class funciones_formRecaudo extends funcionGeneral {

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

        //Conexión a Postgres 
        $this->acceso_pg = $this->conectarDB($configuracion, "cuotas_partes");

        //Datos de sesion
        $this->usuario = $this->rescatarValorSesion($configuracion, $this->acceso_db, "id_usuario");
        $this->identificacion = $this->rescatarValorSesion($configuracion, $this->acceso_db, "identificacion");
        $this->configuracion = $configuracion;
        $this->html_formRecaudo = new html_formRecaudo($configuracion);
    }

    function inicio() {
        $this->html_formRecaudo->form_valor();
    }

    function consultarEntidades($parametros) {
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "consultarEntidades", $parametros);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;
    }

    function consultarRecaudos($parametros) {
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "consultarRecaudos", $parametros);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;
    }

    function consultarCobros($parametros) {
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "consultarCobros", $parametros);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;
    }

    function mostrarRecaudos() {
        $cedula = array('cedula' => (isset($_REQUEST['cedula_emp']) ? $_REQUEST['cedula_emp'] : ''));
        $datos_entidad = $this->consultarEntidades($cedula);
        $this->html_formRecaudo->datosRecaudos($cedula, $datos_entidad);
    }

    function registrarPago($parametros) {
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "registrarPago", $parametros);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;
    }

    function registrarPagoCobro($parametros) {
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "registrarPagoCobro", $parametros);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;
    }
    
    function actualizarEstadoCobro($parametro){
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "actualizarCobro", $parametro);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;        
    }

    function mostrarFormulario($cuentas_pago) {
        $this->html_formRecaudo->formularioRecaudos($cuentas_pago);
    }

    function historiaRecaudos($datos_consulta) {
        $parametros = array('cedula' => $datos_consulta['cedula_emp'], 'entidad' => $datos_consulta['hlab_nitprev']);

        $datos_recaudos = $this->consultarRecaudos($parametros);
        $datos_cobros = $this->consultarCobros($parametros);

        $this->html_formRecaudo->historiaRecaudos($datos_recaudos, $datos_cobros);
    }

    function procesarFormulario($datos) {

        foreach ($datos as $key => $value) {

            if ($datos[$key] == "") {
                echo "<script type=\"text/javascript\">" .
                "alert('Formulario NO diligenciado correctamente');" .
                "</script> ";
                $pagina = $this->configuracion["host"] . $this->configuracion["site"] . "/index.php?";
                $variable = 'pagina=formularioRecaudo';
                $variable.='&opcion=';
                $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                echo "<script>location.replace('" . $pagina . $variable . "')</script>";
                exit;
            }
        }

        if (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $datos['fecha_resolucion'])) {
            echo "<script type=\"text/javascript\">" .
            "alert('Formato fecha diligenciado incorrectamente');" .
            "</script> ";
            $pagina = $this->configuracion["host"] . $this->configuracion["site"] . "/index.php?";
            $variable = 'pagina=formularioRecaudo';
            $variable.='&opcion=';
            $variable = $this->cripto->codificar_url($variable, $this->configuracion);
            echo "<script>location.replace('" . $pagina . $variable . "')</script>";
            exit;
        }

        if (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $datos['fecha_pago'])) {
            echo "<script type=\"text/javascript\">" .
            "alert('Formato fecha diligenciado incorrectamente');" .
            "</script> ";
            $pagina = $this->configuracion["host"] . $this->configuracion["site"] . "/index.php?";
            $variable = 'pagina=formularioRecaudo';
            $variable.='&opcion=';
            $variable = $this->cripto->codificar_url($variable, $this->configuracion);
            echo "<script>location.replace('" . $pagina . $variable . "')</script>";
            exit;
        }
        
    
        $datos_recaudo = $this->registrarPago($datos);
        
       
        foreach ($datos as $key => $value) {
            if (strstr($key, 'consec_cc')) {
                $valor = substr($key, strlen('consec_cc'));

                $parametros = array(
                    'consecutivo' => $datos['consec_cc' . $valor],
                    'cedula_emp' => $datos['cedula_emp'],
                    'nit_empleador' => $datos['nit_empleador'],
                    'nit_previsional' => $datos['nit_previsional'],
                    'total_recaudo' => $datos['valor_pago'.$valor],
                    'fecha_pago' => $datos['fecha_pago']);
                
                $datos_recaudo_cobro = $this->registrarPagoCobro($parametros);
                $actualizar_cobro=$this->actualizarEstadoCobro($parametros['consecutivo']);
            }
        }
        
        
        
        exit;

        echo "<script type=\"text/javascript\">" .
        "alert('Datos Registrados');" .
        "</script> ";

        $pagina = $this->configuracion["host"] . $this->configuracion["site"] . "/index.php?";
        $variable = "pagina=reportesCuotas";
        $variable .= "&opcion=";
        $variable = $this->cripto->codificar_url($variable, $this->configuracion);
        echo "<script>location.replace('" . $pagina . $variable . "')</script>";
    }

}

?>