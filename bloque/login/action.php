<?
/*
 ############################################################################
#    UNIVERSIDAD DISTRITAL Francisco Jose de Caldas                        #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado 2004 - 2006                                      #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/

/****************************************************************************

login.action.php

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 24 de noviembre de 2005

******************************************************************************
* @subpackage
* @package	formulario
* @copyright
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
*
*
* Script de procesamiento del formulario de autenticacion de usuarios
*
*******************************************************************************/
?><?

if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;
		
}
$acceso_db=new dbms($configuracion);

if ($acceso_db->probar_conexion()==TRUE)
{
	$nueva_sesion=new sesiones($configuracion);
	$nueva_sesion->especificar_enlace($acceso_db->obtener_enlace());
	$esta_sesion=$nueva_sesion->numero_sesion();
	$acceso_db->vaciar_temporales($configuracion,$esta_sesion);
	$nueva_sesion->borrar_sesion($configuracion,$esta_sesion);


	$cadena_sql="SELECT DISTINCT ";
	$cadena_sql.=$configuracion["prefijo"]."registrado.id_usuario, ";
	$cadena_sql.=$configuracion["prefijo"]."registrado.nombre, ";
	$cadena_sql.=$configuracion["prefijo"]."registrado_subsistema.id_subsistema, ";
	$cadena_sql.=$configuracion["prefijo"]."registrado_subsistema.estado, ";
	$cadena_sql.=$configuracion["prefijo"]."registrado.identificacion ";
	$cadena_sql.="FROM ";
	$cadena_sql.=$configuracion["prefijo"]."registrado ";
	$cadena_sql.="INNER JOIN ";
	$cadena_sql.=$configuracion["prefijo"]."registrado_subsistema ";
	$cadena_sql.="ON ";
	$cadena_sql.=$configuracion["prefijo"]."registrado.id_usuario=".$configuracion["prefijo"]."registrado_subsistema.id_usuario ";
	$cadena_sql.="WHERE ";
	$cadena_sql.=$configuracion["prefijo"]."registrado.usuario='".$_REQUEST["usuario"]."' ";
	$cadena_sql.="AND ";
	$cadena_sql.=$configuracion["prefijo"]."registrado.clave='".$_POST['clave']."' ";
	$cadena_sql.="AND ";
	$cadena_sql.=$configuracion["prefijo"]."registrado_subsistema.estado=1 ";
	$cadena_sql.="AND ";
	$cadena_sql.=$configuracion["prefijo"]."registrado_subsistema.fecha_fin >= '".date('Y-m-d')."' ";
	$cadena_sql.="ORDER BY ";
	$cadena_sql.=$configuracion["prefijo"]."registrado_subsistema.id_subsistema ASC";


	//echo $cadena_sql; exit;
	$campos=$acceso_db->registro_db($cadena_sql,0);
	$registro=$acceso_db->obtener_registro_db();

	if($campos==0)
	{
		unset($_REQUEST['action']);

		$pagina=$configuracion["host"].$configuracion["site"]."/index.php?";
		$variable="pagina=index";
		$variable.="&no_usuario=1";
		include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
		$cripto=new encriptar();
		$variable=$cripto->codificar_url($variable,$configuracion);

		echo "<script>location.replace('".$pagina.$variable."')</script>";
			
	}
	else
	{
		$id_usuario=$registro[0][0];
		$usuario=$registro[0][1];
		$acceso=$registro[0][2];
		$identificacion=$registro[0][4];
		//inicia la busqueda de sesiones antiguas guardadas
		$user['var']='id_usuario';
		$user['vl']=$id_usuario;
		$sesion_ant=$nueva_sesion->rescatar_id_sesion($configuracion,$user);
		if($sesion_ant)
		{
			foreach ($sesion_ant as $key => $value)
			{
				$nueva_sesion->borrar_sesion($configuracion,$sesion_ant[$key][0]);

			}
		}


		$esta_sesion=$nueva_sesion->numero_sesion();
		if (strlen($esta_sesion) != 32)
		{
			$nueva_sesion->especificar_usuario($usuario);
			$nueva_sesion->especificar_nivel($acceso);
			$la_sesion=$nueva_sesion->crear_sesion($configuracion,'','');
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"id_usuario",$id_usuario,$la_sesion);
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"identificacion",$identificacion,$la_sesion);
		}
		else
		{
			$resultado = $nueva_sesion->borrar_valor_sesion($configuracion,"usuario",$esta_sesion);
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"usuario",$usuario,$esta_sesion);
			$resultado = $nueva_sesion->borrar_valor_sesion($configuracion,"acceso",$esta_sesion);
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"acceso",$acceso,$esta_sesion);
			$resultado = $nueva_sesion->borrar_valor_sesion($configuracion,"id_usuario",$esta_sesion);
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"id_usuario",$id_usuario,$esta_sesion);
			$resultado = $nueva_sesion->borrar_valor_sesion($configuracion,"expiracion",$esta_sesion);
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"expiracion",time()+$configuracion["expiracion"],$esta_sesion);
			$resultado = $nueva_sesion->borrar_valor_sesion($configuracion,"identificacion",$esta_sesion);
			$resultado = $nueva_sesion->guardar_valor_sesion($configuracion,"identificacion",$identificacion,$esta_sesion);
		}

		if($campos>=1)
		{
			$cadena_sql="SELECT ";
			$cadena_sql.="id_pagina, ";
			$cadena_sql.="nombre ";
			$cadena_sql.="FROM ";
			$cadena_sql.=$configuracion["prefijo"]."subsistema ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_subsistema=";
			$cadena_sql.=$acceso." ";
			$cadena_sql.="LIMIT 1";
				
			$campos=$acceso_db->registro_db($cadena_sql,0);
				
			if($campos>0)
			{
				$registro=$acceso_db->obtener_registro_db();
				$variable="pagina=".$registro[0][1];
			}
			else
			{
				echo "No se logr&oacte; rescatar una secci&oacte;n v&aacute;lida";
			}

			include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
			$pagina=$configuracion["host"].$configuracion["site"]."/index.php?";
			$cripto=new encriptar();
			$variable=$cripto->codificar_url($variable,$configuracion);
			echo "<script>location.replace('".$pagina.$variable."')</script>";
		}
		else
		{
			//El usuario esta registrado con mas de un perfil.

		}
	}
}
else
{
	include_once($configuracion["raiz_documento"].$configuracion["clase"]."/mensaje.class.php");

	$el_mensaje=new mensaje;
	$el_mensaje->mensaje("error_conexion",$configuracion);
	exit;
}



?>
