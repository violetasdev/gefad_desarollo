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
        // include_once($configuracion["host"].$configuracion["site"].$configuracion["bloques"]. "/nomina/liquidador/funcion.class.php");

        $this->cripto = new encriptar();
        $this->log_us = new log();
        $this->sql = $sql;

        //Conexion General
        $this->acceso_db = $this->conectarDB($configuracion, "mysqlFrame");

        //Conexión a Postgres 10.20.2.101
        $this->acceso_pg = $this->conectarDB($configuracion, "cuotas_partes");

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

    function listaRegistro() {
        $this->htmlCuentaCobro->form_valores_cuotas_partes();
    }

    function mostrarRegistro($configuracion, $registro, $totalRegistros, $opcion, $variable) {
        switch ($opcion) {
            
        }
    }

    /* __________________________________________________________________________________________________

      Metodos especificos
      __________________________________________________________________________________________________ */

//fin 
    function inicio() {
        $this->htmlCuentaCobro->form_valores_cuotas_partes();
    }

    function generarCuenta() {
        $parametros = array('cedula' => (isset($_REQUEST['cedula_emp']) ? $_REQUEST['cedula_emp'] : ''),
            'fecha_in' => (isset($_REQUEST['fecha_inicial1']) ? $_REQUEST['fecha_inicial1'] : ''),
            'entidad' => (isset($_REQUEST['entidad2']) ? $_REQUEST['entidad2'] : ''),
            'fecha_fin' => (isset($_REQUEST['fecha_final1']) ? $_REQUEST['fecha_final1'] : ''));

        $datos_e = $this->consultarEntidades($parametros);
        $datos_emp = $this->datosPensionado($parametros);

        $this->htmlCuentaCobro->form_generar_cuenta($datos_e, $datos_emp);
    }

    function consultarHistoria2() {
        $parametros = array('cedula' => (isset($_REQUEST['cedula_emp']) ? $_REQUEST['cedula_emp'] : ''),
            'fecha_in' => (isset($_REQUEST['fecha_inicial1']) ? $_REQUEST['fecha_inicial1'] : ''),
            'entidad' => (isset($_REQUEST['entidad2']) ? $_REQUEST['entidad2'] : ''),
            'fecha_fin' => (isset($_REQUEST['fecha_final1']) ? $_REQUEST['fecha_final1'] : ''));

        $datos_historia = $this->consultarHistoriaEmpleado($parametros);
        $datos_entidad = $this->consultarEntidades($parametros);
        $datos_pensionados = $this->datosPensionado($parametros);
        $recaudos = $this->consultarRecaudos($parametros);

        $this->htmlCuentaCobro->form_cuenta_cobro($datos_entidad, $datos_historia, $datos_pensionados, $recaudos);
    }

    function consultarHistoriaEmpleado($parametros) {
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "historia_empleado", $parametros);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;
    }

    function consultarEntidades($parametros) {
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "registro_entidades", $parametros);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;
    }
   
    function consultarRecaudos($parametros) {
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "recaudos", $parametros);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;
    }

    function guardarCC($datos_CC) {

        $parametros = $datos_CC;

        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "guardarCuentaC", $parametros);
        $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");

        $registro[0] = "GUARDAR";
        $registro[1] = $parametros['cc_pensionado'] . '|' . $parametros['consecutivo'] . '|' . $parametros['fecha_cc']; //
        $registro[2] = "CUOTAS_PARTES";
        $registro[3] = $parametros['consecutivo'] . '|' . $parametros['cc_pensionado'] . '|' . $parametros['nit_entidad'] . '|' .
                $parametros['saldo'] . '|' . $parametros['liq_fechain'] . '|' . $parametros['liq_fechafin'] . '|' .
                $parametros['liq_mesada'] . '|' . $parametros['liq_mesada_ad'] . '|' . $parametros['liq_subtotal'] . '|' .
                $parametros['liq_incremento_salud'] . '|' . $parametros['liq_total_sinteres'] . '|' . $parametros['liq_interes'] . '|' .
                $parametros['liq_total_cinteres'] . '|' . $parametros['liq_total'] . '|' . $parametros['fecha_cc'] . '|' . $parametros['consecutivo_contador'];
        $registro[4] = time();
        $registro[5] = "Registra datos cuenta cobro cuotas_partes para el pensionado ";
        $registro[5] .= " identificacion =" . $parametros['cc_pensionado'];
        $this->log_us->log_usuario($registro, $this->configuracion);

        $pagina = $this->configuracion["host"] . $this->configuracion["site"] . "/index.php?";
        $variable = "pagina=reportesCuotas";
        $variable .= "&opcion=";
        $variable = $this->cripto->codificar_url($variable, $this->configuracion);
        echo "<script>location.replace('" . $pagina . $variable . "')</script>";
    }

    /*                   LIQUIDADOR                          */

    function consultarHistoria() {
        $parametros = array(
            'cedula' => (isset($_REQUEST['cedula_emp']) ? $_REQUEST['cedula_emp'] : ''),
            'fecha_in' => (isset($_REQUEST['fecha_inicial1']) ? $this->cambiafecha_format($_REQUEST['fecha_inicial1']) : ''),
            'entidad' => (isset($_REQUEST['entidad2']) ? $_REQUEST['entidad2'] : ''),
            'fecha_fin' => (isset($_REQUEST['fecha_final1']) ? $this->cambiafecha_format($_REQUEST['fecha_final1']) : ''));


        $datos_liquidar = $this->consultarParametrosEntidad($parametros);
        $datos_pensionado = $this->datosPensionado($parametros);
        
        $datos_mesada = $this->mesadaInicial($parametros);
        $datos_recaudos = $this->consultarRecaudos($parametros);

        $datos_historia = $this->consultarHistoriaEmpleado($parametros);
        $datos_entidad = $this->consultarEntidades($parametros);
        $consecutivo = $this->consecutivo($parametros);


        $f_pension = date("Y-m-d", strtotime($datos_pensionado[0]['EMP_FECHA_PEN']));
        $f_actual = date("Y-m-d");
        $porcentaje_cuota = ($datos_liquidar[0]['porcentaje_cuota']) / 100;

        $mesada = $datos_mesada[0]['mesada'];

        list ($FECHAS) = $fechas = $this->GenerarFechas($f_pension, $f_actual);

        $fecha_desde_liquidación = $datos_recaudos[0][5];
        $TOTAL = 0;

        foreach ($FECHAS as $key => $value) {
            $annio = substr($FECHAS[$key], 0, 4);
            $mes = substr($FECHAS[$key], 6, 1);
            $dato_dtf = $annio . "-" . $mes;

            $datos_recaudos = $this->consultarRecaudos($parametros);

            // $fecha_desde_liquidación = $datos_recaudos[0][5];


            $sumafija = $this->obtenerSumafija($annio);
            $DTF = $this->obtenerDTF($dato_dtf);

            $INDICE = $this->obtenerIPC($annio);
            $MESADA = $this->MesadaFecha(($FECHAS[$key]), $mesada, $sumafija);

            $AJUSTEPENSIONAL = $this->AjustePensional(($FECHAS[$key]), $sumafija);

            $CUOTAPARTE = $this->CuotaParte($MESADA, $porcentaje_cuota);
            $MESADAADICIONAL = $this->MesadaAdicional(($FECHAS[$key]), $CUOTAPARTE);
            $INCREMENTOSALUD = $this->IncrementoSalud(($FECHAS[$key]), $CUOTAPARTE);

            $INTERESES = $this->Intereses($FECHAS[$key], $CUOTAPARTE, $MESADAADICIONAL, $fecha_desde_liquidación);

            $TOTAL = $AJUSTEPENSIONAL + $MESADAADICIONAL + $INCREMENTOSALUD + $CUOTAPARTE + $INTERESES;
            $TOTAL = round($TOTAL, 0);

            //**************SALIDA FINAL****************
            $SALIDACP[$key][0] = $FECHAS[$key];
            $SALIDACP[$key][1] = $INDICE;
            $SALIDACP[$key][2] = $MESADA; //sumada
            $SALIDACP[$key][3] = $AJUSTEPENSIONAL;
            $SALIDACP[$key][4] = $MESADAADICIONAL; //sumada
            $SALIDACP[$key][5] = $INCREMENTOSALUD; //sumada
            $SALIDACP[$key][6] = $CUOTAPARTE; //sumada
            $SALIDACP[$key][7] = $INTERESES; //sumada
            $SALIDACP[$key][8] = $TOTAL;
            $mesada = $MESADA;
        }



        $this->htmlCuentaCobro->form_cuenta_cobro($datos_entidad, $datos_historia, $datos_pensionado, $datos_recaudos, $SALIDACP, $fecha_desde_liquidación, $consecutivo);
    }

