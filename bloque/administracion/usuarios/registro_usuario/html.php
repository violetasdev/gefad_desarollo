<?
/*
############################################################################
#    UNIVERSIDAD DISTRITAL Francisco Jose de Caldas                        #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado 2004 - 2006                                      #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
/***************************************************************************
  
html.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 1 de Noviembre de 2006

****************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Formulario de registro de usuarios
* @usage        Toda pagina tiene un id_pagina que es propagado por cualquier 
*               metodo. 
*****************************************************************************/
?><?

if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}


include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
//Variables

$formulario="registro_usuario";
$verificar="control_vacio(".$formulario.",'nombre')";
$verificar.="&& control_vacio(".$formulario.",'apellido')";
$verificar.="&& control_vacio(".$formulario.",'correo')";
$verificar.="&& control_vacio(".$formulario.",'usuario')";
$verificar.="&& control_vacio(".$formulario.",'clave')";
$verificar.="&& comparar_contenido(".$formulario.",'clave','clave_2')";
$verificar.="&& longitud_cadena(".$formulario.",'nombre',3)";
$verificar.="&& longitud_cadena(".$formulario.",'apellido',3)";
$verificar.="&& longitud_cadena(".$formulario.",'clave',5)";
$verificar.="&& longitud_cadena(".$formulario.",'usuario',4)";
$verificar.="&& verificar_correo(".$formulario.",'correo')";

include_once($configuracion["raiz_documento"].$configuracion["clases"]."/dbms.class.php");
$acceso_db=new dbms($configuracion);
$enlace=$acceso_db->conectar_db();
if (is_resource($enlace))
{
	
	if(isset($_REQUEST['opcion']))
	{
		$accion=$_REQUEST['opcion'];
		
		switch($accion)
		{
			case "confirmar":
				confirmar_registro($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab,$acceso_db);
				break;		
			case "nuevo":
				nuevo_registro($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab);
				break;
			case "editar":
				editar_registro($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab);
				break;
			case "corregir":
				corregir_registro($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab);
				break;
			case "mostrar":
				mostrar_registro($configuracion,$tema,$accion);
				break;
		}
	}
	else
	{
		$accion="nuevo";
		nuevo_registro($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab);
	}	
}
/****************************************************************************************
*				Funciones						*
****************************************************************************************/


