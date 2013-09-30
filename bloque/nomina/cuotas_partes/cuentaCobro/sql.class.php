<?php

/* --------------------------------------------------------------------------------------------------------------------------
  @ Derechos de Autor: Vea el archivo LICENCIA.txt que viene con la distribucion
  --------------------------------------------------------------------------------------------------------------------------- */

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/sql.class.php");

class sql_adminCuentaCobro extends sql {

    function cadena_sql($configuracion, $conexion, $opcion, $variable) {

        switch ($opcion) {
            case "historia_empleado":
                $cadena_sql = " select cuotas_partes.entidades_cp.cedula_emp as cedula, entidades_cp.mesada, ";
                $cadena_sql.=" entidades_cp.nombre_entidad as nombre_entidad, ";
                $cadena_sql.=" entidades_cp.fecha_ingreso, fecha_salida, dias, ";
                $cadena_sql.=" substr(cast(((dias/total)*100) as text), 1, position('.' in cast(((dias/total)*100) as text))) || ";
                $cadena_sql.=" substr(cast(((dias/total)*100) as text), position('.' in cast((dias/total)*100 as text)) + 1, 5) as porcentaje_cuota ";
                $cadena_sql.=" from ";
                $cadena_sql.=" (select ((extract(year from age(fecha_salida::date, fecha_ingreso::date))*360 + ";
                $cadena_sql.=" extract(month from age(fecha_salida::date, fecha_ingreso::date))*30 + ";
                $cadena_sql.=" extract(day from age(fecha_salida::date, fecha_ingreso::date)))) as dias, ";
                $cadena_sql.=" nit_entidad, cedula_emp, fecha_ingreso, ";
                $cadena_sql.=" (select sum((extract(year from age(fecha_salida::date, fecha_ingreso::date))*360 + ";
                $cadena_sql.=" extract(month from age(fecha_salida::date, fecha_ingreso::date))*30 + ";
                $cadena_sql.=" extract(day from age(fecha_salida::date, fecha_ingreso::date)))) as total ";
                $cadena_sql.=" from cuotas_partes.entidades_cp where entidades_cp.cedula_emp = '9906') as total ";
                $cadena_sql.=" from cuotas_partes.entidades_cp ";
                $cadena_sql.=" where entidades_cp.cedula_emp = '" . $variable['cedula'] . "') as totales, ";
                $cadena_sql.=" cuotas_partes.entidades_cp ";
                $cadena_sql.=" where totales.cedula_emp = entidades_cp.cedula_emp ";
                $cadena_sql.=" and totales.nit_entidad = entidades_cp.nit_entidad ";
                $cadena_sql.=" and totales.fecha_ingreso = entidades_cp.fecha_ingreso ";
                $cadena_sql.=" and entidades_cp.cedula_emp = '" . $variable['cedula'] . "' ";
                $cadena_sql.=" order by fecha_ingreso ";
                break;

            case "registro_entidades":
                $cadena_sql = "select cuotas_partes.entidades_cp.cedula_emp as cedula, entidades_cp.mesada, ";
                $cadena_sql.=" entidades_cp.nombre_entidad as nombre_entidad, ";
                $cadena_sql.=" entidades_cp.fecha_ingreso,fecha_salida, dias,  ";
                $cadena_sql.=" cuotas_partes.entidades_cp.nit_entidad as nit_entidad, ";
                $cadena_sql.=" substr(cast(((dias/total)*100) as text),1,position('.' in cast(((dias/total)*100) as text))) ||  ";
                $cadena_sql.=" substr(cast(((dias/total)*100) as text),position('.' in cast((dias/total)*100 as text)) + 1,5) as porcentaje_cuota  ";
                $cadena_sql.=" from  ";
                $cadena_sql.=" (select ((extract(year from age(fecha_salida::date ,fecha_ingreso::date))*360 +  ";
                $cadena_sql.=" extract(month from age(fecha_salida::date ,fecha_ingreso::date))*30 +  ";
                $cadena_sql.=" extract(day from age(fecha_salida::date ,fecha_ingreso::date)))) as dias,  ";
                $cadena_sql.=" nit_entidad, cedula_emp, fecha_ingreso, ";
                $cadena_sql.=" (select sum((extract(year from age(fecha_salida::date ,fecha_ingreso::date))*360 +  ";
                $cadena_sql.=" extract(month from age(fecha_salida::date ,fecha_ingreso::date))*30 +  ";
                $cadena_sql.=" extract(day from age(fecha_salida::date ,fecha_ingreso::date)))) as total  ";
                $cadena_sql.=" from cuotas_partes.entidades_cp where entidades_cp.cedula_emp ='" . $variable['cedula'] . "') as total ";
                $cadena_sql.=" from cuotas_partes.entidades_cp  ";
                $cadena_sql.=" where entidades_cp.cedula_emp ='" . $variable['cedula'] . "') as totales, ";
                $cadena_sql.=" cuotas_partes.entidades_cp  ";
                $cadena_sql.=" where totales.cedula_emp=entidades_cp.cedula_emp  ";
                $cadena_sql.=" and totales.nit_entidad=entidades_cp.nit_entidad  ";
                $cadena_sql.=" and totales.fecha_ingreso=entidades_cp.fecha_ingreso ";
                if ($variable['entidad'] != '') {
                    $cadena_sql.=" and entidades_cp.nombre_entidad='" . $variable['entidad'] . "'";
                }
                $cadena_sql.=" and entidades_cp.cedula_emp ='" . $variable['cedula'] . "' ";
                $cadena_sql.=" order by fecha_ingreso ";
                break;

            case "registro_empleados":
                $cadena_sql = " select ";
                $cadena_sql.=" emp_nro_iden, ";
                $cadena_sql.=" emp_nombre, ";
                $cadena_sql.=" emp_fecha_pen ";
                $cadena_sql.=" from peemp ";
                $cadena_sql.=" where emp_nro_iden='" . $variable['cedula'] . "' and emp_estado='A'";
                break;

            case "recaudos":
                $cadena_sql = " SELECT ";
                $cadena_sql.=" cuotas_partes.recaudos_cp.cedula_emp, ";
                $cadena_sql.=" cuotas_partes.recaudos_cp.nit_entidad, ";
                $cadena_sql.=" cuotas_partes.recaudos_cp.resolucion, ";
                $cadena_sql.=" cuotas_partes.recaudos_cp.fecha_resolucion, ";
                $cadena_sql.=" cuotas_partes.recaudos_cp.fecha_desde, ";
                $cadena_sql.=" cuotas_partes.recaudos_cp.fecha_hasta, ";
                $cadena_sql.=" cuotas_partes.recaudos_cp.valor_pagado, ";
                $cadena_sql.=" cuotas_partes.recaudos_cp.fecha_pago, ";
                $cadena_sql.=" cuotas_partes.recaudos_cp.medio_pago, ";
                $cadena_sql.=" cuotas_partes.entidades_cp.nombre_entidad ";
                $cadena_sql.=" from cuotas_partes.recaudos_cp, cuotas_partes.entidades_cp ";
                $cadena_sql.=" where cuotas_partes.recaudos_cp.cedula_emp = '" . $variable['cedula'] . "' ";
                $cadena_sql.=" and cuotas_partes.entidades_cp.nombre_entidad = '" . $variable['entidad'] . "' ";
                $cadena_sql.=" and cuotas_partes.recaudos_cp.cedula_emp = cuotas_partes.entidades_cp.cedula_emp ";
                $cadena_sql.=" and cuotas_partes.recaudos_cp.nit_entidad = cuotas_partes.entidades_cp.nit_entidad ";
                $cadena_sql.=" order by fecha_pago DESC ";
                break;

            case "datos_entidad_liquidar":
                $cadena_sql = "select cuotas_partes.entidades_cp.cedula_emp as cedula, ";
                $cadena_sql.=" entidades_cp.nombre_entidad as nombre_entidad, ";
                $cadena_sql.=" entidades_cp.fecha_ingreso,fecha_salida, dias,  ";
                $cadena_sql.=" substr(cast(((dias/total)*100) as text),1,position('.' in cast(((dias/total)*100) as text))) ||  ";
                $cadena_sql.=" substr(cast(((dias/total)*100) as text),position('.' in cast((dias/total)*100 as text)) + 1,5) as porcentaje_cuota  ";
                $cadena_sql.=" from  ";
                $cadena_sql.=" (select ((extract(year from age(fecha_salida::date ,fecha_ingreso::date))*360 +  ";
                $cadena_sql.=" extract(month from age(fecha_salida::date ,fecha_ingreso::date))*30 +  ";
                $cadena_sql.=" extract(day from age(fecha_salida::date ,fecha_ingreso::date)))) as dias,  ";
                $cadena_sql.=" nit_entidad, cedula_emp, fecha_ingreso, ";
                $cadena_sql.=" (select sum((extract(year from age(fecha_salida::date ,fecha_ingreso::date))*360 +  ";
                $cadena_sql.=" extract(month from age(fecha_salida::date ,fecha_ingreso::date))*30 +  ";
                $cadena_sql.=" extract(day from age(fecha_salida::date ,fecha_ingreso::date)))) as total  ";
                $cadena_sql.=" from cuotas_partes.entidades_cp where entidades_cp.cedula_emp ='" . $variable['cedula'] . "') as total ";
                $cadena_sql.=" from cuotas_partes.entidades_cp  ";
                $cadena_sql.=" where entidades_cp.cedula_emp ='" . $variable['cedula'] . "') as totales, ";
                $cadena_sql.=" cuotas_partes.entidades_cp  ";
                $cadena_sql.=" where totales.cedula_emp=entidades_cp.cedula_emp  ";
                $cadena_sql.=" and totales.nit_entidad=entidades_cp.nit_entidad  ";
                $cadena_sql.=" and totales.fecha_ingreso=entidades_cp.fecha_ingreso ";
                if ($variable['entidad'] != '') {
                    $cadena_sql.=" and entidades_cp.nombre_entidad='" . $variable['entidad'] . "'";
                }
                $cadena_sql.=" and entidades_cp.cedula_emp ='" . $variable['cedula'] . "' ";
                $cadena_sql.=" and nombre_entidad='" . $variable['entidad'] . "'";
                $cadena_sql.=" order by fecha_ingreso ";
                break;



            case "valor_ipc":
                $cadena_sql = " SELECT valor_ipc_cp from cuotas_partes.ipc_cp ";
                $cadena_sql.= " where annio_ipc_cp = '" . $variable . "' ";
                break;

            case "valor_sumafija":
                $cadena_sql = " SELECT valor_sumasfijas_cp from cuotas_partes.sumasfijas_cp ";
                $cadena_sql.="  where annio_sumasfijas_cp='" . $variable . "'";
                break;

            case "valor_mesada_inicial":
                $cadena_sql = " SELECT ";
                $cadena_sql.=" cedula_emp, mesada from cuotas_partes.entidades_cp ";
                $cadena_sql.=" where cedula_emp = '" . $variable['cedula'] . "' ";
                $cadena_sql.=" limit 1 ";
                break;

            case "valor_dtf":
                $cadena_sql = " SELECT ";
                $cadena_sql.=" valor_dtf_cp from cuotas_partes.dtf_cp ";
                $cadena_sql.=" where annio_dtf_cp = '" . $variable . "' ";
                break;

            case "guardarCuentaC":
                $cadena_sql = " INSERT INTO cuotas_partes.cuentac_registro_cp VALUES (   ";
                $cadena_sql.= " '" . $variable['consecutivo'] . "', ";
                $cadena_sql.= " '" . $variable['cc_pensionado'] . "', ";
                $cadena_sql.= " '" . $variable['nit_entidad'] . "',";
                $cadena_sql.= " " . $variable['saldo'] . ", ";
                $cadena_sql.= " '" . $variable['liq_fechain'] . "',";
                $cadena_sql.= " '" . $variable['liq_fechafin'] . "', ";
                $cadena_sql.= " " . $variable['liq_mesada'] . ",";
                $cadena_sql.= " " . $variable['liq_mesada_ad'] . ", ";
                $cadena_sql.= " " . $variable['liq_subtotal'] . ",";
                $cadena_sql.= " " . $variable['liq_incremento_salud'] . ", ";
                $cadena_sql.= " " . $variable['liq_total_sinteres'] . ",";
                $cadena_sql.= " " . $variable['liq_interes'] . ", ";
                $cadena_sql.= " " . $variable['liq_total_cinteres'] . ",";
                $cadena_sql.= " " . $variable['liq_total'] . ", ";
                $cadena_sql.= " '" . $variable['fecha_cc'] . "', ";
                $cadena_sql.= " " . $variable['consecutivo_contador'] . ");";
                break;

            case "consecutivo":
                $cadena_sql = " SELECT contador_consec_cc_cp FROM cuotas_partes.cuentac_registro_cp ";
                $cadena_sql.=" ORDER BY contador_consec_cc_cp DESC ";
                $cadena_sql.=" LIMIT 1";
                break;

            default:
                $cadena_sql = "";
                break;
        }//fin switch
        return $cadena_sql;
    }

// fin funcion cadena_sql
}

//fin clase sql_adminCuentaCobro
?>
