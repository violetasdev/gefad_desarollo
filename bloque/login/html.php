<?
/*
 ############################################################################
#    UNIVERSIDAD DISTRITAL Francisco Jose de Caldas                        #
#    Desarrollo Por:                                                       #
#    Paulo Cesar Coronado 2004 - 2005                                      #
#    paulo_cesar@etb.net.co                                                #
#    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
############################################################################
*/
?><?
/***************************************************************************

html.php

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

****************************************************************************
* @subpackage
* @package	formulario
* @copyright
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		http://acreditacion.udistrital.edu.co
*
*
* Codigo HTML del formulario de autenticacion de usuarios
*
*****************************************************************************/
$formulario="autenticacion";
$validar="control_vacio(".$formulario.",'usuario')";
$validar.="&&control_vacio(".$formulario.",'clave')";

?>
<script
	src="<? echo $configuracion["host"].$configuracion["site"].$configuracion["javascript"]  ?>/md5.js"
	type="text/javascript" language="javascript"></script>
<form method="post" action="index.php" name="<?echo $formulario?>">
	<table class="tablaMenu">
		<tbody>
			<tr>
				<td>
					<table align="center" border="0" cellpadding="5" cellspacing="0"
						class="bloquelateral_2">
						<tr class="centralcuerpo">
							<td colspan="2"><b>::::..</b> Ingresar</td>
						</tr>
						<tr class="bloquelateralcuerpo">
							<td>Usuario:</td>
							<td><input maxlength="50" size="12" tabindex="<? echo $tab++ ?>"
								name="usuario" class="cuadro_plano">
							</td>
						</tr>
						<tr class="bloquelateralcuerpo">
							<td>Clave:</td>
							<td><input maxlength="50" size="12" tabindex="<? echo $tab++ ?>"
								name="clave" type="password" class="cuadro_plano"
								onkeypress="if (valida_enter(event)==false)
                                                                                                                                                                                   {if(<?echo $formulario?>.clave.value!=''){<?echo $formulario?>.clave.value = hex_md5(<?echo $formulario?>.clave.value)};return(<? echo $validar; ?>)? document.forms['<? echo $formulario?>'].submit():false}" />
							</td>
						</tr>
						<tr align="center">
							<td colspan="2" rowspan="1"><input type="hidden" name="action"
								value="login"> <input name="aceptar" value="Aceptar"
								type="button"
								onclick="if(<?echo $formulario?>.clave.value!=''){<?echo $formulario?>.clave.value = hex_md5(<?echo $formulario?>.clave.value)};return(<? echo $validar; ?>)? document.forms['<? echo $formulario?>'].submit():false"
								tabindex='<? echo $tab++ ?>'><br>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</form>