function nuevo_registro($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab)
{
	$contador=0;	
?><script src="<? echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form enctype='multipart/form-data' method='POST' action='index.php' name='<? echo $formulario?>'>
	<table width="100%" align="center" border="0" cellpadding="10" cellspacing="0" >
		<tr>
			<td>
				<table class="tabla_formulario" align="center">
					<tr  class="bloquecentralencabezado">
						<td colspan="2">
							<p><span class="texto_negrita">Formulario de Inscripci&oacute;n</span></p>
						</td>
					</tr>
					<tr>
						<td colspan="2" rowspan="1"><br>Datos Personales<hr class="hr_subtitulo"></td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor="<? echo $tema->celda ?>">
							<font color="red">*</font>Nombres:<br>
						</td>
						<td bgcolor="<? echo $tema->celda ?>">
							<input maxlength="80" size="40" tabindex="<? echo $tab++ ?>" name="nombre"><br>
						</td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor="<? echo $tema->celda ?>">
							<font color="red">*</font>Apellidos:<br>
						</td>
						<td bgcolor="<? echo $tema->celda ?>">
							<input maxlength="80" size="40" tabindex="<? echo $tab++ ?>" name="apellido">
						</td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor='<? echo $tema->celda ?>'>
							<font color="red">*</font>Tipo de Documento
						</td>
						<td bgcolor='<? echo $tema->celda ?>'><?
						include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
						$html=new html();
						$busqueda="SELECT id_tipo,valor FROM ".$configuracion["prefijo"]."variable WHERE tipo='DOCUMENTO' ORDER BY id_tipo";
						$mi_cuadro=$html->cuadro_lista($busqueda,'id_tipo',$configuracion,1,0,FALSE,$tab++);
						echo $mi_cuadro;
						?>		
						</td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor='<? echo $tema->celda ?>'>
							<font color="red">*</font>No Identificaci&oacute;n
						</td>
						<td bgcolor='<? echo $tema->celda ?>'>
							<input type='text' name='identificacion' size='40' maxlength='50' tabindex='<? echo $tab++ ?>' >
						</td>
					</tr>
					<tr>
						<td colspan="2" rowspan="1"><br>Datos de Contacto<hr class="hr_subtitulo"></td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor='<? echo $tema->celda ?>'>
							<font color="red">*</font>Direcci&oacute;n
						</td>
						<td bgcolor='<? echo $tema->celda ?>'>
							<input type='text' name='direccion' size='40' maxlength='255' tabindex='<? echo $tab++ ?>' >
						</td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor='<? echo $tema->celda ?>'>
							<font color="red">*</font>Pa&iacute;s
						</td>
						<td bgcolor='<? echo $tema->celda ?>'><?
						include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
						$html=new html();
						$busqueda="SELECT ";
						$busqueda.="isonum, ";
						$busqueda.="nombre ";
						$busqueda.="FROM ";
						$busqueda.=$configuracion["prefijo"]."pais ";
						$busqueda.="ORDER BY nombre";
						
						$configuracion["ajax_function"]="xajax_pais";
						$configuracion["ajax_control"]="pais";
						
						$mi_cuadro=$html->cuadro_lista($busqueda,"pais",$configuracion,170,2,FALSE,$tab++,"pais");
						echo $mi_cuadro;
						?></td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor='<? echo $tema->celda ?>'>
							<font color="red">*</font>Departamento/Provincia/Estado
						</td>
						<td bgcolor='<? echo $tema->celda ?>'>
						<div id="divRegion"><?
						$busqueda="SELECT ";
						$busqueda.="id_localidad, ";
						$busqueda.="nombre ";
						$busqueda.="FROM ";
						$busqueda.=$configuracion["prefijo"]."localidad ";
						$busqueda.="WHERE ";
						$busqueda.="id_pais=170 ";
						$busqueda.="AND ";
						$busqueda.="tipo=1 ";
						$busqueda.="ORDER BY nombre";
						
						$configuracion["ajax_function"]="xajax_region";
						$configuracion["ajax_control"]="region";
						
						$mi_cuadro=$html->cuadro_lista($busqueda,"region",$configuracion,5,2,FALSE,$tab++,"region");
						echo $mi_cuadro;
						?></div>
						</td>
					</tr>							
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor='<? echo $tema->celda ?>'>
							<font color="red">*</font>Ciudad
						</td>
						<td bgcolor='<? echo $tema->celda ?>'>
						<div id="divCiudad"><?
						
						$busqueda="SELECT ";
						$busqueda.="id_localidad, ";
						$busqueda.="nombre ";
						$busqueda.="FROM ";
						$busqueda.=$configuracion["prefijo"]."localidad ";
						$busqueda.="WHERE ";
						$busqueda.="id_pais=170 ";
						$busqueda.="AND ";
						$busqueda.="id_padre=5 ";						
						$busqueda.="AND ";
						$busqueda.="tipo=2 ";
						$busqueda.="ORDER BY nombre";						
						$mi_cuadro=$html->cuadro_lista($busqueda,'ciudad',$configuracion,1,0,FALSE,$tab++);
						echo $mi_cuadro;
						?></div>
						</td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor='<? echo $tema->celda ?>'>
							Correo Electr&oacute;nico
						</td>
						<td bgcolor='<? echo $tema->celda ?>'>
							<input type='text' name='correo' size='40' maxlength='100' tabindex='<? echo $tab++ ?>' >
						</td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor='<? echo $tema->celda ?>'>
							Tel&eacute;fono
						</td>
						<td bgcolor='<? echo $tema->celda ?>'>
							<input type='text' name='telefono' size='40' maxlength='50' tabindex='<? echo $tab++ ?>' >
						</td>
					</tr>
					<tr>
						<td colspan="2" rowspan="1"><br>Informaci&oacute;n Acad&eacute;mica<hr class="hr_subtitulo"></td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor='<? echo $tema->celda ?>'>
							Formaci&oacute;n Acad&eacute;mica
						</td>
						<td bgcolor='<? echo $tema->celda ?>'><?
						$busqueda="SELECT ";
						$busqueda.="id_formacion, ";
						$busqueda.="tipo ";
						$busqueda.="FROM ";
						$busqueda.=$configuracion["prefijo"]."formacion ";
						$busqueda.="ORDER BY ";
						$busqueda.="id_formacion";
						$mi_cuadro=$html->cuadro_lista($busqueda,'formacion',$configuracion,2,0,FALSE,$tab++);
						echo $mi_cuadro;
						?></td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor='<? echo $tema->celda ?>'>
							Area de Desempeño
						</td>
						<td bgcolor='<? echo $tema->celda ?>'><?
						include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
						$html=new html();
						$busqueda="SELECT ";
						$busqueda.="id_area_desempenno, ";
						$busqueda.="etiqueta ";
						$busqueda.="FROM ";
						$busqueda.=$configuracion["prefijo"]."area_desempenno ";
						$busqueda.="ORDER BY ";
						$busqueda.="id_area_desempenno";						
						$mi_cuadro=$html->cuadro_lista($busqueda,'areaDesempenno',$configuracion,1,0,FALSE,$tab++);
						echo $mi_cuadro;
						?></td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor='<? echo $tema->celda ?>'>
							Instituci&oacute;n
						</td>
						<td bgcolor='<? echo $tema->celda ?>'>
							<input type='text' name='institucion' size='40' maxlength='255' tabindex='<? echo $tab++ ?>' >
						</td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor='<? echo $tema->celda ?>'>
							Pa&iacute;s
						</td>
						<td bgcolor='<? echo $tema->celda ?>'><?
							$busqueda="SELECT ";
							$busqueda.="isonum, ";
							$busqueda.="nombre ";
							$busqueda.="FROM ";
							$busqueda.=$configuracion["prefijo"]."pais ";
							$busqueda.="ORDER BY nombre";
							
							$configuracion["ajax_function"]="xajax_paisFormacion";
							$configuracion["ajax_control"]="paisFormacion";
							
							$mi_cuadro=$html->cuadro_lista($busqueda,"paisFormacion",$configuracion,170,2,FALSE,$tab++,"paisFormacion");
							echo $mi_cuadro;
						?></td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor='<? echo $tema->celda ?>'>
							Departamento/Provincia/Estado
						</td>
						<td bgcolor='<? echo $tema->celda ?>'>
						<div id="divRegionFormacion"><?
						
						$busqueda="SELECT ";
						$busqueda.="id_localidad, ";
						$busqueda.="nombre ";
						$busqueda.="FROM ";
						$busqueda.=$configuracion["prefijo"]."localidad ";
						$busqueda.="WHERE ";
						$busqueda.="id_pais=170 ";
						$busqueda.="AND ";
						$busqueda.="tipo=1 ";
						$busqueda.="ORDER BY nombre";
						
						$configuracion["ajax_function"]="xajax_regionFormacion";
						$configuracion["ajax_control"]="regionFormacion";
						
						$mi_cuadro=$html->cuadro_lista($busqueda,"regionFormacion",$configuracion,5,2,FALSE,$tab++,"regionFormacion");
						echo $mi_cuadro;
						?></div>
						</td>
					</tr>		
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor='<? echo $tema->celda ?>'>
							Ciudad
						</td>
						<td bgcolor='<? echo $tema->celda ?>'><div id="divCiudadFormacion"><?
						
						$html=new html();
						$busqueda="SELECT ";
						$busqueda.="id_localidad, ";
						$busqueda.="nombre ";
						$busqueda.="FROM ";
						$busqueda.=$configuracion["prefijo"]."localidad ";
						$busqueda.="WHERE ";
						$busqueda.="id_pais=170 ";
						$busqueda.="AND ";
						$busqueda.="id_padre=5 ";						
						$busqueda.="AND ";
						$busqueda.="tipo=2 ";
						$busqueda.="ORDER BY nombre";						
						$mi_cuadro=$html->cuadro_lista($busqueda,'ciudadFormacion',$configuracion,1,0,FALSE,$tab++);
						echo $mi_cuadro;
						?></div>
						</td>
					</tr>					
					<tr>
						<td colspan="2" rowspan="1"><br>Datos para la autenticaci&oacute;n<hr class="hr_subtitulo"></td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor="<? echo $tema->celda ?>">
							<font color="red">*</font>Usuario:<br>
						</td>
						<td bgcolor="<? echo $tema->celda ?>">
							<input maxlength="50" size="30" tabindex="<? echo $tab++; ?>" name="usuario">
						</td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor="<? echo $tema->celda ?>">
							<font color="red">*</font>Clave:
						</td>
						<td bgcolor="<? echo $tema->celda ?>">
							<input maxlength="50" size="30" tabindex="<? echo $tab++; ?>" name="clave"  type="password">
						</td>
					</tr>
					<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor="<? echo $tema->celda ?>">
						<font color="red">*</font>Reescriba la clave:<br>
						</td>
						<td bgcolor="<? echo $tema->celda ?>">
							<input maxlength="50" size="30" tabindex="<? echo $tab++; ?>" name="clave_2" type="password">
						</td>
					</tr>
					<tr align='center'>
						<td>
							<input type='hidden' name='action' value='<? echo $formulario ?>'>
							<input value="Enviar" name="aceptar" tabindex='<? echo $tab++ ?>' type="button" onclick="if(<? echo $verificar; ?>){document.forms['<? echo $formulario?>'].submit()}else{false}"><br>								
						</td>
						<td align="center">
							<input name='cancelar' value='Cancelar' type="button" onclick="document.forms['<? echo $formulario?>'].submit()"><br>
						</td>
					</tr>
					<tr class="bloquecentralcuerpo">
						<td colspan="2" rowspan="1">
							Los campos marcados con <font color="red">*</font> deben ser diligenciados obligatoriamente.<br><br>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
						
<?
}



