<?php
/*--------------------------------------------------------------------------------------------------------------------------
  @ Derechos de Autor: Vea el archivo LICENCIA.txt que viene con la distribucion
---------------------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------
 |				Control Versiones				    	|	
 ----------------------------------------------------------------------------------------
 | fecha      |        Autor            | version     |              Detalle            |
 ----------------------------------------------------------------------------------------
 | 14/02/2013 | Maritza Callejas C.  	| 0.0.0.1     |                                 |
 ----------------------------------------------------------------------------------------
*/


if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;		
}

include_once($configuracion["raiz_documento"].$configuracion["clases"]."/funcionGeneral.class.php");
include_once($configuracion["raiz_documento"].$configuracion["clases"]."/navegacion.class.php");
include_once("html.class.php");
class funciones_adminCumplidoSupervisor extends funcionGeneral
{

	function __construct($configuracion, $sql)
	{
		//[ TO DO ]En futuras implementaciones cada usuario debe tener un estilo		
		//include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
		include ($configuracion["raiz_documento"].$configuracion["estilo"]."/basico/tema.php");
		include_once($configuracion["raiz_documento"].$configuracion["clases"]."/encriptar.class.php");
		include_once($configuracion["raiz_documento"].$configuracion["clases"]."/log.class.php");
                
		$this->cripto = new encriptar();
		$this->log_us = new log();
		$this->tema = $tema;
		$this->sql = $sql;
		
		//Conexion General
		$this->acceso_db = $this->conectarDB($configuracion,"mysqlFrame");
                
                //Conexion SICAPITAL
		$this->acceso_sic = $this->conectarDB($configuracion,"oracleSIC");
                
                //Conexion NOMINA 
		$this->acceso_nomina = $this->conectarDB($configuracion,"nominapg");
               
		//Datos de sesion
		
		$this->usuario = $this->rescatarValorSesion($configuracion, $this->acceso_db, "id_usuario");
		$this->identificacion = $this->rescatarValorSesion($configuracion, $this->acceso_db, "identificacion");
		
                $this->configuracion = $configuracion;
                
                $this->htmlCumplido = new html_adminCumplidoSupervisor($configuracion);   
                
	}
	
	
	function nuevoRegistro($configuracion,$tema,$acceso_db)
	{
            $registro = (isset($registro)?$registro:'');
            $this->form_usuario($configuracion,$registro,$this->tema,"");
		
	}
	
   	function editarRegistro($configuracion,$tema,$id,$acceso_db,$formulario)
   	{						
		$this->cadena_sql = $this->sql->cadena_sql($configuracion,$this->acceso_db,"usuario",$id);
                
		$registro = $this->acceso_db->ejecutarAcceso($this->cadena_sql,"busqueda");
		if ($_REQUEST['opcion'] == 'cambiar_clave')
		{
		$this->formContrasena($configuracion,$registro,$this->tema,'');
		}
		else
		{
		$this->form_usuario($configuracion,$registro,$this->tema,'');
		}
	}
   	
   	function corregirRegistro()
    	{
	}
	
	function listaRegistro($configuracion,$id_registro)
	
    	{	
	}
		

	function mostrarRegistro($configuracion,$registro, $totalRegistros, $opcion, $variable)
    	{	
		switch($opcion)
		{
			case "multiplesCumplidos":
                                $datos_documento = $this->consultarDocumento(1);
            			$this->htmlCumplido->multiplesCumplidos($configuracion,$registro, $totalRegistros, $variable,$datos_documento);
				break;
		
		}
		
	}
	
		
/*__________________________________________________________________________________________________
		
						Metodos especificos 
__________________________________________________________________________________________________*/

    