//consultar

    function consultarParametrosEntidad($parametros) {
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "datos_entidad_liquidar", $parametros);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;
    }

    function datosPensionado($parametros) {
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_sudd, "registro_empleados", $parametros);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_sudd, $cadena_sql, "busqueda");
        return $datos;
    }

    function consecutivo($parametros) {
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "consecutivo", $parametros);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;
    }

    function obtenerIPC($parametro) {
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "valor_ipc", $parametro);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;
    }

    function obtenerSumafija($parametro) {
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "valor_sumafija", $parametro);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;
    }

    function obtenerDTF($parametro) {
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "valor_dtf", $parametro);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;
    }

    function mesadaInicial($parametros) {
        $cadena_sql = $this->sql->cadena_sql($this->configuracion, $this->acceso_pg, "valor_mesada_inicial", $parametros);
        $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");
        return $datos;
    }

// operar

    function GenerarFechas($Fecha_pension, $Fecha_actual) {
        $Anio_p = date("Y", strtotime($Fecha_pension));
        $Mes_p = date("m", strtotime($Fecha_pension));
        $Dia_p = date("d", strtotime($Fecha_pension));

        $Anio_a = date("Y", strtotime($Fecha_actual));
        $Mes_a = date("m", strtotime($Fecha_actual));
        $Dia_a = date("d", strtotime($Fecha_actual));

        settype($Anio_p, "integer");
        settype($Mes_p, "integer");
        settype($Dia_p, "integer");

        settype($Anio_a, "integer");
        settype($Mes_a, "integer");

        $Dia = $Dia_p;

        for ($Anio_p; $Anio_p <= $Anio_a; $Anio_p++) {
            for ($Mes_p; $Mes_p <= 12; $Mes_p++) {

                if ($Anio_p != $Anio_a) {
                    if ($Mes_p <= 9) {
                        $fecha[] = $Anio_p . "-0" . $Mes_p . "-" . $Dia;
                        $Dia = mktime(0, 0, 0, $Mes_p + 2, 0, $Anio_p);
                        $Dia = date("d", $Dia);
                        settype($Dia, "integer");
                        settype($Dia, "integer");
                    } else {
                        $fecha[] = $Anio_p . "-" . $Mes_p . "-" . $Dia;
                        $Dia = mktime(0, 0, 0, $Mes_p + 2, 0, $Anio_p);
                        $Dia = date("d", $Dia);
                        settype($Dia, "integer");
                        settype($Dia, "integer");
                    }
                } elseif ($Mes_p <= $Mes_a) {
                    if ($Mes_p <= 9) {
                        $fecha[] = $Anio_p . "-0" . $Mes_p . "-" . $Dia;
                        $Dia = mktime(0, 0, 0, $Mes_p + 2, 0, $Anio_p);
                        $Dia = date("d", $Dia);
                        settype($Dia, "integer");
                        settype($Dia, "integer");
                    } else {
                        $fecha[] = $Anio_p . "-" . $Mes_p . "-" . $Dia;
                        $Dia = mktime(0, 0, 0, $Mes_p + 2, 0, $Anio_p);
                        $Dia = date("d", $Dia);
                        settype($Dia, "integer");
                        settype($Dia, "integer");
                    }
                }
            }
            $Mes_p = 1;
        }
        return array($fecha);
    }

    function AjustePensional($FECHA, $sumafija) {

        $Anio = substr(date("Y", strtotime($FECHA)), 0, 4);
        $Mes = substr(date("m", strtotime($FECHA)), 0, 2);
        $Dia = substr(date("d", strtotime($FECHA)), 0, 2);

        settype($Anio, "integer");
        settype($Mes, "integer");
        settype($Dia, "integer");

        if ($Anio <= 1988) {
            if ($Mes == 1) {
                $AjustePensional = $sumafija[0][0];
            } else {
                $AjustePensional = 0;
            }
        } else {
            $AjustePensional = 0;
        }
        $AjustePensional = round($AjustePensional, 2);
        return ($AjustePensional);
    }

    function CuotaParte($Mesada, $porcentaje) {
        $Mesadacp = round($Mesada);
        $porcentajecp = round($porcentaje, 4);

        //Cuota Parte	
        $Cuotaparte = $porcentajecp * $Mesadacp;
        $Cuotaparte2 = round($Cuotaparte);

        return($Cuotaparte2);
    }

    function IncrementoSalud($fecha, $cuota_calculada) {
        if ($fecha < '1994-1-1') {
            $Incr_Salud = $cuota_calculada * 0.07;
        } else {
            $Incr_Salud = 0;
        }

        $Incr_S = round($Incr_Salud, 2);
        return ($Incr_S);
    }

    function MesadaFecha($FECHA, $Mesada, $sumafija) {
        $Anio = substr(date("Y", strtotime($FECHA)), 0, 4);
        $Mes = substr(date("m", strtotime($FECHA)), 0, 2);

        settype($Anio, "integer");
        settype($Mes, "integer");
        settype($Dia, "integer");

        $Mesada = round($Mesada);

        $INDICE = $this->obtenerIPC($Anio);
        //Ajuste Pensional
        $AJUSTEPENSIONAL = $this->AjustePensional($FECHA, $sumafija);

        if ($Mes == 1) {
            $Mesada_Fecha = ($Mesada * $INDICE[0][0]) + $Mesada + $AJUSTEPENSIONAL;
        } else {
            $Mesada_Fecha = ($Mesada);
        }

        $Mesada_Fecha = round($Mesada_Fecha, 2);
        return ($Mesada_Fecha);
    }

    //MesadaAdicional
    //$cuota_calculada Cuota Parte Calculada
    function MesadaAdicional($FECHA, $cuota_calculada) {
        //Rescatando Año , Mes y Dia
        $Anio = substr(date("Y", strtotime($FECHA)), 0, 4);
        $Mes = substr(date("m", strtotime($FECHA)), 0, 2);

        settype($Anio, "integer");
        settype($Mes, "integer");

        if ($Anio >= 1994) {
            if ($Mes == 6) {
                $MesaAD = $cuota_calculada;
            } elseif ($Mes == 12) {
                $MesaAD = $cuota_calculada;
            } else {
                $MesaAD = 0;
            }
        } elseif ($Mes == 12) {
            $MesaAD = $cuota_calculada;
        } else {
            $MesaAD = 0;
        }

        $MesaAD = round($MesaAD, 2);
        return ($MesaAD);
    }

    function cambiafecha_format($fecha) {
        ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
        $fechana = $mifecha[3] . "-" . $mifecha[2] . "-" . $mifecha[1];
        return $fechana;
    }

    //Rescatando DTF
    function RescatarDTF($FECHA, $fecha_liquidacion) {
        $Anio = substr(date("Y", strtotime($FECHA)), 0, 4);
        $Mes = substr(date("m", strtotime($FECHA)), 0, 2);

        settype($Anio, "integer");
        settype($Mes, "integer");

        $fecha1 = strtotime($fecha_liquidacion);
        $fecha2 = strtotime($FECHA);

        settype($fecha1, "integer");
        settype($fecha2, "integer");

        $m = $Mes;
        $res[] = 0;

        if ($fecha2 >= $fecha1) {
            for ($a = $Anio; $a <= date("Y"); $a++) {
                for ($m; $m <= 12; $m++) {
                    if ($a != date("Y")) {
                        $fec = $Anio . "-" . $m;
                        $res[] = ($this->obtenerDTF($fec));
                    } elseif ($Anio == date("Y")) {
                        for ($r = 1; $r < date("m"); $r++) {
                            $fec2 = $Anio . "-" . $r;
                            $res[] = ($this->obtenerDTF($fec2));
                        }
                    } else {
                        $res[] = 0;
                    }
                }
                $m = 1;
                $Anio = $Anio + 1;
            }
        }
        //var_dump($res);
        return ($res);
    }

    function Intereses($FECHA, $cuota_parte, $mesada_ad, $fecha_liquidacion) {
        $Anio = substr(date("Y", strtotime($FECHA)), 0, 4);
        $Mes = substr(date("m", strtotime($FECHA)), 0, 2);

        settype($Anio, "integer");
        settype($Mes, "integer");

        $dtf = ($this->RescatarDtf($FECHA, $fecha_liquidacion));
        // var_dump($dtf);

        $var2 = 1;

        if ($FECHA < (strtotime(date("Y-m")))) {

            foreach ($dtf as $key => $value) {
                $var = ($dtf[$key][0][0]);
                $var = ($var + 1);
                $var2 = $var * $var2;
            }
            // echo $var2 = round($var2, 6) . '<br>';

            $cuota_parte_i = $cuota_parte;
            $mesadaadicional = $mesada_ad;

            $a = ($cuota_parte_i + $mesadaadicional) * $var2;
            $b = $cuota_parte_i + $mesadaadicional;

            $interes_Fecha = $a - $b;
        } else {
            $interes_Fecha = 0;
        }
        $interes_Fecha = round($interes_Fecha, 2);

        // echo $Anio.'--'.$interes_Fecha.'<br>';
        return ($interes_Fecha);
    }

}

// fin de la clase
?>