function corregir_registro($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab)
{

	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sesion.class.php");
	$nueva_sesion=new sesiones($configuracion);
	$esta_sesion=$nueva_sesion->numero_sesion();
	$cadena_sql="SELECT ";
	$cadena_sql.="`nombre`, ";
	$cadena_sql.="`apellido`, ";
	$cadena_sql.="`correo`, ";
	$cadena_sql.="`telefono`, ";
	$cadena_sql.="`usuario`, ";
	$cadena_sql.="`identificador` ";
	$cadena_sql.="FROM ";
	$cadena_sql.=$configuracion["prefijo"]."registrado_borrador "; 
	$cadena_sql.="WHERE ";
	$cadena_sql.="identificador='".$_REQUEST["identificador"]."' ";
	$cadena_sql.="LIMIT 1";
	
	//echo $cadena_sql;
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/dbms.class.php");
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$total=$acceso_db->registro_db($cadena_sql,0);
		if($total>0)
		{
			$registro=$acceso_db->obtener_registro_db();
			//echo $registro[0][0];
		}
		else
		{
			nuevo_registro($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab);
			return TRUE;
		}
	}
	
?><script src="<? echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="<? echo $formulario?>">
<table width="100%" align="center" border="0" cellpadding="10" cellspacing="0" >
	<tbody>
		<tr>
			<td >
				<table class="tabla_basico" align="center">
					<tbody>
						<tr class="bloquecentralencabezado">
							<td colspan="2" rowspan="1">Registro para usuarios nuevos:</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
								<font color="red">*</font>Nombres:<br>
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<input maxlength="80" size="40" tabindex="<? echo $tab++ ?>" name="nombre" value="<? echo $registro[0][0]?>" ><br>
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
								<font color="red">*</font>Apellidos:<br>
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<input maxlength="80" size="40" tabindex="<? echo $tab++ ?>" name="apellido" value="<? echo $registro[0][1]?>">
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
								<font color="red">*</font>Correo Electr&oacute;nico:<br>
							</td>
							<td bgcolor="<? echo $tema->celda ?>"><?							
							if(strtolower($registro[0][2])=="verificar correo")
							{							
							?><input class="cuadro_corregir" maxlength="80" size="40" tabindex="<? echo $tab++ ?>" name="correo" value="<? echo $registro[0][2]?>"><?
							}
							else
							{
							?><input maxlength="80" size="40" tabindex="<? echo $tab++ ?>" name="correo" value="<? echo $registro[0][2]?>"><?
							}								
							?></td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
								Tel&eacute;fono:<br>
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<input maxlength="50" size="30" tabindex="<? echo $tab++ ?>" name="telefono" value="<? echo $registro[0][3]?>">
							</td>
						</tr>
						<tr>
							<td class="bloquecentralencabezado" colspan="2" rowspan="1">
								Datos para la autenticaci&oacute;n:
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
								<font color="red">*</font>Usuario:<br>
							</td>
							<td bgcolor="<? echo $tema->celda ?>"><?							
							if(strtolower($registro[0][4])=="verificar usuario")
							{							
							?><input class="cuadro_corregir" maxlength="50" size="30" tabindex="<? echo $tab++; ?>" name="usuario" value="<? echo $registro[0][4]?>"><?
							}
							else
							{
							?><input maxlength="50" size="30" tabindex="<? echo $tab++; ?>" name="usuario" value="<? echo $registro[0][4]?>"><?
							}								
							?>					
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
								<font color="red">*</font>Clave:
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<input maxlength="50" size="30" tabindex="<? echo $tab++; ?>" name="clave"  type="password">
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
							<font color="red">*</font>Reescriba la clave:<br>
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<input maxlength="50" size="30" tabindex="<? echo $tab++; ?>" name="clave_2" type="password">
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' >
							<td bgcolor="<? echo $tema->celda ?>">
							<font color="red">*</font>Acceso requerido:
							</td>
							<td bgcolor="<? echo $tema->celda ?>"><?
								
								include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
								$indice=$configuracion["host"].$configuracion["site"]."/index.php?";
								$variable="pagina=seleccionar_rol";
								$variable.="&admin=lista";
								$cripto=new encriptar();
								$variable=$cripto->codificar_url($variable,$configuracion);							
							
							?>	<input type='hidden' name='roles'>
								<a name="enlace_roles" href="#enlace_roles" onclick="abrir_emergente('<?echo $indice.$variable  ?>','roles_usuario',window.document.<? echo $formulario?>.roles,window.document.<? echo $formulario?>.rol,<? echo (840/2) ?>,600)"><img src="<? echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/info.png" alt="Mostar roles" title="Mostrar roles" border="0" /> Seleccionar roles.</a>
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' >
							<td bgcolor="<? echo $tema->celda ?>" valign="top">
							Roles seleccionados:
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<textarea class="texto_negrita" rows="4" cols="40" name='rol'  tabindex='<? echo $tab++ ?>' >Ninguno</textarea>
							</td>
						</tr>
						<tr align="center" class="bloquecentralcuerpo">
							<td colspan="2" rowspan="1" align="center"><?
							if(isset($_REQUEST["admin"]))
							{?>
							<input type="hidden" name="admin" value="true">
							<?}?>
								<input type="hidden" name="action" value="registro_usuario">
								<input value="enviar" name="aceptar" tabindex='<? echo $tab++ ?>' type="button" onclick="return(<? echo $verificar; ?>)?document.forms['<? echo $formulario?>'].submit():false"><br>
							</td>
						</tr>
						<tr class="bloquecentralcuerpo">
							<td colspan="2" rowspan="1">
								Los campos marcados con <font color="red">*</font> deben ser diligenciados obligatoriamente.<br><br>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
