<?php
/*--------------------------------------------------------------------------------------------------------------------------
  @ Derechos de Autor: Vea el archivo LICENCIA.txt que viene con la distribucion
---------------------------------------------------------------------------------------------------------------------------*/

if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sql.class.php");

class sql_adminCuentaCobro extends sql
{
	function cadena_sql($configuracion,$conexion, $opcion,$variable="")
	{
		
		switch($opcion)
		{	
                        case "historia_empleado":	
                                $cadena_sql=" select distinct ";
                                $cadena_sql.=" cuota_calculada.cedula_emp,entidad,cuota_calculada.fecha_pago,";
                                $cadena_sql.=" round(entidades_cp.mesada) as mesada, ";
                                $cadena_sql.=" round(ajuste_pension) as ajuste_pension,";
                                $cadena_sql.=" round(mesada_adicional) as mesada_adicional,";
                                $cadena_sql.=" salud.incremento_salud,";
                                $cadena_sql.=" round((entidades_cp.mesada*((porcen::numeric)/100))) as valor_cuota,";
                                $cadena_sql.=" round(ajuste_pension+salud.incremento_salud+mesada_adicional+(entidades_cp.mesada*((porcen::numeric)/100))) as total_mes";
                                $cadena_sql.=" from cuota_calculada, porcentaje, entidades_cp, salud";
                                $cadena_sql.=" where cuota_calculada.cedula_emp=porcentaje.cedula_emp";
                                $cadena_sql.=" and porcentaje.nombre_entidad=cuota_calculada.entidad";
                                $cadena_sql.=" and entidades_cp.cedula_emp=cuota_calculada.cedula_emp";
                                $cadena_sql.=" and salud.cedula_emp=cuota_calculada.cedula_emp";
                                $cadena_sql.=" and salud.fecha_pago=cuota_calculada.fecha_pago";
                                $cadena_sql.=" and cuota_calculada.cedula_emp='".$variable."'";
                                $cadena_sql.=" order by fecha_pago ASC ";
                                
                                
                                
                            break;
                        
			default:
				$cadena_sql="";
				break;
		}//fin switch
		return $cadena_sql;
	}// fin funcion cadena_sql
	
	
}//fin clase sql_adminCuentaCobro
?>