        /**
         * Funcion que consulta la informacion del contratista y contrato para mostrarla 
         * @param int $interno_co
         * @param int $cod_contrato
         * @param int $vigencia 
         */
        function mostrarInformacionContratista($interno_co,$cod_contrato,$vigencia){
    			$contrato = $this->consultarDatosContrato($interno_co,$vigencia);
                        $cuenta = $this->consultarDatosCta($contrato[0]['INTERNO_PROVEEDOR']);
                        $contratista = $this->consultarDatosContratista($contrato[0]['NUM_IDENTIFICACION']);
                        $disponibilidad = $this->consultarDatosDisponibilidad($contrato[0]['INTERNO_MC'],$contrato[0]['CODIGO_UNIDAD_EJECUTORA'],$vigencia);
                        $nro_cdp = $disponibilidad[0]['NUMERO_DISPONIBILIDAD']; 
                        $registroPresupuestal = $this->consultarDatosRegistroPresupuestal($nro_cdp,$contrato[0]['CODIGO_UNIDAD_EJECUTORA'],$vigencia);
                        $ordenPago = $this->consultarDatosOrdenPago($contrato[0]['NUM_IDENTIFICACION'],$nro_cdp,$vigencia);
                        $tipo_contrato = $this->consultarTipoContrato($vigencia,$contrato[0]['CODIGO_UNIDAD_EJECUTORA'],$registroPresupuestal[0]['NUMERO_REGISTRO']);
                        $fecha_contrato= (isset($registroPresupuestal[0]['FECHA_REGISTRO'])?$registroPresupuestal[0]['FECHA_REGISTRO']:'');
                        if($cod_contrato){ 
                            $novedades = $this->consultarDatosNovedades( $cod_contrato,$vigencia);
                        }else{
                            $novedades ="";
                        }
                        //Obtener el total de registros
			$totalRoles = $this->totalRegistros($this->configuracion, $this->acceso_db);
                        ?>			
			<table width="90%" align="center" border="0" cellpadding="10" cellspacing="0" >
			<tbody>
								<tr>
				<td>
					<table width="100%" border="0" align="center" cellpadding="5 px" cellspacing="1px" >
					  					  
                                          
                                          <tr>
						<td>
							<?
                                                        $this->htmlCumplido->mostrarDatosContratista($contratista);
                                                        ?>
						</td>
					  </tr>
                                          <tr>
						<td>
							<?
                                                        $this->htmlCumplido->mostrarDatosContrato($contrato,$tipo_contrato,$fecha_contrato);
                                                        ?>
						</td>
					  </tr>
                                          <tr>
						<td>
							<?
                                                        $this->htmlCumplido->mostrarDatosCuentaBanco($cuenta);
                                                        ?>
						</td>
					  </tr>
                                          <tr>
						<td>
							<?
                                                        $this->htmlCumplido->mostrarDatosDisponibilidad($disponibilidad);
                                                        ?>
						</td>
					  </tr>    
                                          <tr>
						<td>
							<?
                                                        $this->htmlCumplido->mostrarDatosRegistroPresupuestal($registroPresupuestal);
                                                        ?>
						</td>
					  </tr>    
                                          <tr>
						<td>
							<?
                                                        $this->htmlCumplido->mostrarDatosOrdenPago($ordenPago);
                                                        ?>
						</td>
					  </tr>    
                                          <tr>
						<td>
							<?
                                                        $this->htmlCumplido->mostrarNovedades($novedades);
                                                        ?>
						</td>
					  </tr>
					</table>
				   </td>
				</tr>
				<tr>
			<td>
				
			</tbody>
			</table>
			<?				
		
    }

 
    /**
     * Funcion que consulta en la base de datos informacion del contrato
     * @param int $cod_contrato
     * @param int $vigencia
    */
    function consultarDatosContrato($cod_contrato,$vigencia){
        //busca si existen registro de datos de usuarios en la base de datos 
            $datos = array('vigencia'=>$vigencia,
                            'interno_oc'=>$cod_contrato);
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_sic,"datos_contrato",$datos);
            //echo "<br>cadena ".$cadena_sql;
            return $datos_contrato = $this->ejecutarSQL($this->configuracion, $this->acceso_sic, $cadena_sql, "busqueda");
			
    }
    
    /**
     * Funcion que consulta en la base de datos informacion de las cuentas bancarias
     * @param int $cod_interno_proveedor
    */
    function consultarDatosCta($cod_interno_proveedor){
        
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_sic,"datos_cuenta",$cod_interno_proveedor);
            //echo $cadena_sql;
            return $datos_cuenta = $this->ejecutarSQL($this->configuracion, $this->acceso_sic, $cadena_sql, "busqueda");
    }

    /**
     * Funcion que consulta en la base de datos informacion de la disponibilidad de un contrato
     * @param int $cod_interno_minuta_contrato
     * @param int $cod_unidad_ejecutora
     * @param int $vigencia
    */
    function consultarDatosDisponibilidad($cod_interno_minuta_contrato, $cod_unidad_ejecutora, $vigencia){
            $datos = array('vigencia'=>$vigencia,
                            'cod_unidad_ejecutora'=>$cod_unidad_ejecutora,
                            'cod_minuta_contrato'=>$cod_interno_minuta_contrato);
            
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_sic,"datos_disponibilidad",$datos);
            return $datos_disponibilidad = $this->ejecutarSQL($this->configuracion, $this->acceso_sic, $cadena_sql, "busqueda");
    
    }
    
    /**
     * Funcion que consulta en la base de datos informacion del registro presupuestal de un contrato
     * @param int $nro_cdp
     * @param int $cod_unidad_ejecutora
     * @param int $vigencia
    */
    function consultarDatosRegistroPresupuestal($nro_cdp, $cod_unidad_ejecutora, $vigencia){
            $datos = array( 'nro_cdp'=>$nro_cdp,
                            'cod_unidad_ejecutora'=>$cod_unidad_ejecutora,
                            'vigencia'=>$vigencia
                            );
            
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_sic,"datos_registro",$datos);
            return $datos_disponibilidad = $this->ejecutarSQL($this->configuracion, $this->acceso_sic, $cadena_sql, "busqueda");
    
    }
    
    /**
     * Funcion que consulta en la base de datos informacion del contratista
     * @param int $identificacion
    */
   function consultarDatosContratista($identificacion){
            
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_sic,"datos_contratista",$identificacion);
            return $datos_disponibilidad = $this->ejecutarSQL($this->configuracion, $this->acceso_sic, $cadena_sql, "busqueda");
       
    }
    
   /**
     * Funcion que consulta en la base de datos informacion de ordenes de pago
     * @param int $identificacion
     * @param int $num_disponibilidad
     * @param int $vigencia
    */
    function consultarDatosOrdenPago($identificacion,$num_disponibilidad,$vigencia){
            $datos = array( 'identificacion'=>$identificacion,
                            'num_disponibilidad'=>$num_disponibilidad,
                            'vigencia'=>$vigencia
                            );
            
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_sic,"datos_orden_pago",$datos);
            //echo "cadena ".$cadena_sql;exit;
            return $datos_disponibilidad = $this->ejecutarSQL($this->configuracion, $this->acceso_sic, $cadena_sql, "busqueda");
       
    }
    
   /**
     * Funcion que consulta en la base de datos informacion de las novedades registradas
     * @param int $interno_contrato
    */
   function consultarDatosNovedades($cod_contrato,$vigencia){
            $datos= array(  'vigencia'=>$vigencia,
                            'cod_contrato'=>$cod_contrato);               
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"datos_novedades",$datos);
            //echo "cadena ".$cadena_sql;exit;
            return $datos_novedad = $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "busqueda");

    }


 
    /**
     * Funcion que valida que existan los datos de un contratista requeridos para la elaboración del cumplido
     * @param <array> $contratista
     * @return String/array 
     */
    function validaContratista($contratista){
        $indice = 1;
        if(!$contratista[0]['TIPO_DOCUMENTO']){
            $valido[$indice]="Tipo documento";
            $indice++;
        }
        if(!$contratista[0]['NUMERO_DOCUMENTO']){
            $valido[$indice]="Número documento";
            $indice++;
        }
        if(!$contratista[0]['PRIMER_NOMBRE']){
            $valido[$indice]="Primer Nombre";
            $indice++;
        }
        if(!$contratista[0]['PRIMER_APELLIDO']){
            $valido[$indice]="Primer Apellido";
            $indice++;
        }
        $valido=(isset($valido)?$valido:'ok');
        return $valido;
    }
    
    
    /**
     * Funcion que valida que existan los datos de un contrato requeridos para la elaboración del cumplido
     * @param type $contrato
     * @param type $tipo_contrato
     * @return type 
     */ 
    function validaContrato($contrato,$tipo_contrato){
        $indice = 1;
        $contrato[0]['NUM_CONTRATO']=(isset( $contrato[0]['NUM_CONTRATO'])? $contrato[0]['NUM_CONTRATO']:'');
        $contrato[0]['FECHA_INICIO']=(isset( $contrato[0]['FECHA_INICIO'])? $contrato[0]['FECHA_INICIO']:'');
        $contrato[0]['FECHA_FINAL']=(isset( $contrato[0]['FECHA_FINAL'])? $contrato[0]['FECHA_FINAL']:'');
        if(!$contrato[0]['NUM_CONTRATO']){
            $valido[$indice]="Numero documento";
            $indice++;
        }
        if(!$contrato[0]['FECHA_INICIO']){
            $valido[$indice]="Fecha de inicio";
            $indice++;
        }
        
        if(!$contrato[0]['FECHA_FINAL']){
            $valido[$indice]="Fecha final";
            $indice++;
        }
        if(!$tipo_contrato){
            $valido[$indice]="Tipo de contrato";
            $indice++;
        }
        
        $valido=(isset($valido)?$valido:'ok');
        return $valido;
    }
    
    /**
     * Funcion que valida que existan los datos de cretificados de disponibilidad y registro presupuestal requeridos para la elaboración del cumplido
     * @param <array> $disponibilidad
     * @param <array> $registroPresupuestal
     * @return type 
     */
    function validaCertificados($disponibilidad,$registroPresupuestal){
        $indice = 1;
        if(!$disponibilidad[0]['NUMERO_DISPONIBILIDAD']){
            $valido[$indice]="Número de disponibilidad";
            $indice++;
        }
        if(!$disponibilidad[0]['FECHA_DISPONIBILIDAD']){
            $valido[$indice]="Fecha de disponibilidad";
            $indice++;
        }
        if(!$disponibilidad[0]['VALOR']){
            $valido[$indice]="Valor disponibilidad";
            $indice++;
        }
         if(!$registroPresupuestal[0]['NUMERO_REGISTRO']){
            $valido[$indice]="Número de registro";
            $indice++;
        }
        if(!$registroPresupuestal[0]['FECHA_REGISTRO']){
            $valido[$indice]="Fecha de registro";
            $indice++;
        }
        if(!$registroPresupuestal[0]['VALOR']){
            $valido[$indice]="Valor REGISTRO";
            $indice++;
        }
        
        $valido=(isset($valido)?$valido:'ok');
        return $valido;
    }
    
 
    
    /**
     * Funcion que consulta las cuentas bancarias relacionadas a un contratista
     * @param int $identificacion
     * @param String $tipo_id
     * @return <array> 
     */
    function consultarCuentas($identificacion, $tipo_id){
            $datos = array('tipo_id'=>$tipo_id,
                        'num_id'=>$identificacion);
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"lista_cuentas",$datos);
            return $resultado = $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "busqueda");

    }
    
    
  
    /**
     * Funcion que consulta el tipo de contrato de un contrato
     * @param int $vigencia
     * @param int $unidad_ejecutora
     * @param int $numero_registro
     * @return type 
     */
    function consultarTipoContrato($vigencia,$unidad_ejecutora,$numero_registro){
            $datos = array('vigencia'=>$vigencia,
                            'unidad_ejec'=>$unidad_ejecutora,
                            'num_registro'=>$numero_registro);
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_sic,"tipo_contrato",$datos);
            $datos_contrato = $this->ejecutarSQL($this->configuracion, $this->acceso_sic, $cadena_sql, "busqueda");
            return $datos_contrato[0][1];
    }
      
    /**
     * Funcion que consulta los registro de contratos relacionados a un contratista
     * @param int $identificacion
     * @return <array>
     */
    function consultarContratos($identificacion){
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_sic,"contratos",$identificacion);
            echo "<br>cadena ".$cadena_sql;
            $datos_contrato = $this->ejecutarSQL($this->configuracion, $this->acceso_sic, $cadena_sql, "busqueda");
            return $datos_contrato;
    }
    
 
    
    /**
     * Funcion que recorre el arreglo con las solicitudes y llama al metodo de mostrar la información relacionada
     * @param <array> $registro 
     */
    function mostrarListadoSolicitudes($registro){
       
        if(is_array($registro)){
            $cumplidos =array();
            $indice=0;
            foreach ($registro as $key => $arreglo) {
                        $cumplidos[$indice]['id'] = $arreglo['id'];
                        $cumplidos[$indice]['vigencia'] =$arreglo['vigencia'];
                        $cumplidos[$indice]['num_contrato'] =$arreglo['num_contrato'];
                        $cumplidos[$indice]['anio'] =$arreglo['anio'];
                        $cumplidos[$indice]['mes'] =$arreglo['mes'];
                        $cumplidos[$indice]['procesado'] =$arreglo['procesado'];
                        $cumplidos[$indice]['estado'] =$arreglo['estado'];
                        $cumplidos[$indice]['estado_reg'] =$arreglo['estado_reg'];
                        $cumplidos[$indice]['fecha'] =$arreglo['fecha'];
                        $cumplidos[$indice]['num_impresiones'] =$arreglo['num_impresiones'];
                        $cumplidos[$indice]['valor'] =$arreglo['valor'];
                        $cumplidos[$indice]['id_cta'] =$arreglo['id_cta'];
                        $cumplidos[$indice]['finicio_per_pago'] =$arreglo['finicio_per_pago'];
                        $cumplidos[$indice]['ffinal_per_pago'] =$arreglo['ffinal_per_pago'];
                        $cumplidos[$indice]['acumulado_valor_pagos'] =$arreglo['acumulado_valor_pagos'];
                        $cumplidos[$indice]['acumulado_dias_pagos'] =$arreglo['acumulado_dias_pagos'];
                        $cumplidos[$indice]['interno_co'] =$arreglo['interno_co'];
                        $cumplidos[$indice]['num_id_contratista'] =$arreglo['num_id_contratista'];
                        $contratista = $this->consultarDatosContratista($cumplidos[$indice]['num_id_contratista']);
                        $cumplidos[$indice]['nombre_contratista'] =$contratista[0]['PRIMER_NOMBRE']." ".$contratista[0]['SEGUNDO_NOMBRE']." ".$contratista[0]['PRIMER_APELLIDO']." ".$contratista[0]['SEGUNDO_APELLIDO'];
                        
                        $indice++;
            }
        
               $this->mostrarRegistro($this->configuracion,$cumplidos, $this->configuracion['registro'], "multiplesCumplidos", "");

        }else{
            echo "No tiene solicitudes de cumplido registradas";
        }
        
         
    }
    
    /**
     * Funcion que consulta los registros de las solicitudes de cumplido de un contratista
     * @param int $vigencia
     * @param int $cod_contrato
     * @return <array> 
     */
    function consultarSolicitudes($vigencia,$cod_contrato,$id_solicitud,$codigos_internos){
            $datos=array('vigencia'=>$vigencia,
                            'cod_contrato'=>$cod_contrato,
                            'id_solicitud'=>$id_solicitud,
                            'codigos_internos'=>$codigos_internos);
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"solicitudes_cumplido",$datos);
            //echo "<br>cadena ".$cadena_sql;
            $resultado = $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "busqueda");
            return $resultado;
        
    }
    
    
    /**
     * Funcion que muestra un mensaje de alerta y retorna a una pagina
     * @param type $pagina
     * @param type $variable
     * @param type $mensaje 
     */
    function retornar($pagina,$variable,$mensaje=""){
        if($mensaje=="")
        {
          
        }
        else
        {
          echo "<script>alert ('".$mensaje."');</script>";
        }
        $this->enlaceParaRetornar($pagina, $variable);
    }

      /**
     * Funcion que retorna a una pagina 
     * @param <string> $pagina
     * @param <string> $variable
     */
    function enlaceParaRetornar($pagina,$variable) {
        echo "<script>location.replace('".$pagina.$variable."')</script>";
        exit;
    }
    
    /**
     * Funcion que consulta las solicitudes por aprobar, muestra los datos para ser revisadas
     * @param type $configuracion 
     */
    function revisarSolicitudCumplido(){
            //$cod_supervisor=40;
            $cod_supervisor=$this->obtenerCodigoInternoSupervisor($this->identificacion);
            //echo "<br>cod_sup ".$cod_supervisor;
            $contratos = $this->consultarContratosSupervisor($cod_supervisor);
            
            $codigos_internos=$this->obtenerCadenaCodigosInternosContrato($contratos);
//            echo "<br>cod_internos ".$codigos_internos;exit;
//            var_dump($contratos);exit;
            $solicitudes = $this->consultarTodasSolicitudesCumplido($codigos_internos);
            $solicitudes = $this->asignarDatosContrato($solicitudes);
            
            $solicitudes = $this->asignarValorCumplido($solicitudes);
            $solicitudes = $this->asignarValorAFC($solicitudes);
            
            //var_dump($solicitudes);exit;
            $this->htmlCumplido->form_revisar_solicitud($this->configuracion, $solicitudes);
            
        }
   
     /**
     * Funcion que consulta los registros de todos los contratos relacionados a un supervisor
     * @param int $vigencia
     * @param int $cod_contrato
     * @return <array> 
     */
    function consultarContratosSupervisor($cod_supervisor){
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_sic,"contratos_supervisor",$cod_supervisor);
         //   echo "<br>cadena ".$cadena_sql;
            $resultado = $this->ejecutarSQL($this->configuracion, $this->acceso_sic, $cadena_sql, "busqueda");
            return $resultado;
        
    }
    
     /**
     * Funcion que consulta los registros de todas las solicitudes de cumplido 
     * @param int $codigos_internos
     * @return <array> 
     */
    function consultarTodasSolicitudesCumplido($codigos_internos){
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"todas_solicitudes_cumplido",$codigos_internos);
            //echo "<br>cadena ".$cadena_sql;exit;
            $resultado = $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "busqueda");
            return $resultado;
        
    }
    
    /**
     * revisa las solicitudes aprobadas para realizar el correspondiente registro en la base de datos
     */
    function revisarAprobacion(){
        //var_dump($_REQUEST);//exit;
        $aprobados=0;
        $total=(isset($_REQUEST['total_registros'])?$_REQUEST['total_registros']:0);
        if($total){
                for($i=0;$i<$total;$i++){
                    $modificado=0;
                    $nombre = "id_solicitud_".$i;
                    $nombre_valor = "valor_cumplido_".$i;
                    $nombre_finicio_cumplido = "finicio_cumplido_".$i;
                    $nombre_ffinal_cumplido = "ffinal_cumplido_".$i;
                    $nombre_dias_cumplido = "dias_cumplido_".$i;
                    $nombre_id_nov = "nov_id_".$i;
                    $nombre_vigencia = "vigencia_".$i;
                    $_REQUEST[$nombre]=(isset($_REQUEST[$nombre])?$_REQUEST[$nombre]:'');
                        
                    if($_REQUEST[$nombre]){
                        //echo "<br>".$nombre." seleccionado , id=".$_REQUEST[$nombre];
                        $acumulado = $this->calcularAcumulado($_REQUEST[$nombre],$_REQUEST[$nombre_valor],$_REQUEST[$nombre_dias_cumplido]);
                        //var_dump($acumulado);exit;
                        $modificado = $this->aprobarSolicitud($_REQUEST[$nombre],$_REQUEST[$nombre_valor],$_REQUEST[$nombre_finicio_cumplido],$_REQUEST[$nombre_ffinal_cumplido],$_REQUEST[$nombre_dias_cumplido],$acumulado['valor'],$acumulado['dias']);
                            if($modificado>0){
                                    $id_cumplido=$_REQUEST[$nombre];
                                    $id_novedad=$_REQUEST[$nombre_id_nov];
                                    $vigencia=$_REQUEST[$nombre_vigencia];
                                    if($id_novedad){
                                        $this->insertarNovedadCumplido($id_cumplido,$vigencia,$id_novedad);
                                    }
                                    $datos_cumplidos = $this->consultarSolicitudes("", "", $id_cumplido,'');
                                    $vigencia=$datos_cumplidos[0]['vigencia'];
                                    $interno_co= $datos_cumplidos[0]['interno_co'];
                                    $datos_contrato = $this->consultarDatosContrato($interno_co, $vigencia);

                                    $cedula=$datos_contrato[0]['NUM_IDENTIFICACION'];
                                    $interno_mc=$datos_contrato[0]['INTERNO_MC'];
                                    $unidad=$datos_contrato[0]['CODIGO_UNIDAD_EJECUTORA'];
                                    $cod_supervisor=$datos_contrato[0]['FUNCIONARIO'];
                                    $cod_archivo=$cedula."_".$id_cumplido;
                                    $this->generarCumplido($id_cumplido,$cedula,$vigencia,$interno_mc,$unidad,$cod_supervisor,$cod_archivo);
                                    $aprobados++;
                            }
                    }
                     //exit;
                }
                if($aprobados>0){
                        $mensaje = $aprobados. " solicitudes aprobadas con exito";
                }else{
                        $mensaje = " No se aprobó ninguna solicitud";
                }
                $pagina=$this->configuracion["host"].$this->configuracion["site"]."/index.php?";
                $variable="pagina=nom_adminCumplidoSupervisor";
                $variable.="&opcion=revisar_solicitud";
                
                $variable=$this->cripto->codificar_url($variable,$this->configuracion);
                $this->retornar($pagina,$variable,$mensaje);
 
        }
    }
    
    /**
     * Funcion que toma los datos para actualizar la solicitud
     * @param int $id_solicitud
     * @param double $valor_cumplido
     * @param date $finicial_cumplido
     * @param date $ffinal_cumplido
     * @param int $dias_cumplido
     * @param double $valor_acumulado
     * @param int $dias_acumulados
     * @return type 
     */
    function aprobarSolicitud($id_solicitud,$valor_cumplido,$finicial_cumplido,$ffinal_cumplido,$dias_cumplido,$valor_acumulado,$dias_acumulados){
        
            $aprobado=$this->actualizarSolicitud($id_solicitud,$valor_cumplido,$finicial_cumplido,$ffinal_cumplido,$dias_cumplido,$valor_acumulado,$dias_acumulados);
            return $aprobado;
    }
    
    /**
     * Actualiza en la base de datos la informacion de una solicitud de cumplido
     * @param int $id_solicitud
     * @param double $valor_cumplido
     * @param date $finicial_cumplido
     * @param date $ffinal_cumplido
     * @param int $dias_cumplido
     * @param double $valor_acumulado
     * @param int $dias_acumulados
     * @return type 
     */
    function actualizarSolicitud($id_solicitud,$valor_cumplido,$finicial_cumplido,$ffinal_cumplido,$dias_cumplido,$valor_acumulado,$dias_acumulados){
            $datos=array('id'=>$id_solicitud,
                            'valor'=>$valor_cumplido,
                            'estado'=>'APROBADO',
                            'finicial'=>$finicial_cumplido,
                            'ffinal'=>$ffinal_cumplido,
                            'dias'=>$dias_cumplido,
                            'valor_acumulado'=>$valor_acumulado,
                            'dias_acumulados'=>$dias_acumulados);
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"aprobar_solicitud",$datos);
            // echo "cadena ".$cadena_sql;//exit;
            $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "");
            return $this->totalAfectados($this->configuracion, $this->acceso_nomina);
    }
    
    /**
     * Funcion para asignar los datos del contrato a las solicitudes realizadas
     * @param type $solicitudes
     * @return string 
     */
    function asignarDatosContrato($solicitudes){
        if(is_array($solicitudes)){
            foreach ($solicitudes as $key => $solicitud) {
                $identificacion = $solicitud['num_id_contratista'];
                $cod_contrato=$solicitud['interno_oc'];
                $vigencia=$solicitud['vigencia'];
                $datos_contrato = $this->consultarDatosContrato($cod_contrato,$vigencia);
                if($datos_contrato){
                    $solicitudes[$key]['identificacion']=$identificacion;
                    $solicitudes[$key]['nombre']=$datos_contrato[0]['RAZON_SOCIAL'];
                    $solicitudes[$key]['valor_contrato']=$datos_contrato[0]['CUANTIA'];
                    $solicitudes[$key]['finicio_contrato']=$datos_contrato[0]['FECHA_INICIO'];
                    $solicitudes[$key]['ffinal_contrato']=$datos_contrato[0]['FECHA_FINAL'];
                    $solicitudes[$key]['dias_contrato']=360;

                }

            }
        }else{
            $solicitudes='';
        }
        return $solicitudes;
        
    }
    
    /**
     * Funcion que retorna fechas de cumplido, valor y dias 
     * @param type $solicitudes
     * @return <array>/String 
     */
    function asignarValorCumplido($solicitudes){
        //var_dump($solicitudes);exit;
        if(is_array($solicitudes)){
            foreach ($solicitudes as $key => $solicitud) {
                $fecha_inicial=$solicitud['finicio_contrato'];
                $fecha_final=$solicitud['ffinal_contrato'];
                $valor_contrato=$solicitud['valor_contrato'];
                $tiempo_contrato_dias=$solicitud['dias_contrato'];
                $mes_cumplido=$solicitud['mes'];
                if($mes_cumplido<10){$mes_cumplido='0'.$mes_cumplido;}
                $anio_cumplido=$solicitud['anio'];
                $cumplido = $this->calcularFechasCumplido($fecha_inicial,$fecha_final,$mes_cumplido,$anio_cumplido);
                //var_dump($cumplido);
                $cumplido['dias'] = $this->calcularDiasCumplido($cumplido['finicial'],$cumplido['ffinal']);
                $dias_cumplido = $cumplido['dias'];
                $valor_dia = $this->calcularValorDia($valor_contrato,$tiempo_contrato_dias);
                $valor_cumplido = $dias_cumplido*$valor_dia;
                $solicitudes[$key]['valor']=$valor_cumplido;
                $solicitudes[$key]['finicio_cumplido']=$cumplido['finicial'];
                $solicitudes[$key]['ffinal_cumplido']=$cumplido['ffinal'];
                $solicitudes[$key]['dias_cumplido']=$dias_cumplido;

            }                       
        }else{
            $solicitudes='';
        }
        return $solicitudes;
    }
    
    /**
     * Funcion que retorna las fechas para el cumplido
     * @param date $fecha_inicial
     * @param date $fecha_final
     * @param int $mes_cumplido
     * @param int $anio_cumplido
     * @return string 
     */
    function calcularFechasCumplido($fecha_inicial,$fecha_final,$mes_cumplido,$anio_cumplido){
            $mes_inicio_contrato= substr($fecha_inicial, 5,2);
            $anio_inicio_contrato= substr($fecha_inicial, 0,4);
            $mes_fin_contrato= substr($fecha_final, 5,2);
            $anio_fin_contrato= substr($fecha_final, 0,4);
            //revisamos la fecha inicial si corresponde a la fecha inicial del contrato
            if($mes_cumplido==$mes_inicio_contrato && $anio_cumplido==$anio_inicio_contrato){
                $finicial_cumplido=$fecha_inicial;
            }else{
                $finicial_cumplido=$anio_cumplido.'-'.$mes_cumplido.'-01';
            }
            
            //revisamos la fecha final si corresponde a la fecha final del contrato
            if($mes_cumplido==$mes_fin_contrato && $anio_cumplido==$anio_fin_contrato){
                $ffinal_cumplido=$fecha_final;
            }else{
                $mes = mktime( 0, 0, 0, $mes_cumplido, 1, $anio_cumplido ); 
                $numeroDeDias = date("t",$mes); 
                $ffinal_cumplido=$anio_cumplido.'-'.$mes_cumplido.'-'.$numeroDeDias;
            }
            
            $resultado=array(
                            'finicial'=>$finicial_cumplido,
                            'ffinal'=>$ffinal_cumplido
            );
            
            return $resultado;
    }
    
    /**
     * Funcion que calcula la cantidad de dias para un cumplido con base a la fecha inicial y la fecha final del cumplido
     * @param type $fecha_inicio
     * @param string $fecha_fin
     * @return int 
     */
    function calcularDiasCumplido($fecha_inicio,$fecha_fin){
        $dia_fin= substr($fecha_fin, 8,2);
        $mes_fin= substr($fecha_fin, 5,2);
        $ano_fin= substr($fecha_fin, 0,4);
           
        if($dia_fin==28 && $mes_fin=='02'){
            $fecha_fin=$ano_fin.'-'.$mes_fin.'-30';
        }
        $dias= ((strtotime($fecha_fin)-strtotime($fecha_inicio))/86400);    
        $dias++;
        if($dias>30){
            $dias=30;
        }
        return $dias;
    }
    
    
    /**
     * Funcion que calcula el valor a pagar por día
     * @param double $valor_contrato
     * @param int $tiempo_contrato_dias
     * @return double 
     */
    function calcularValorDia($valor_contrato,$tiempo_contrato_dias){
            $valor_dia = $valor_contrato/$tiempo_contrato_dias;
            return $valor_dia;
    }
    
    
    /**
     * Funcion que retorna la informacion del cumplido del mes anterior de un contrato, de acuerdo a los parametros ingresados
     * @param int $vigencia
     * @param int $num_contrato
     * @param int $mes
     * @param int $anio
     * @return <array>
     */
    function consultarCumplidoAnterior($vigencia,$num_contrato,$mes,$anio){
        
        $mesanterior =  date("Y-m",mktime(0,0,0,$mes-1,date("d"),$anio));
        $anio_anterior = substr($mesanterior, 0,4);
        $mes_anterior = substr($mesanterior, 5,2);
        
        $datos_cumplidos = $this->consultarSolicitudes($vigencia,$num_contrato,'','');
        $solicitud = $this->buscarSolicitudMes($datos_cumplidos,$anio_anterior,$mes_anterior);
        return $solicitud;
    }
    
    
    /**
     * Funcion que busca en un arreglo de solicitudes, una solicitud aprobada correspondiente a un mes especifico
     * @param <array> $datos_cumplidos
     * @param int $anio
     * @param int $mes
     * @return <array>  
     */
    function buscarSolicitudMes($datos_cumplidos,$anio,$mes){
        $indice='';
        foreach ($datos_cumplidos as $key => $cumplido) {
            if($cumplido['anio']==$anio && $cumplido['mes']==$mes && $cumplido['estado']=='APROBADO'){
                $indice=$key;
            }
        }
        if($indice){
            return $datos_cumplidos[$indice];
        }else{
            return $indice;
        }
    }
    
    /**
     * Funcion que calcula el valor y los dias acumulado para un cumplido
     * @param int $id_solicitud
     * @param double $valor_cumplido
     * @param int $dias_cumplido
     * @return <array> 
     */
    function calcularAcumulado($id_solicitud,$valor_cumplido,$dias_cumplido){
        $cumplido = $this->consultarSolicitudes('','',$id_solicitud,'');
        $anio = $cumplido[0]['anio'];
        $mes = $cumplido[0]['mes'];
        $vigencia=$cumplido[0]['vigencia'];
        $num_contrato=$cumplido[0]['num_contrato'];
        
        $cumplido_anterior = $this->consultarCumplidoAnterior($vigencia,$num_contrato,$mes,$anio);
        $valor_acumulado = (isset($cumplido_anterior['acumulado_valor_pagos'])?$cumplido_anterior['acumulado_valor_pagos']:0)+$valor_cumplido;
        $dias_acumulados = (isset($cumplido_anterior['acumulado_dias_pagos'])?$cumplido_anterior['acumulado_dias_pagos']:0)+$dias_cumplido;
        
        $acumulado['valor']=$valor_acumulado;
        $acumulado['dias']=$dias_acumulados;
        return $acumulado;
        
    }
    
   
    /**
        *Funcion que llama el metodo para crear el cumplido de labores
        */
       function generarCumplido($id_cumplido,$cedula,$vigencia,$interno_mc,$unidad,$cod_supervisor,$cod_archivo){
           $tipo_documento=1;
           //var_dump($_REQUEST);exit;
           
           $parametro_sql=array('ID_CUMPLIDO'=>$id_cumplido,
                                'CEDULA'=>$cedula,
                                'VIGENCIA'=>$vigencia,
                                'INTERNO_MC'=>$interno_mc,
                                'UNIDAD'=>$unidad,
                                'COD_SUPERVISOR'=>$cod_supervisor
                                );

           include_once($this->configuracion["raiz_documento"] . $this->configuracion["bloques"]."/nomina/contratistas/nom_admin_cumplido_supervisor". $this->configuracion["clases"] . "/crearDocumento.class.php");
                $this->Documento = new crearDocumento($this->configuracion);
                $this->Documento->crearDocumento($tipo_documento,$parametro_sql,$cod_archivo);
       
       }
       
     /**
        * Funcion que consulta los datos de un documento
        * @param int $codigo
        * @return <array> 
        */
       function consultarDocumento($codigo){
            $cadena_sql=$this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"documento",$codigo);