</form>
<?
}


function editar_registro($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab)
{

	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
	$cripto=new encriptar();
	$datos="";
	
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sesion.class.php");
	$nueva_sesion=new sesiones($configuracion);
	$esta_sesion=$nueva_sesion->numero_sesion();
	$cadena_sql="SELECT ";
	$cadena_sql.="`nombre`, ";
	$cadena_sql.="`apellido`, ";
	$cadena_sql.="`correo`, ";
	$cadena_sql.="`telefono`, ";
	$cadena_sql.="`usuario`, ";
	$cadena_sql.="`id_usuario`, ";
	$cadena_sql.="`clave` ";
	$cadena_sql.="FROM ";
	$cadena_sql.=$configuracion["prefijo"]."registrado "; 
	$cadena_sql.="WHERE ";
	$cadena_sql.="id_usuario='".$_REQUEST["id_usuario"]."' ";
	$cadena_sql.="LIMIT 1";	
	//echo $cadena_sql;
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/dbms.class.php");
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();
	if (is_resource($enlace))
	{
		$total=$acceso_db->registro_db($cadena_sql,0);
		if($total>0)
		{
			$registro=$acceso_db->obtener_registro_db();
			//echo $registro[0][0];
		}
		else
		{
			nuevo_registro($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab);
			return TRUE;
		}
	}
	
?><script src="<? echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/funciones.js" type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="<? echo $formulario?>">
<table width="100%" cellpadding="12" cellspacing="0"  align="center">
	<tbody>
		<tr>
			<td align="center" valign="middle">
				<table style="width: 100%; text-align: left;" border="0" cellpadding="5" cellspacing="1" class=bloquelateral>
					<tbody>
						<tr class="bloquecentralencabezado">
							<td colspan="2" rowspan="1">Registro para usuarios nuevos:</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
								<font color="red">*</font>Nombres:<br>
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<input maxlength="80" size="40" tabindex="<? echo $tab++ ?>" name="nombre" value="<? echo $registro[0][0]?>" ><br>
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
								<font color="red">*</font>Apellidos:<br>
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<input maxlength="80" size="40" tabindex="<? echo $tab++ ?>" name="apellido" value="<? echo $registro[0][1]?>">
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
								<font color="red">*</font>Correo Electr&oacute;nico:<br>
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<input maxlength="80" size="40" tabindex="<? echo $tab++ ?>" name="correo" value="<? echo $registro[0][2]?>">
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
								Tel&eacute;fono:<br>
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<input maxlength="50" size="30" tabindex="<? echo $tab++ ?>" name="telefono" value="<? echo $registro[0][3]?>">
							</td>
						</tr>
						<tr>
							<td class="bloquecentralencabezado" colspan="2" rowspan="1">
								Datos para la autenticaci&oacute;n:
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
								<font color="red">*</font>Usuario:<br>
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<input maxlength="50" size="30" tabindex="<? echo $tab++; ?>" name="usuario" value="<? echo $registro[0][4]?>">
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
								<font color="red">*</font>Clave:
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<input maxlength="50" size="30" tabindex="<? echo $tab++; ?>" name="clave"  type="password" value="<?echo $cripto->codificar("la_clave",$configuracion);?>">
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
							<font color="red">*</font>Reescriba la clave:<br>
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<input maxlength="50" size="30" tabindex="<? echo $tab++; ?>" name="clave_2" type="password" value="<?echo $cripto->codificar("la_clave",$configuracion);?>">
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' >
							<td bgcolor="<? echo $tema->celda ?>">
							<font color="red">*</font>Acceso requerido:
							</td>
							<td bgcolor="<? echo $tema->celda ?>"><?
								
								include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
								$indice=$configuracion["host"].$configuracion["site"]."/index.php?";
								$variable="pagina=seleccionar_rol";
								$variable.="&admin=lista";
								$cripto=new encriptar();
								$variable=$cripto->codificar_url($variable,$configuracion);							
							
							?>	<input type='hidden' name='roles'>
								<a name="enlace_roles" href="#enlace_roles" onclick="abrir_emergente('<?echo $indice.$variable  ?>','roles_usuario',window.document.<? echo $formulario?>.roles,window.document.<? echo $formulario?>.rol,<? echo (840/2) ?>,600)"><img src="<? echo $configuracion["host"].$configuracion["site"].$configuracion["grafico"]?>/info.png" alt="Mostar roles" title="Mostrar roles" border="0" /> Seleccionar roles.</a>
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' >
							<td bgcolor="<? echo $tema->celda ?>" valign="top">
							Roles seleccionados:
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<textarea class="texto_negrita" rows="4" cols="40" name='rol'  tabindex='<? echo $tab++ ?>' ><?
								
								$cadena_sql="SELECT ";
								$cadena_sql.=$configuracion["prefijo"]."registrado_subsistema."."id_usuario, ";
								$cadena_sql.=$configuracion["prefijo"]."registrado_subsistema."."id_subsistema, ";
								$cadena_sql.=$configuracion["prefijo"]."subsistema."."etiqueta, ";
								$cadena_sql.=$configuracion["prefijo"]."registrado_subsistema."."estado ";
								$cadena_sql.="FROM ";
								$cadena_sql.=$configuracion["prefijo"]."registrado_subsistema, "; 
								$cadena_sql.=$configuracion["prefijo"]."subsistema "; 
								$cadena_sql.="WHERE "; 
								$cadena_sql.=$configuracion["prefijo"]."registrado_subsistema."."id_usuario='".$_REQUEST["id_usuario"]."' ";
								$cadena_sql.="AND ";
								$cadena_sql.=$configuracion["prefijo"]."registrado_subsistema."."id_subsistema=".$configuracion["prefijo"]."subsistema."."id_subsistema "; 
								$cadena_sql.="AND ";
								$cadena_sql.=$configuracion["prefijo"]."registrado_subsistema."."estado<2"; 
								//echo $cadena_sql;
								$roles=$acceso_db->registro_db($cadena_sql,0);
								if($roles>0)
								{
									$los_roles=$acceso_db->obtener_registro_db();
									$cadena="";
									for($i=0;$i<$roles;$i++)
									{
										$cadena.=$los_roles[$i][2]."\n";
									}
									
									
								}
								else
								{
									$cadena="Ninguno";
								}			
								
								echo $cadena;
								?></textarea>
							</td>
						</tr>
						<tr align="center" class="bloquecentralcuerpo">
							<td colspan="2" rowspan="1" align="center"><?
							if(isset($_REQUEST["admin"]))
							{
								$datos.="&admin=true";
							}
							$datos.="&action=registro_usuario";
							$datos.="&id_usuario=".$_REQUEST["id_usuario"];
							
							$datos=$cripto->codificar($datos,$configuracion);	
							?>	<input type='hidden' name='formulario' value="<? echo $datos ?>">
								<input value="enviar" name="aceptar" tabindex='<? echo $tab++ ?>' type="button" onclick="return(<? echo $verificar; ?>)?document.forms['<? echo $formulario?>'].submit():false"><br>
							</td>
						</tr>
						<tr class="bloquecentralcuerpo">
							<td colspan="2" rowspan="1">
								Los campos marcados con <font color="red">*</font> deben ser diligenciados obligatoriamente.<br><br>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
</form>
<?
}



