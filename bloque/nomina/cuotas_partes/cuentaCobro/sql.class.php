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

    function cadena_sql($configuracion, $conexion, $opcion, $variable = "") {

        switch ($opcion) {
            case "historia_empleado":
                $cadena_sql = " select distinct ";
                $cadena_sql.=" cuota_calculada.cedula_emp,entidad,cuota_calculada.fecha_pago, ";
                $cadena_sql.=" round(cuota_calculada.mesada) as mesada, ";
                $cadena_sql.=" round(ajuste_pension) as ajuste_pension, ";
                $cadena_sql.=" round(mesada_adicional) as mesada_adicional, ";
                $cadena_sql.=" salud.incremento_salud, ";
                $cadena_sql.=" round((cuota_calculada.mesada*((porcen::numeric)/100))) as valor_cuota, ";
                $cadena_sql.=" round(ajuste_pension+salud.incremento_salud+mesada_adicional+(cuota_calculada.mesada*((porcen::numeric)/100))) as total_mes ";
                $cadena_sql.=" from cuota_calculada, porcentaje, entidades_cp, salud ";
                $cadena_sql.=" where cuota_calculada.cedula_emp=porcentaje.cedula_emp ";
                $cadena_sql.=" and porcentaje.nombre_entidad=cuota_calculada.entidad ";
                $cadena_sql.=" and entidades_cp.cedula_emp=cuota_calculada.cedula_emp ";
                $cadena_sql.=" and salud.cedula_emp=cuota_calculada.cedula_emp ";
                $cadena_sql.=" and salud.fecha_pago=cuota_calculada.fecha_pago ";
                $cadena_sql.=" and cuota_calculada.cedula_emp='" . $variable . "'";
                $cadena_sql.="  order by fecha_pago ASC ";
                break;

            case "registro_entidades":

                $cadena_sql = "select ";
                $cadena_sql.="entidades_cp.cedula_emp as cedula,entidades_cp.nombre_entidad as nombre_entidad,direccion,ciudad,fecha_ingreso,fecha_salida, dias,";
                $cadena_sql.="substr(cast(((dias/total)*100) as text),1,position('.' in cast(((dias/total)*100) as text))) || substr(cast(((dias/total)*100) as text),position('.' in cast((dias/total)*100 as text)) + 1,3)  as porcentaje_cuota from ";
                $cadena_sql.="(select ((extract(year from age(fecha_salida::date ,fecha_ingreso::date))*360 + extract(month from age(fecha_salida::date ,fecha_ingreso::date))*30 + extract(day from age(fecha_salida::date ,fecha_ingreso::date)))) as dias,";
                $cadena_sql.="nit_entidad, cedula_emp,(select sum((extract(year from age(fecha_salida::date ,fecha_ingreso::date))*360 + extract(month from age(fecha_salida::date ,fecha_ingreso::date))*30 + extract(day from age(fecha_salida::date ,fecha_ingreso::date)))) as total ";
                $cadena_sql.="from entidades_cp where entidades_cp.cedula_emp ='" . $variable . "') as total from entidades_cp where entidades_cp.cedula_emp='" . $variable . "') as totales, entidades_cp ";
                $cadena_sql.="where totales.nit_entidad=entidades_cp.nit_entidad and totales.cedula_emp=entidades_cp.cedula_emp and entidades_cp.cedula_emp='" . $variable . "'";
                break;

            case "registro_empleados":

                $cadena_sql = "select ";
                $cadena_sql.="emp_nro_iden, ";
                $cadena_sql.=" emp_nombre, ";
                $cadena_sql.=" emp_fecha_pen ";
                $cadena_sql.= " from peemp ";
                $cadena_sql.= "where emp_nro_iden='" . $variable . "' and emp_estado='A'";
                break;

            case "total_mayo":


                $cadena_sql = "select ";
                $cadena_sql.="cedula_emp, round(total), current_date as fecha from cuota_calculada ";
                $cadena_sql.= "where cedula_emp='" . $variable . "'order by fecha_pago DESC LIMIT 1";
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