//            echo "<br>cadena ".$cadena_sql;exit;
            return $resultado=$this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "busqueda");
		    
       }   

       /**
        * Funcion para obtener la cadena con los codigos internos de los contratos de un supervisor
        * @param <array> $contratos
        * @return String 
        */
       function obtenerCadenaCodigosInternosContrato($contratos){
           $cadena="";
           if(is_array($contratos)){
               foreach ($contratos as $contrato) {
                   if($cadena){
                        $cadena .= ",".$contrato['INTERNO_OC'];
                   }else{
                        $cadena = $contrato['INTERNO_OC'];
                   }
               }
           }
           return $cadena;
       }
       
       /**
        * Funcion para obtener el codigo de un supervisor a partir del numero de identificacion del usuario
        * @param int $identificacion
        * @return int 
        */
       function obtenerCodigoInternoSupervisor($identificacion){
           $codigo_supervisor=0;
           $resultado = $this->consultarDependenciaUsuario($identificacion);
           //var_dump($resultado);exit;
           if($resultado){
               $dependencia=$resultado[0]['id_dependencia'];
               $codigo_supervisor=$this->consultarCodigoInternoSupervisor($dependencia);
               
           }
           return $codigo_supervisor;
       }
       
       /**
        * Funcion para consultar en la base de datos el codigo de la dependencia de un usuario
        * @param int $identificacion
        * @return <array> 
        */
       function consultarDependenciaUsuario($identificacion){
           $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_db,"codigo_dependencia",$identificacion);
