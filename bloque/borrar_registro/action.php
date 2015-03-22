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
?>
<?
/***************************************************************************
  
registro_borrado.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

****************************************************************************
* @subpackage   
* @package	bloque
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* 
*
* Pagina para eliminar registros del sistema
*
****************************************************************************/
?><?

$borrar_acceso_db=new dbms($configuracion);
$borrar_enlace=$borrar_acceso_db->conectar_db();
if (is_resource($borrar_enlace))
{
	
	include_once ($configuracion["raiz_documento"].$configuracion["bloques"]."/borrar_registro/".$_REQUEST['opcion'].".php");
	
	if(isset($resultado))
	{
		if($_REQUEST["resultado"]==TRUE)
		{
			mensaje_eliminacion($configuracion);
			?>
			<script type="text/javascript" language="javascript1.2">
					<!--
						alert("El registro se ha eliminado del sistema.");
					//-->
			</script>
			<?
		}
		else
		{
			?>
			<script type="text/javascript" language="javascript1.2">
					<!--
						alert("Imposible eliminar el registro del sistema.");
					//-->
			</script><?
				
		}

		$indice=$configuracion["host"].$configuracion["site"]."/index.php?";
		if(!isset($_REQUEST["redireccion"]))
		{
			include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
			$cripto=new encriptar();
			
			$variable="pagina=".$pagina;			
			unset($_REQUEST['action']);
			
			//Envia todos los datos que vienen con GET
			reset ($_REQUEST);
			while (list ($clave, $val) = each ($_REQUEST)) 
			{
				if($clave!='pagina')
				{
				$variable.="&".$clave."=".$val;
				}
			}
			$variable.="&borrado=1";
			$variable=$cripto->codificar_url($variable,$configuracion);
		}
		else
		{
			$variable=$_REQUEST["redireccion"];
		}
		echo "<script>location.replace('".$indice.$variable."')</script>";   
	}
				
}
else
{
//ERROR AL INGRESAR A LA BD

}
//@Método que crea y muestra un mensaje, de eliminación de los registros  
function mensaje_eliminacion($configuracion)
{
echo "<link rel='stylesheet' type='text/css' href='".$configuracion["host"].$configuracion["site"].$configuracion["estilo"]."/basico/estilo.php' />\n";
?><table width="50%" cellpadding="12" cellspacing="0"  align="center">
	<tbody>
		<tr>
			<td align="center" valign="middle">
				<table class="bloquelateral" cellpadding="10" cellspacing="0">
				<tbody>
					<tr class="bloquelateralencabezado">
						<td>
						...::: Advertencia
						</td>
					</tr>
					<tr>
					<td> 
						<table border="0" cellpadding="10" cellsapcing="0">
						<tbody>
							<tr class="bloquecentralcuerpo">
							<td>
							Eliminando un registro del sistema. Espere unos instantes...<br>
							</td>
							</tr>
						</tbody>
						</table>
					</td>
					</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table><?
}

?>
