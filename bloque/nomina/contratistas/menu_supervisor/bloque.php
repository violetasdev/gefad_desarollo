<?
/***************************************************************************
  
index.php 

Paulo Cesar Coronado
Copyright (C) 2001-2005

Última revisión 6 de Marzo de 2006

*****************************************************************************
* @subpackage   
* @package	bloques
* @copyright    
* @version      0.2
* @author      	Paulo Cesar Coronado
* @link		N/D
* @description  Menu principal del bloque entidades de salud
* @usage        
*****************************************************************************/
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}


include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");

$indice=$configuracion["host"].$configuracion["site"]."/index.php?";
$indiceSeguro=$configuracion["host"].$configuracion["site"]."/index.php?";
$cripto=new encriptar();
?><table align="center" class="tablaMenu">
	<tbody>
		<tr>
			<td >
				<table align="center" border="0" cellpadding="5" cellspacing="2" class="bloquelateral_2" width="100%">
				
					<tr class="bloquelateralcuerpo">
						<td class="cuadro_simple">
						<a href="<?		
							$variable="pagina=nom_adminNovedad";
							$variable=$cripto->codificar_url($variable,$configuracion);
							echo $indice.$variable;		
							?>">  Contratistas</a>
							
						</td>
					</tr>
                                        
                                        <tr class="bloquelateralcuerpo">
						<td class="cuadro_simple">
						<a href="<?		
							$variable="pagina=nom_adminCumplidoSupervisor";
                                                        $variable.="&opcion=consultarCumplidos";
							$variable=$cripto->codificar_url($variable,$configuracion);
							echo $indice.$variable;		
							?>">  Consulta Cumplidos</a>
							
						</td>
					</tr>
                                        <tr class="bloquelateralcuerpo">
						<td class="cuadro_simple">
						<a href="<?		
							$variable="pagina=nom_adminCumplidoSupervisor";
                                                        $variable.="&opcion=revisar_solicitud";
							$variable=$cripto->codificar_url($variable,$configuracion);
							echo $indice.$variable;		
							?>">  Aprobar Solicitud Cumplido</a>
							
						</td>
					</tr>
                                        <tr class="bloquelateralcuerpo">
						<td class="cuadro_simple">
						<a href="<?		
							$variable="pagina=nom_adminSolicitudPagoSupervisor";
                                                        $variable.="&opcion=consultarSolicitudPago";
							$variable=$cripto->codificar_url($variable,$configuracion);
							echo $indice.$variable;		
							?>">  Consultar Solicitud(es) Pago</a>
							
						</td>
					</tr>
                                        <tr class="bloquelateralcuerpo">
						<td class="cuadro_simple">
						<a href="<?		
							$variable="pagina=nom_adminSolicitudPagoSupervisor";
                                                        $variable.="&opcion=revisarCumplidosAprobados";
							$variable=$cripto->codificar_url($variable,$configuracion);
							echo $indice.$variable;		
							?>">  Solicitar Pago</a>
							
						</td>
					</tr>
									                                      
				</table>
			</td>
		</tr>
	</tbody>
</table>