//            echo "<br>cadena ".$cadena_sql;exit;
           return $resultado = $this->ejecutarSQL($this->configuracion, $this->acceso_db, $cadena_sql, "busqueda");
           
       }
       
       /**
        * Funcion para consultar el codigo interno del supervisor de una dependencia
        * @param int $dependencia
        * @return int
        */
       function consultarCodigoInternoSupervisor($dependencia){
           $codigo_supervisor=0;
           $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_sic,"codigo_supervisor",$dependencia);
           //echo "<br>cadena ".$cadena_sql;exit;
           $resultado = $this->ejecutarSQL($this->configuracion, $this->acceso_sic, $cadena_sql, "busqueda");
           if($resultado){
               $codigo_supervisor=$resultado[0]['COD_JEFE'];
           }
           return $codigo_supervisor;
       }
       
       /**
     * Funcion que retorna solicitudes con valores de AFC si lo tienen
     * @param <array> $solicitudes
     * @return <array>/String 
     */
    function asignarValorAFC($solicitudes){
        //var_dump($solicitudes);exit;
        if(is_array($solicitudes)){
            foreach ($solicitudes as $key => $solicitud) {
                $vigencia=$solicitud['vigencia'];
                $num_contrato=$solicitud['num_contrato'];
                $fecha_inicial_cum=$solicitud['finicio_cumplido'];
                $fecha_final_cum=$solicitud['ffinal_cumplido'];
                $afc = $this->consultarNovedadAFCContrato($vigencia,$num_contrato,$fecha_inicial_cum,$fecha_final_cum);
                if(is_array($afc)){
                    $solicitudes[$key]['valor_afc']=$afc[0]['nov_valor'];
                    $solicitudes[$key]['nov_id']=$afc[0]['nov_id'];
                }else{
                    $solicitudes[$key]['valor_afc']=0;
                }
                
            }                       
        }else{
            $solicitudes='';
        }
        //var_dump($solicitudes);exit;
        return $solicitudes;
    }
    
    function consultarNovedadAFCContrato($vigencia,$cod_contrato,$finicio_per_pago,$ffinal_per_pago){
            $datos= array(  'vigencia'=>$vigencia,
                            'cod_contrato'=>$cod_contrato,
                            'finicio_per_pago'=>$finicio_per_pago,
                            'ffinal_per_pago'=>$ffinal_per_pago
                );
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"novedad_afc_contrato",$datos);
            //echo "<br>cadena ".$cadena_sql;exit;
            return $resultado = $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "busqueda");
          
    }
    
       /**
     * Ingresa en la BD el codigo de la novedad relacionada a un cumplido
     * @param int $id_cumplido
     * @param int $vigencia
     * @param int $id_novedad
     * @return int
     */
    function insertarNovedadCumplido($id_cumplido,$vigencia,$id_novedad){
            $datos=array('id_cumplido'=>$id_cumplido,
                            'vigencia'=>$vigencia,
                            'id_novedad'=>$id_novedad,
                            'estado'=>'A'
                            );
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"insertar_novedad_cumplido",$datos);
             //echo "cadena ".$cadena_sql;exit;
            $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "");
            return $this->totalAfectados($this->configuracion, $this->acceso_nomina);
    }
    
  /**
         * Funcion que llama el formulario para solicitar un cumplido
         */
        function consultar(){
            
            $cod_supervisor=$this->obtenerCodigoInternoSupervisor($this->identificacion);
            //echo "<br>cod_sup ".$cod_supervisor;exit;
            $contratos = $this->consultarContratosSupervisor($cod_supervisor);
            
            $codigos_internos=$this->obtenerCadenaCodigosInternosContrato($contratos);
//            echo "<br>cod_internos ".$codigos_internos;exit;
//            var_dump($contratos);exit;
            $solicitudes = $this->consultarSolicitudes('','','',$codigos_internos);
                        //var_dump($solicitudes);exit;
            $this->mostrarListadoSolicitudes($solicitudes);
            
        }
       
} // fin de la clase
	

?>


                
                