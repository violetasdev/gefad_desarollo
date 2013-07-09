<?php

/* --------------------------------------------------------------------------------------------------------------------------
  @ Derechos de Autor: Vea el archivo LICENCIA.txt que viene con la distribucion
  --------------------------------------------------------------------------------------------------------------------------- */
/* ---------------------------------------------------------------------------------------
  |				Control Versiones				    	|
  ----------------------------------------------------------------------------------------
  | fecha      |        Autor            | version     |              Detalle            |
  ----------------------------------------------------------------------------------------
  | 14/02/2013 | Maritza Callejas C.  	| 0.0.0.1     |                                 |
  ----------------------------------------------------------------------------------------
 */


if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/funcionGeneral.class.php");
include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/navegacion.class.php");
include_once("html.class.php");

class funciones_adminCuentaCobro extends funcionGeneral {

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
        $this->acceso_db = $this->conectarDB($configuracion, "cuotasP2");

        //Datos de sesion

        $this->usuario = $this->rescatarValorSesion($configuracion, $this->acceso_db, "id_usuario");
        $this->identificacion = $this->rescatarValorSesion($configuracion, $this->acceso_db, "identificacion");

        $this->configuracion = $configuracion;

        $this->htmlCuentaCobro = new html_adminCuentaCobro($configuracion);
    }

    function nuevoRegistro($configuracion, $tema, $acceso_db) {
        $registro = (isset($registro) ? $registro : '');
        $this->form_usuario($configuracion, $registro, $this->tema, "");
    }

    function editarRegistro($configuracion, $tema, $id, $acceso_db, $formulario) {
        $this->cadena_sql = $this->sql->cadena_sql($configuracion, $this->acceso_db, "usuario", $id);

        $registro = $this->acceso_db->ejecutarAcceso($this->cadena_sql, "busqueda");
        if ($_REQUEST['opcion'] == 'cambiar_clave') {
            $this->formContrasena($configuracion, $registro, $this->tema, '');
        } else {
            $this->form_usuario($configuracion, $registro, $this->tema, '');
        }
    }

    function corregirRegistro() {
        
    }

    function listaRegistro($configuracion, $id_registro) {
        
    }

    function mostrarRegistro($configuracion, $registro, $totalRegistros, $opcion, $variable) {
        switch ($opcion) {
            
        }
    }

    /* __________________________________________________________________________________________________

      Metodos especificos
      __________________________________________________________________________________________________ */

    function consultar() {
        
        var_dump($_REQUEST);exit;
        $this->htmlCuentaCobro->form_valores_cuotas_partes();
    }

//fin funcion consultar novedades

    function consultarHistoria() {
        //echo $_REQUEST['cedula_emp'];
        $cedula = (isset($_REQUEST['cedula_emp']) ? $_REQUEST['cedula_emp'] : '');
        $datos_historia = $this->consultarHistoriaEmpleado($cedula);
        //var_dump($datos_historia);
    }

    function consultarHistoriaEmpleado($cedula) {

        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_db, "historia_empleado", $cedula);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_db, $cadena_sql, "busqueda");
        return $datos;
    }
    
    
    function form_cuenta_cobro($datos) {

        $cedula_emp = (isset($datos[0]['cedula_emp']) ? $datos[0]['cedula_emp'] : '');
        $unidad_ejecutora = (isset($datos_contrato[0]['CODIGO_UNIDAD_EJECUTORA']) ? $datos_contrato[0]['CODIGO_UNIDAD_EJECUTORA'] : '');
        echo "La cédula es: " . $cedula_emp;
        
        ?>
       
        <?
    }

}

// fin de la clase
?>