function confirmar_registro($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab,$acceso_db)
{

	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
	$cripto=new encriptar();
	$datos="";
	
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/sesion.class.php");
	$nueva_sesion=new sesiones($configuracion);
	$esta_sesion=$nueva_sesion->numero_sesion();
	
	$cadena_sql=sqlhtmlUsuario($configuracion, "registroBorrador");

	$registro=accesodbhtmlUsuario($acceso_db, $cadena_sql);
	
	if(is_array($registro))
	{
		htmlConfirmar($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab,$acceso_db, $registro);	
	}
	else
	{
		echo "Imposible mostrar los datos de Inscripci&oacute;n";
	}
	
}

function htmlConfirmar($configuracion,$tema,$accion,$formulario,$verificar,$fila,$tab,$acceso_db, $registro)
{

include_once($configuracion["raiz_documento"].$configuracion["clases"]."/cadenas.class.php");


?>
<form method="post" action="index.php" name="<? echo $formulario?>">
<table width="100%" cellpadding="12" cellspacing="0"  align="center">
	<tbody>
		<tr>
			<td align="center" valign="middle">
				<table style="width: 100%; text-align: left;" border="0" cellpadding="5" cellspacing="1" class=bloquelateral>
					<tbody>
						<tr class="bloquecentralencabezado">
							<td colspan="2" rowspan="1">Confirmar Datos de Suscripci&oacute;n</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
								Nombres:<br>
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<? echo $registro[0][1]?>
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
								Apellidos:<br>
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<? echo $registro[0][2]?>
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
						<td bgcolor='<? echo $tema->celda ?>'>
							Tipo de Documento
						</td>
						<td bgcolor='<? echo $tema->celda ?>'><?
							$cadena_sql=sqlhtmlUsuario($configuracion, "tipoDocumento",$registro[0][3]);
							$registro2=accesodbhtmlUsuario($acceso_db, $cadena_sql);	
							if(is_array($registro2))
							{
								echo cadenas::formatohtml($registro2[0][0]);
								unset($registro2);
							}
						?></td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor='<? echo $tema->celda ?>'>
								No Identificaci&oacute;n
							</td>
							<td bgcolor='<? echo $tema->celda ?>'>
								<? echo $registro[0][4] ?>
							</td>
						</tr>
						<tr>
							<td colspan="2" rowspan="1"><br>Datos de Contacto<hr class="hr_subtitulo"></td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor='<? echo $tema->celda ?>'>
								Direcci&oacute;n
							</td>
							<td bgcolor='<? echo $tema->celda ?>'>
								<? echo $registro[0][5] ?>
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor='<? echo $tema->celda ?>'>
								Pa&iacute;s
							</td>
							<td bgcolor='<? echo $tema->celda ?>'><?
							
								$cadena_sql=sqlhtmlUsuario($configuracion, "pais",$registro[0][7]);
								$registro2=accesodbhtmlUsuario($acceso_db, $cadena_sql);	
								if(is_array($registro2))
								{
									echo $registro2[0][0];
									unset($registro2);
								}
								
							
							?></td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor='<? echo $tema->celda ?>'>
								Departamento/Provincia/Estado
							</td>
							<td bgcolor='<? echo $tema->celda ?>'>
							<div id="divRegion"><?
								
								$valor[0]=$registro[0][7];
								$valor[1]=$registro[0][13];
								$cadena_sql=sqlhtmlUsuario($configuracion, "region",$valor);
								$registro2=accesodbhtmlUsuario($acceso_db, $cadena_sql);	
								if(is_array($registro2))
								{
									echo cadenas::formatohtml($registro2[0][0]);
									unset($registro2);
								}
							
							?></div>
							</td>
						</tr>							
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor='<? echo $tema->celda ?>'>
								Ciudad
							</td>
							<td bgcolor='<? echo $tema->celda ?>'>
							<div id="divCiudad"><?
							
								$valor[0]=$registro[0][6];
								$valor[1]=$registro[0][13];
								$cadena_sql=sqlhtmlUsuario($configuracion, "ciudad",$valor);
								$registro2=accesodbhtmlUsuario($acceso_db, $cadena_sql);	
								if(is_array($registro2))
								{
									echo cadenas::formatohtml($registro2[0][0]);
									unset($registro2);
								}
							
							?></div>
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor='<? echo $tema->celda ?>'>
								Correo Electr&oacute;nico
							</td>
							<td bgcolor='<? echo $tema->celda ?>'>
								<? echo $registro[0][8] ?>
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor='<? echo $tema->celda ?>'>
								Tel&eacute;fono
							</td>
							<td bgcolor='<? echo $tema->celda ?>'>
								<? echo $registro[0][9] ?>
							</td>
						</tr>
						<tr>
							<td colspan="2" rowspan="1"><br>Informaci&oacute;n Acad&eacute;mica<hr class="hr_subtitulo"></td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor='<? echo $tema->celda ?>'>
								Formaci&oacute;n Acad&eacute;mica
							</td>
							<td bgcolor='<? echo $tema->celda ?>'><?
							
								$cadena_sql=sqlhtmlUsuario($configuracion, "ciudad",$registro[0][6]);
								$registro2=accesodbhtmlUsuario($acceso_db, $cadena_sql);	
								if(is_array($registro2))
								{
									echo $registro2[0][0];
									unset($registro2);
								}
							
							?></td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor='<? echo $tema->celda ?>'>
								Area de Desempeño
							</td>
							<td bgcolor='<? echo $tema->celda ?>'><?
							
								$cadena_sql=sqlhtmlUsuario($configuracion, "ciudad",$registro[0][6]);
								$registro2=accesodbhtmlUsuario($acceso_db, $cadena_sql);	
								if(is_array($registro2))
								{
									echo $registro2[0][0];
									unset($registro2);
								}
							
							?></td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor='<? echo $tema->celda ?>'>
								Instituci&oacute;n
							</td>
							<td bgcolor='<? echo $tema->celda ?>'>
								<input type='text' name='institucion' size='40' maxlength='255' tabindex='<? echo $tab++ ?>' >
							</td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor='<? echo $tema->celda ?>'>
								Pa&iacute;s
							</td>
							<td bgcolor='<? echo $tema->celda ?>'><?
							
								$cadena_sql=sqlhtmlUsuario($configuracion, "ciudad",$registro[0][6]);
								$registro2=accesodbhtmlUsuario($acceso_db, $cadena_sql);	
								if(is_array($registro2))
								{
									echo $registro2[0][0];
									unset($registro2);
								}
							
							?></td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor='<? echo $tema->celda ?>'>
								Departamento/Provincia/Estado
							</td>
							<td bgcolor='<? echo $tema->celda ?>'>
							<div id="divRegionFormacion"><?
							
								$cadena_sql=sqlhtmlUsuario($configuracion, "ciudad",$registro[0][6]);
								$registro2=accesodbhtmlUsuario($acceso_db, $cadena_sql);	
								if(is_array($registro2))
								{
									echo $registro2[0][0];
									unset($registro2);
								}
							
							?></div>
							</td>
						</tr>		
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $contador ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $contador ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $contador++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor='<? echo $tema->celda ?>'>
								Ciudad
							</td>
							<td bgcolor='<? echo $tema->celda ?>'><div id="divCiudadFormacion"><?
							
								$cadena_sql=sqlhtmlUsuario($configuracion, "ciudad",$registro[0][6]);
								$registro2=accesodbhtmlUsuario($acceso_db, $cadena_sql);	
								if(is_array($registro2))
								{
									echo $registro2[0][0];
									unset($registro2);
								}
							
							?></div>
							</td>
						</tr>					
						<tr>
							<td colspan="2" rowspan="1"><br>Datos para la autenticaci&oacute;n<hr class="hr_subtitulo"></td>
						</tr>
						<tr class='bloquecentralcuerpo' onmouseover="setPointer(this, <? echo $fila ?>, 'over', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmouseout="setPointer(this, <? echo $fila ?>, 'out', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');" onmousedown="setPointer(this, <? echo $fila++ ?>, 'click', '<? echo $tema->celda ?>', '<? echo $tema->apuntado ?>', '<? echo $tema->seleccionado ?>');">
							<td bgcolor="<? echo $tema->celda ?>">
								Usuario:
							</td>
							<td bgcolor="<? echo $tema->celda ?>">
								<? echo $registro[0][10] ?>
							</td>
						</tr>
						<tr align="center" class="bloquecentralcuerpo">
							<td colspan="2" rowspan="1" align="center">
								<input type='hidden' name='formulario' value="<? echo $datos ?>">
								<input value="enviar" name="aceptar" tabindex='<? echo $tab++ ?>' type="button" onclick="return(<? echo $verificar; ?>)?document.forms['<? echo $formulario?>'].submit():false"><br>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
</form>
<?}

function sqlhtmlUsuario($configuracion, $opcion, $valor="")
{
	switch($opcion)
	{
	
		case "registroBorrador":
			$cadena_sql="SELECT ";
			$cadena_sql.="`identificador`, ";
			$cadena_sql.="`nombre`, ";
			$cadena_sql.="`apellido`, ";
			$cadena_sql.="`id_tipo_documento`, ";
			$cadena_sql.="`identificacion`, ";
			$cadena_sql.="`direccion`, ";
			$cadena_sql.="`ciudad`, ";
			$cadena_sql.="`pais`, ";
			$cadena_sql.="`correo`, ";
			$cadena_sql.="`telefono`, ";
			$cadena_sql.="`usuario`, ";
			$cadena_sql.="`clave`, ";
			$cadena_sql.="`asociado`, ";
			$cadena_sql.="`region` ";
			$cadena_sql.="FROM ";
			$cadena_sql.=$configuracion["prefijo"]."registrado_borrador "; 
			$cadena_sql.="WHERE ";
			$cadena_sql.="identificador='".$_REQUEST["identificador"]."' ";
			$cadena_sql.="LIMIT 1";	
			break;
			
		case "tipoDocumento":
			$cadena_sql="SELECT ";
			$cadena_sql.="tipo ";
			$cadena_sql.="FROM ".$configuracion["prefijo"]."tipo_documento ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_tipo=".$valor;			
			break;
		
		case "pais":
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre ";
			$cadena_sql.="FROM ".$configuracion["prefijo"]."pais ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="isonum=".$valor;			
			break;
			
		case "region":
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre ";
			$cadena_sql.="FROM ".$configuracion["prefijo"]."localidad ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_pais=".$valor[0]." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_localidad=".$valor[1]." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_padre=0 ";
			$cadena_sql.="AND ";
			$cadena_sql.="tipo=1 ";
									
			break;
					
		case "ciudad":
			$cadena_sql="SELECT ";
			$cadena_sql.="nombre ";
			$cadena_sql.="FROM ".$configuracion["prefijo"]."localidad ";
			$cadena_sql.="WHERE ";
			$cadena_sql.="id_localidad=".$valor[0]." ";
			$cadena_sql.="AND ";
			$cadena_sql.="id_padre=".$valor[1]." ";
			$cadena_sql.="AND ";
			$cadena_sql.="tipo=2 ";
									
			break;
		default:
			$cadena_sql="error";
			break;
	}
	//echo $cadena_sql;
	return $cadena_sql;
}


function accesodbhtmlUsuario($acceso_db, $cadena_sql)
{
	$total=$acceso_db->registro_db($cadena_sql,0);
	if($total>0)
	{
		$registro=$acceso_db->obtener_registro_db();
		return $registro;
	}
	else
	{
		return false;
	}	
}