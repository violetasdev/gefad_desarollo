<?php

/* --------------------------------------------------------------------------------------------------------------------------
  @ Derechos de Autor: Vea el archivo LICENCIA.txt que viene con la distribucion
  --------------------------------------------------------------------------------------------------------------------------- */
/* ---------------------------------------------------------------------------------------
  |				Control Versiones				    	|
  ----------------------------------------------------------------------------------------
  | fecha      |        Autor            | version     |              Detalle            |
  ----------------------------------------------------------------------------------------
  | 24/05/2013 | Violeta Sosa            | 0.0.0.1     |                                 |
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
        $this->acceso_db = $this->conectarDB($configuracion, "mysqlFrame");

        //Conexión a Postgres 10.20.2.101
        $this->acceso_pg = $this->conectarDB($configuracion, "cuotasP2");

        //Conexión a Oracle SUDD
        $this->acceso_sudd = $this->conectarDB($configuracion, "cuotasP");

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
        $this->htmlCuentaCobro->form_valores_cuotas_partes();
    }

    function mostrarRegistro($configuracion, $registro, $totalRegistros, $opcion, $variable) {
        switch ($opcion) {
            
        }
    }

    /* __________________________________________________________________________________________________

      Metodos especificos
      __________________________________________________________________________________________________ */

    function consultar() {

        $datos = $this->consultarHistoriaEmpleado($_REQUEST["cedula_emp"]);
        $this->form_cuenta_cobro($datos);
    }

//fin funcion consultar novedades

    function consultarHistoria() {
        // echo $_REQUEST['cedula_emp'];
        // exit;
        $cedula = (isset($_REQUEST['cedula_emp']) ? $_REQUEST['cedula_emp'] : '');
        $datos_historia = $this->consultarHistoriaEmpleado($cedula);
        //var_dump($datos_historia);

        $datos_entidad = $this->consultarEntidades($cedula);
        //var_dump($datos_entidad);

        $datos_pensionados = $this->consultarEmpleados($cedula);
        //var_dump($datos_pensionados);
        
        $dato_acumulado=$this->consultarTotal($cedula);
        //var_dump($dato_acumulado);

        $this->htmlCuentaCobro->form_cuenta_cobro($datos_entidad, $datos_historia, $datos_pensionados,$dato_acumulado);
    }

    function consultarHistoriaEmpleado($cedula) {

        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "historia_empleado", $cedula);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;
    }

    function consultarEntidades($cedula) {
        $cadena_sql2 = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "registro_entidades", $cedula);
        $datos2 = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql2, "busqueda");
        return $datos2;
    }

    function consultarEmpleados($cedula) {
        $cadena_sql3 = $this->sql->cadena_sql($this->configuracion, $this->acceso_sudd, "registro_empleados", $cedula);
        //echo'aqui estamos' .$cadena_sql3;
        $datos3 = $this->ejecutarSQL($this->configuracion, $this->acceso_sudd, $cadena_sql3, "busqueda");
        return $datos3;
    }
    
        function consultarTotal($cedula) {
        $cadena_sql4 = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "total_mayo", $cedula);
        //echo'aqui estamos' .$cadena_sql3;
        $datos4 = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql4, "busqueda");
        return $datos4;
    }


}

// fin de la clase
?>



