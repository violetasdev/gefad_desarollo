<?php
/*--------------------------------------------------------------------------------------------------------------------------
  @ Derechos de Autor: Vea el archivo LICENCIA.txt que viene con la distribucion
---------------------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------
 |				Control Versiones				    	|	
 ----------------------------------------------------------------------------------------
 | fecha      |        Autor            | version     |              Detalle            |
 ----------------------------------------------------------------------------------------
 | 17/04/2013 | Maritza Callejas C.  	| 0.0.0.1     |                                 |
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
class funciones_adminNominaOrdenador extends funcionGeneral
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
                
                $this->htmlNomina = new html_adminNominaOrdenador($configuracion);   
                
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
			case "multiplesNominas":
                                //$datos_documento = $this->consultarDocumento(1);
            			$this->htmlNomina->multiplesNominas($configuracion,$registro);
				break;
		
		}
		
	}
	
		
/*__________________________________________________________________________________________________
		
						Metodos especificos 
__________________________________________________________________________________________________*/

    
  
  
        /**
         * Funcion para consultar nominas 
         */
        function consultar(){
            
            //$cod_ordenador=$this->obtenerCodigoInternoOrdenador($this->identificacion);
            //echo "<br>cod_sup ".$cod_ordenador;exit;
            $cod_ordenador=3;
            $id_ordenador=79297396;
            $nominas = $this->consultarNomina($id_ordenador,'');
            //var_dump($nominas);exit;
            $this->mostrarListadoNomina($nominas);
            
        }
       
         
       /**
        * Funcion para obtener el codigo de un ordenador a partir del numero de identificacion del usuario
        * @param int $identificacion
        * @return int 
        */
       function obtenerCodigoInternoOrdenador($identificacion){
           $codigo_ordenador=0;
           $resultado = $this->consultarDependenciaUsuario($identificacion);
           if($resultado){
               $dependencia=$resultado[0]['id_dependencia'];
               $codigo_ordenador=$this->consultarCodigoInternoOrdenador($dependencia);
               
           }
           return $codigo_ordenador;
       }
       
        
       /**
        * Funcion para consultar el codigo interno del ordenador de una dependencia
        * @param int $dependencia
        * @return int
        */
       function consultarCodigoInternoOrdenador($dependencia){
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
     * Funcion que consulta los registros de las nominas 
     * @param int $vigencia
     * @param int $cod_contrato
     * @return <array> 
     */
    function consultarNomina($id_ordenador,$id_supervisor){
            $datos=array(   'id_ordenador'=>$id_ordenador,
                            'id_supervisor'=>$id_supervisor);
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"nomina",$datos);
            echo "<br>cadena ".$cadena_sql;
            $resultado = $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "busqueda");
            return $resultado;
        
    }
    
     /**
     * Funcion que recorre el arreglo con las solicitudes y llama al metodo de mostrar la información relacionada
     * @param <array> $registro 
     */
    function mostrarListadoNomina($registro){
       
        if(is_array($registro)){
                  
               $this->mostrarRegistro($this->configuracion,$registro, $this->configuracion['registro'], "multiplesNominas", "");

        }else{
            echo "No tiene solicitudes de cumplido registradas";
        }
        
         
    }

    /**
     * Funcion para consultar los detalles de una nomina y armar el arreglo para el reporte 
     */
    function consultarListadoDetalles(){
            $id_nomina=(isset($_REQUEST['id_nomina'])?$_REQUEST['id_nomina']:$_REQUEST['id_nomina']);
            $detalles = $this->consultarDetallesNomina($id_nomina);
            if($detalles ){
                foreach ($detalles as $key =>  $detalle) {
                     
                    $tipo_id_contratista = $detalle['cto_con_tipo_id'];
                    $cto_interno_co = $detalle['cto_interno_co'];
                    $cto_uni_ejecutora = $detalle['cto_uni_ejecutora'];
                    $id = $detalle['dtn_id'];
                    $nom_id = $detalle['dtn_nom_id'];
                    $cum_cto_vigencia = $detalle['dtn_cum_cto_vigencia'];
                    $cum_id = $detalle['dtn_cum_id'];
                    
                    $num_id_contratista = $detalle['cto_con_num_id'];
                    $datos_contratista = $this->consultarDatosContratista($num_id_contratista);
                    $datos_contrato = $this->consultarDatosContrato($cto_interno_co, $cum_cto_vigencia);
                    $cod_interno_minuta_contrato = $datos_contrato[0]['INTERNO_MC'];
                    $datos_disponibilidad = $this->consultarDatosDisponibilidad($cod_interno_minuta_contrato, $cto_uni_ejecutora, $cum_cto_vigencia);
                    $num_cdp = $datos_disponibilidad[0]['NUMERO_DISPONIBILIDAD'];
                    $datos_registro = $this->consultarDatosRegistroPresupuestal($num_cdp, $cto_uni_ejecutora, $cum_cto_vigencia);
                    
                    //Armamos el arreglo con la informacion del reporte
                    $registro[$key]['no_c.c_o_nit'] = $num_id_contratista;
                    $registro[$key]['primer_apellido'] = $datos_contratista[0]['PRIMER_APELLIDO'];
                    $registro[$key]['segundo_apellido'] = $datos_contratista[0]['SEGUNDO_APELLIDO'];
                    $registro[$key]['primer_nombre'] = $datos_contratista[0]['PRIMER_NOMBRE'];
                    $registro[$key]['segundo_nombre'] = (isset($datos_contratista[0]['SEGUNDO_NOMBRE'])?$datos_contratista[0]['SEGUNDO_NOMBRE']:'');
                    $registro[$key]['tipo_contrato'] = $detalle['cto_tipo_contrato'];
                    $registro[$key]['numero_contrato'] = $detalle['cto_num'];
                    $registro[$key]['C.D.P._No'] = $num_cdp;
                    $registro[$key]['R.P._No'] = $datos_registro[0]['NUMERO_REGISTRO'];
                    $registro[$key]['codigo_banco'] = $detalle['ban_id'];
                    $registro[$key]['nombre_banco'] = $detalle['ban_nombre'];
                    $registro[$key]['tipo_cuenta'] = $detalle['cta_tipo'];
                    $registro[$key]['cuenta_No'] = $detalle['cta_num'];
                    $registro[$key]['porcentaje_retefuente'] = $detalle['dtn_porc_retefuente'];
                    $registro[$key]['valor_neto_a_abonar_a_la_cuenta_bancaria'] = $detalle['dtn_neto_abonar_cta_bancaria'];
                    $registro[$key]['valor_neto_a_aplicar_en_sicapital'] = $detalle['dtn_neto_aplicar_sic'];
                    $registro[$key]['valor_contrato'] = $datos_contrato[0]['CUANTIA'];
                    $registro[$key]['fecha_inicio'] = $datos_contrato[0]['FECHA_INICIO'];
                    $registro[$key]['fecha_final'] = $datos_contrato[0]['FECHA_FINAL'];
                    $registro[$key]['valor_saldo_antes_de_pago'] = $detalle['dtn_saldo_antes_pago'];
                    $registro[$key]['fecha_inicio_periodo'] = $detalle['dtn_fecha_inicio_per'];
                    $registro[$key]['fecha_corte_periodo'] = $detalle['dtn_fecha_final_per'];
                    $registro[$key]['dias_pagados'] = $detalle['dtn_num_dias_pagados'];
                    $registro[$key]['regimen_comun'] = $detalle['dtn_regimen_comun'];
                    $registro[$key]['valor_liquidacion_antes_iva'] = $detalle['dtn_valor_liq_antes_iva'];
                    $registro[$key]['valor_iva'] = $detalle['dtn_valor_iva'];
                    $registro[$key]['valor_total'] = $detalle['dtn_valor_total'];
                    $registro[$key]['valor_base_retefuente_renta'] = $detalle['dtn_base_retefuente_renta'];
                    $registro[$key]['valor_retefuente_renta'] = $detalle['dtn_valor_retefuente_renta'];
                    $registro[$key]['valor_reteiva'] = $detalle['dtn_valor_reteiva'];
                    $registro[$key]['valor_base_ica_estampillas'] = $detalle['dtn_base_ica_estampillas'];
                    $registro[$key]['valor_ica'] = $detalle['dtn_valor_ica'];
                    $registro[$key]['valor_estampilla_ud'] = $detalle['dtn_estampilla_ud'];
                    $registro[$key]['valor_estampilla_procultura'] = $detalle['dtn_estampilla_procultura'];
                    $registro[$key]['valor_estampilla_pro-adultomayor'] = $detalle['dtn_estampilla_proadultomayor'];
                    $registro[$key]['valor_arp'] = $detalle['dtn_arp'];
                    $registro[$key]['valor_dcto_cooperativas_y_depositos_judiciales'] = $detalle['dtn_cooperativas_depositos'];
                    $registro[$key]['valor_afc'] = $detalle['dtn_afc'];
                    $registro[$key]['valor_total_descuento_sin_retenciones'] = $detalle['dtn_total_dctos_sin_retenciones'];
                    $registro[$key]['valor_neto_a_pagar_sin_aplicar_retenciones'] = $detalle['dtn_neto_pagar_sin_retenciones'];
                    $registro[$key]['valor_saldo_del_contrato_al_corte'] = $detalle['dtn_saldo_contrato_al_corte'];
                    $registro[$key]['valor_salud'] = $detalle['dtn_salud'];
                    $registro[$key]['valor_pension'] = $detalle['dtn_pension'];
                    $registro[$key]['pensionado'] = $detalle['dtn_pensionado'];
                    $registro[$key]['pago_saldo_menores'] = $detalle['dtn_pago_saldo_menores'];
                    $registro[$key]['pasante_monitoria'] = $detalle['dtn_pasante_monitoria'];
                                
                }
               
            }
            //var_dump($registro);exit;
            $this->htmlNomina->mostrarReportes($this->configuracion, $registro, "Reporte de Nomina", "Reporte Detalle de nómina");
            
            
        }
        
    
    /**
        * Funcion para consultar en la BD los detalles de una nomina
        * @param type $id_nomina
        * @return type 
        */
    function consultarDetallesNomina($id_nomina){

        $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"detalle_nomina",$id_nomina);
        //echo "<br>cadena ".$cadena_sql;exit;
        $resultado = $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "busqueda");
        return $resultado;

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
     * Funcion que muestra las solicitudes, para revisarlas y aprobarlas
     */
    function revisarSolicitudPagoNomina(){
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["bloques"]."/nomina/contratistas/nom_admin_cumplido_supervisor". $this->configuracion["clases"] . "/liquidacionNomina.class.php");
        $this->Liquidacion = new liquidacionNomina($this->configuracion);
        
            $cod_ordenador=3;
            $id_ordenador=79297396;
            $solicitudes = $this->consultarSolicitudesNomina($id_ordenador,'');
            if(is_array($solicitudes)){
                foreach ($solicitudes as $key => $solicitud) {
                    $parametro[0]['nombre_parametro']='valor_mes';
                    $parametro[0]['valor_parametro']=$solicitud['valor_antes_iva'];
                    $parametro[1]['nombre_parametro']='liq_salud';
                    $parametro[1]['valor_parametro']=$solicitud['salud'];
                    $parametro[2]['nombre_parametro']='liq_pension';
                    $parametro[2]['valor_parametro']=$solicitud['pension'];
                    $parametro[3]['nombre_parametro']='liq_arp';
                    $parametro[3]['valor_parametro']=$solicitud['arp'];

                    //$solicitudes[$key]['retefuente'] = $this->asignarValorRetefuente($solicitud);
                    $solicitudes[$key]['estampilla_ud'] = $this->Liquidacion->obtenerValorLiquidacion(4,'liq_estampilla_ud',$parametro);
                    $solicitudes[$key]['estampilla_procultura'] = $this->Liquidacion->obtenerValorLiquidacion(5,'liq_estampilla_procultura',$parametro);
                    $solicitudes[$key]['estampilla_proadultomayor'] = $this->Liquidacion->obtenerValorLiquidacion(6,'liq_estampilla_proadultomayor',$parametro);
                    $solicitudes[$key]['regimen']='SIMPLIFICADO';
                    if($solicitudes[$key]['regimen']=='COMUN'){
                        $solicitudes[$key]['iva'] = $this->Liquidacion->obtenerValorLiquidacion(8,'liq_iva',$parametro);
                        $parametro[4]['nombre_parametro']='liq_iva';
                        $parametro[4]['valor_parametro']= $solicitudes[$key]['iva'];
                        $solicitudes[$key]['reteiva'] = $this->Liquidacion->obtenerValorLiquidacion(9,'liq_reteiva',$parametro);
                    }else{
                        $solicitudes[$key]['iva'] = 0;
                        $solicitudes[$key]['reteiva'] = 0;
                    }
                    $solicitudes[$key]['ica'] = $this->Liquidacion->obtenerValorLiquidacion(10,'liq_ica',$parametro);
                    
                }   
                   
            }
            //var_dump($solicitudes);exit;

            $this->htmlNomina->form_revisar_solicitud($this->configuracion, $solicitudes);
        }
    
    
    /**
        * Funcion para consultar Solicitudes de nomina
        * @param type $id_ordenador
        * @param type $id_supervisor
        * @return type 
        */
    function consultarSolicitudesNomina($id_ordenador,$id_supervisor){
        $datos=array(   'id_ordenador'=>$id_ordenador,
                        'id_supervisor'=>$id_supervisor);
        $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"solicitudes_nomina",$datos);
        echo "<br>cadena ".$cadena_sql;
        return $resultado= $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "busqueda");
	
    }
  
    /**
     * Funcion para asignar el valor de retefuente
     * @param type $solicitud
     * @return string 
     */
    function asignarValorRetefuente($solicitud){
        var_dump($solicitud );exit;
        if(is_array($solicitud)){
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
                                  
        }else{
            $solicitudes='';
        }
        //var_dump($solicitudes);exit;
        return $solicitudes;
    }
    
    
     /**
     * revisa las solicitudes seleccionadas para aprobar y realizar el correspondiente registro en la base de datos
     */
    function revisarAprobacionPagoNomina(){
        //var_dump($_REQUEST);exit;
        $aprobados=0;
        $total=(isset($_REQUEST['total_registros'])?$_REQUEST['total_registros']:0);
        if($total){
                for($i=0;$i<$total;$i++){
                    $modificado=0;
                    $nombre = "id_solicitud_".$i;
                    $nombre_valor_retefuente = "valor_retefuente_".$i;
                    $nombre_valor_iva = "valor_iva_".$i;
                    $nombre_valor_reteiva = "valor_reteiva_".$i;
                    $nombre_valor_ica= "valor_ica_".$i;
                    $nombre_valor_estampilla_ud = "valor_estampilla_ud_".$i;
                    $nombre_valor_estampilla_procultura = "valor_estampilla_procultura_".$i;
                    $nombre_valor_estampilla_proadultomayor = "valor_estampilla_proadultomayor_".$i;
                    $nombre_vigencia = "vigencia_".$i;
                    $_REQUEST[$nombre]=(isset($_REQUEST[$nombre])?$_REQUEST[$nombre]:'');
                        
                    if($_REQUEST[$nombre]){
                            $modificado = $this->aprobarSolicitud($_REQUEST[$nombre],$_REQUEST[$nombre_valor_retefuente],$_REQUEST[$nombre_valor_iva],$_REQUEST[$nombre_valor_reteiva],$_REQUEST[$nombre_valor_ica], $_REQUEST[$nombre_valor_estampilla_ud], $_REQUEST[$nombre_valor_estampilla_procultura], $_REQUEST[$nombre_valor_estampilla_proadultomayor]);
                            if($modificado>0){
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
                $variable="pagina=nom_adminNominaOrdenador";
                $variable.="&opcion=revisarSolicitudNomina";
                
                $variable=$this->cripto->codificar_url($variable,$this->configuracion);
                $this->retornar($pagina,$variable,$mensaje);
 
        }
    }
    
    /**
     * Funcion para aprobar la solicitud de pago 
     * @param int $id_solicitud
     * @param double $nombre_valor_retefuente
     * @param double $nombre_valor_iva
     * @param double $nombre_valor_reteiva
     * @param double $nombre_valor_ica
     * @param double $nombre_valor_estampilla_ud
     * @param double $nombre_valor_estampilla_procultura
     * @param double $nombre_valor_estampilla_proadultomayor
     * @return int 
     */
    function aprobarSolicitud($id_solicitud,$nombre_valor_retefuente,$nombre_valor_iva,$nombre_valor_reteiva,$nombre_valor_ica,$nombre_valor_estampilla_ud,$nombre_valor_estampilla_procultura,$nombre_valor_estampilla_proadultomayor){
        
            $aprobado=$this->actualizarSolicitudPago($id_solicitud,$nombre_valor_retefuente,$nombre_valor_iva,$nombre_valor_reteiva,$nombre_valor_ica,$nombre_valor_estampilla_ud,$nombre_valor_estampilla_procultura,$nombre_valor_estampilla_proadultomayor);
            return $aprobado;
    }
    
    /**
     * 
     * @param int $id_solicitud
     * @param double $valor_retefuente
     * @param double $valor_iva
     * @param double $valor_reteiva
     * @param double $valor_ica
     * @param double $valor_estampilla_ud
     * @param double $valor_estampilla_procultura
     * @param double $valor_estampilla_proadultomayor
     * @return int 
     */
    function actualizarSolicitudPago($id_solicitud,$valor_retefuente,$valor_iva,$valor_reteiva,$valor_ica,$valor_estampilla_ud,$valor_estampilla_procultura,$valor_estampilla_proadultomayor){
            $datos=array('id'=>$id_solicitud,
                            'valor_retefuente'=>$valor_retefuente,
                            'valor_iva'=>$valor_iva,
                            'valor_reteiva'=>$valor_reteiva,
                            'valor_ica'=>$valor_ica,
                            'valor_estampilla_ud'=>$valor_estampilla_ud,
                            'valor_estampilla_procultura'=>$valor_estampilla_procultura,
                            'valor_estampilla_proadultomayor'=>$valor_estampilla_proadultomayor,
                            'estado'=>'APROBADO');
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"aprobar_solicitud_pago",$datos);
             //echo "cadena ".$cadena_sql;exit;
            $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "");
            return $this->totalAfectados($this->configuracion, $this->acceso_nomina);
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
     * Funcion que muestra las solicitudes de pagos de nomina , liquida valores pendientes para nomina
     */
    function revisarPagoNomina(){
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["bloques"]."/nomina/contratistas/nom_admin_cumplido_supervisor". $this->configuracion["clases"] . "/liquidacionNomina.class.php");
        $this->Liquidacion = new liquidacionNomina($this->configuracion);
        $registro='';
            $cod_ordenador=3;
            $id_ordenador=79297396;
            $solicitudes = $this->consultarSolicitudesAprobadasNomina($id_ordenador,'','');
            if(is_array($solicitudes)){
                foreach ($solicitudes as $key => $solicitud) {
                    
                    $cto_interno_co = $solicitud['interno_co'];
                    $cto_uni_ejecutora = $solicitud['unidad_ejecutora'];
                    $cum_cto_vigencia = $solicitud['vigencia'];
                    
                    $num_id_contratista = $solicitud['num_id'];
                    $datos_contratista = $this->consultarDatosContratista($num_id_contratista);
                    $datos_contrato = $this->consultarDatosContrato($cto_interno_co, $cum_cto_vigencia);
                    $cod_interno_minuta_contrato = $datos_contrato[0]['INTERNO_MC'];
                    $datos_disponibilidad = $this->consultarDatosDisponibilidad($cod_interno_minuta_contrato, $cto_uni_ejecutora, $cum_cto_vigencia);
                    $num_cdp = $datos_disponibilidad[0]['NUMERO_DISPONIBILIDAD'];
                    $datos_registro = $this->consultarDatosRegistroPresupuestal($num_cdp, $cto_uni_ejecutora, $cum_cto_vigencia);
                    
                    //Armamos el arreglo con la informacion 
                    $registro[$key]['detalle_id'] = $solicitud['detalle_id'];
                    $registro[$key]['identificacion'] = $num_id_contratista;
                    $registro[$key]['primer_apellido'] = $datos_contratista[0]['PRIMER_APELLIDO'];
                    $registro[$key]['segundo_apellido'] = $datos_contratista[0]['SEGUNDO_APELLIDO'];
                    $registro[$key]['primer_nombre'] = $datos_contratista[0]['PRIMER_NOMBRE'];
                    $registro[$key]['segundo_nombre'] = (isset($datos_contratista[0]['SEGUNDO_NOMBRE'])?$datos_contratista[0]['SEGUNDO_NOMBRE']:'');
                    $registro[$key]['vigencia'] = $solicitud['vigencia'];
                    $registro[$key]['tipo_contrato'] = $solicitud['tipo_contrato'];
                    $registro[$key]['numero_contrato'] = $solicitud['num_contrato'];
                    $registro[$key]['cdp'] = $num_cdp;
                    $registro[$key]['rp'] = $datos_registro[0]['NUMERO_REGISTRO'];
                    $registro[$key]['codigo_banco'] = $solicitud['ban_id'];
                    $registro[$key]['nombre_banco'] = $solicitud['ban_nombre'];
                    $registro[$key]['tipo_cuenta'] = $solicitud['cta_tipo'];
                    $registro[$key]['cuenta_No'] = $solicitud['cta_num'];
//                    $registro[$key]['porcentaje_retefuente'] = $solicitud['porc_retefuente'];
                    
                      
                    $registro[$key]['valor_contrato'] = $datos_contrato[0]['CUANTIA'];
                    $registro[$key]['fecha_inicio'] = $datos_contrato[0]['FECHA_INICIO'];
                    $registro[$key]['fecha_final'] = $datos_contrato[0]['FECHA_FINAL'];
                    
                    $registro[$key]['valor_saldo_antes_de_pago'] = $solicitud['saldo_antes_pago'];
                    
                    $registro[$key]['fecha_inicio_periodo'] = $solicitud['fecha_inicio_per'];
                    $registro[$key]['fecha_final_periodo'] = $solicitud['fecha_final_per'];
                    $registro[$key]['dias_pagados'] = $solicitud['num_dias_pagados'];
                    $registro[$key]['regimen_comun'] = $solicitud['regimen_comun'];
                    $registro[$key]['valor_liquidacion_antes_iva'] = $solicitud['valor_liq_antes_iva'];
                    $registro[$key]['valor_iva'] = $solicitud['valor_iva'];
                    
                    $registro[$key]['valor_base_retefuente_renta'] = $solicitud['base_retefuente_renta'];
                    $registro[$key]['valor_retefuente_renta'] = $solicitud['valor_retefuente_renta'];
                    
                    $registro[$key]['valor_reteiva'] = $solicitud['valor_reteiva'];
                    
                    $registro[$key]['valor_base_ica_estampillas'] = $solicitud['base_ica_estampillas'];
                    
                    $registro[$key]['valor_ica'] = $solicitud['valor_ica'];
                    $registro[$key]['valor_estampilla_ud'] = $solicitud['estampilla_ud'];
                    $registro[$key]['valor_estampilla_procultura'] = $solicitud['estampilla_procultura'];
                    $registro[$key]['valor_estampilla_proadultomayor'] = $solicitud['estampilla_proadultomayor'];
                    $registro[$key]['valor_arp'] = $solicitud['arp'];
                    $registro[$key]['valor_dcto_cooperativas_y_depositos_judiciales'] = $solicitud['cooperativas_depositos'];
                    $registro[$key]['valor_afc'] = $solicitud['afc'];
                    
//                    $registro[$key]['valor_saldo_del_contrato_al_corte'] = $solicitud['saldo_contrato_al_corte'];
                    
                    $registro[$key]['valor_salud'] = $solicitud['salud'];
                    $registro[$key]['valor_pension'] = $solicitud['pension'];
                    $registro[$key]['pensionado'] = $solicitud['pensionado'];
                    $registro[$key]['pago_saldo_menores'] = $solicitud['pago_saldo_menores'];
                    $registro[$key]['pasante_monitoria'] = $solicitud['pasante_monitoria'];

                    $parametro[0]['nombre_parametro']='valor_mes';
                    $parametro[0]['valor_parametro']=$solicitud['valor_liq_antes_iva'];
                    $parametro[1]['nombre_parametro']='liq_iva';
                    $parametro[1]['valor_parametro']=$registro[$key]['valor_iva'];
                    
                    $registro[$key]['valor_total'] = $this->Liquidacion->obtenerValorLiquidacion(0,'total',$parametro);
                    $registro[$key]['valor_neto_a_pagar_sin_aplicar_retenciones'] = $registro[$key]['valor_total'];

                    $parametro[2]['nombre_parametro']='total';
                    $parametro[2]['valor_parametro']=$registro[$key]['valor_total'];
                    $parametro[3]['nombre_parametro']='liq_retefuente';
                    $parametro[3]['valor_parametro']=$registro[$key]['valor_retefuente_renta'] ;
                    $parametro[4]['nombre_parametro']='liq_reteiva';
                    $parametro[4]['valor_parametro']=$registro[$key]['valor_reteiva'];
                    $parametro[5]['nombre_parametro']='liq_estampilla_ud';
                    $parametro[5]['valor_parametro']= $registro[$key]['valor_estampilla_ud'];
                    $parametro[6]['nombre_parametro']='liq_estampilla_procultura';
                    $parametro[6]['valor_parametro']=$registro[$key]['valor_estampilla_procultura'];
                    $parametro[7]['nombre_parametro']='liq_estampilla_proadultomayor';
                    $parametro[7]['valor_parametro']=$registro[$key]['valor_estampilla_pro-adultomayor'];
                    $parametro[8]['nombre_parametro']='liq_cooperativas';
                    $parametro[8]['valor_parametro']=$registro[$key]['valor_dcto_cooperativas_y_depositos_judiciales'];
                    $parametro[9]['nombre_parametro']='liq_arp';
                    $parametro[9]['valor_parametro']=$registro[$key]['valor_arp'];
                    $parametro[10]['nombre_parametro']='liq_afc';
                    $parametro[10]['valor_parametro']=$registro[$key]['valor_afc'];
                    
                    $registro[$key]['valor_neto_a_abonar_a_la_cuenta_bancaria'] =  $this->Liquidacion->obtenerValorLiquidacion(0,'neto_abonar_cuenta',$parametro);
                    $registro[$key]['valor_neto_a_aplicar_en_sicapital'] = $this->Liquidacion->obtenerValorLiquidacion(0,'neto_aplicar_sicapital',$parametro);
                    $registro[$key]['valor_total_descuento_sin_retenciones'] = $this->Liquidacion->obtenerValorLiquidacion(0,'total_dctos_sin_retenciones',$parametro);
                   
                }   
                   
            }
            //var_dump($registro);exit;
            $periodo_pago = $this->periodosPago();
            
            $this->htmlNomina->form_revisar_nomina($this->configuracion, $periodo_pago, $registro);
        }
   
      
        /**
         * Funcion para consultar 
         * @param type $id_ordenador
         * @param type $id_supervisor
         * @param type $id_detalle
         * @return type 
         */
        function consultarSolicitudesAprobadasNomina($id_ordenador,$id_supervisor,$id_detalle){
            $datos=array(   'id_ordenador'=>$id_ordenador,
                            'id_supervisor'=>$id_supervisor,
                            'id_detalle'=>$id_detalle);
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"solicitudes_aprobadas_nomina",$datos);
           // echo "<br>cadena ".$cadena_sql;exit;
            return $resultado= $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "busqueda");
	
    }
  
    
    function generarNomina(){
        //var_dump($_REQUEST);exit;
        $aprobados=0;
        $total=(isset($_REQUEST['total_registros'])?$_REQUEST['total_registros']:0);
        if($total){
                $id_nomina = $this->crearNomina();
                for($i=0;$i<$total;$i++){
                    $modificado=0;
                    
                    $nombre = "id_solicitud_".$i;
                    $nombre_total = "valor_total_".$i;
                    $nombre_neto_a_pagar_sin_aplicar_retenciones = "valor_neto_a_pagar_sin_aplicar_retenciones_".$i;
                    $nombre_neto_a_abonar_a_la_cuenta_bancaria = "valor_neto_a_abonar_a_la_cuenta_bancaria_".$i;
                    $nombre_neto_a_aplicar_en_sicapital= "valor_neto_a_aplicar_en_sicapital_".$i;
                    $nombre_total_descuento_sin_retenciones = "valor_total_descuento_sin_retenciones_".$i;
                    
                    $_REQUEST[$nombre]=(isset($_REQUEST[$nombre])?$_REQUEST[$nombre]:'');
                        
                    if($_REQUEST[$nombre]){
                            $modificado = $this->crearDetalleNomina($id_nomina,$_REQUEST[$nombre],$_REQUEST[$nombre_total],$_REQUEST[$nombre_neto_a_pagar_sin_aplicar_retenciones],$_REQUEST[$nombre_neto_a_abonar_a_la_cuenta_bancaria],$_REQUEST[$nombre_neto_a_aplicar_en_sicapital], $_REQUEST[$nombre_total_descuento_sin_retenciones]);
                            if($modificado>0){
                                    $eliminado = $this->eliminarTmpDetalleNomina($_REQUEST[$nombre]);
                            
                                    $aprobados++;
                            }
                    }
                     
                }
//                if($aprobados>0){
//                        $mensaje = $aprobados. " solicitudes aprobadas con exito";
//                }else{
//                        $mensaje = " No se aprobó ninguna solicitud";
//                }
//                $pagina=$this->configuracion["host"].$this->configuracion["site"]."/index.php?";
//                $variable="pagina=nom_adminNomin634aOrdenador";
//                $variable.="&opcion=revisarNomina";
//                
//                $variable=$this->cripto->codificar_url($variable,$this->configuracion);
//                $this->retornar($pagina,$variable,$mensaje);
 
        }
    }
    
    function crearNomina(){
        //$numero = $this->obtenerNumeroNomina();
        //var_dump($_REQUEST);exit;
        $id_nomina=$this->obtenerNumeroNomina();
        echo "<br>id_nomina ".$id_nomina;
        
        $rubro_interno=364;
        $cod_dependencia=40;
        $cod_ordenador=3;
        $id_ordenador=79297396;
        $anio =  substr($_REQUEST['periodo_pago'], 0,4);
        $mes = substr($_REQUEST['periodo_pago'], 4,2);
        echo "<br>anio ".$anio;
        echo "<br>mes ".$mes;
        $nomina = $this->insertarNomina($id_nomina,$rubro_interno,$cod_dependencia,$cod_ordenador,$id_ordenador, $anio,$mes);
        if($nomina){
            return $id_nomina;
        }else{
            return null;
        }
    }
   
    function obtenerNumeroNomina(){
        $numero = $this->consultarUltimoNumeroNomina();
        $numero++;
        return $numero;
    }
    
    function consultarUltimoNumeroNomina(){

            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"ultimo_numero_nomina","");
            //echo "cadena ".$cadena_sql;exit;
            $datos = $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "busqueda");
            return $datos[0][0];
    }
    
    function insertarNomina($id_nomina,$rubro_interno,$cod_dependencia,$cod_ordenador,$id_ordenador, $anio,$mes){
            $datos = array('id_nomina'=>$id_nomina,
                                'rubro_interno'=>$rubro_interno,
                                'cod_dependencia'=>$cod_dependencia,
                                'cod_ordenador'=>$cod_ordenador,
                                'id_ordenador'=>$id_ordenador,
                                'anio'=>$anio,
                                'mes'=>$mes,
                                'fecha_registro'=>date('Y-m-d'),
                                'estado_registro'=>'GENERADA',
                                'estado'=>'A');
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"insertar_nomina",$datos);
             //echo "cadena ".$cadena_sql;//exit;
            $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "");
            return $this->totalAfectados($this->configuracion, $this->acceso_nomina);
    }
   
       function crearDetalleNomina($id_nomina,$id_detalle,$total,$neto_a_pagar_sin_aplicar_retenciones,$neto_a_abonar_a_la_cuenta_bancaria,$neto_a_aplicar_en_sicapital, $total_descuento_sin_retenciones){
           $solicitud = $this->consultarSolicitudesAprobadasNomina('','',$id_detalle);
           //var_dump($solicitud);exit;
            $datos = array( 'id_detalle'=>$id_detalle,
                            'id_nomina'=>$id_nomina,
                            'id_cumplido'=>$solicitud[0]['cum_id'],
                            'vigencia'=>$solicitud[0]['vigencia'],
                            'porc_retefuente'=>$solicitud[0]['porc_retefuente'],
                            'neto_abonar_cta_bancaria'=>$neto_a_abonar_a_la_cuenta_bancaria,
                            'neto_aplicar_sic'=>$neto_a_aplicar_en_sicapital,
                            'saldo_antes_pago'=>$solicitud[0]['saldo_antes_pago'],
                            'fecha_inicio_per'=>$solicitud[0]['fecha_inicio_per'],
                            'fecha_final_per'=>$solicitud[0]['fecha_final_per'],
                            'num_dias_pagados'=>$solicitud[0]['num_dias_pagados'],
                            'regimen_comun'=>$solicitud[0]['regimen_comun'],
                            'valor_liq_antes_iva'=>$solicitud[0]['valor_liq_antes_iva'],
                            'valor_iva'=>$solicitud[0]['valor_iva'],
                            'valor_total'=>$total,
                            'base_retefuente_renta'=>$solicitud[0]['base_retefuente_renta'],
                            'valor_retefuente_renta'=>$solicitud[0]['valor_retefuente_renta'],
                            'valor_reteiva'=>$solicitud[0]['valor_reteiva'],
                            'base_ica_estampillas'=>$solicitud[0]['base_ica_estampillas'],
                            'valor_ica'=>$solicitud[0]['valor_ica'],
                            'estampilla_ud'=>$solicitud[0]['estampilla_ud'],  
                            'estampilla_procultura'=>$solicitud[0]['estampilla_procultura'],
                            'estampilla_proadultomayor'=>$solicitud[0]['estampilla_proadultomayor'],
                            'arp'=>$solicitud[0]['arp'],
                            'cooperativas_depositos'=>(isset($solicitud[0]['cooperativas_deposito'])?$solicitud[0]['cooperativas_deposito']:0),
                            'afc'=>$solicitud[0]['afc'],
                            'total_dctos_sin_retenciones'=>$total_descuento_sin_retenciones, 
                            'neto_pagar_sin_retenciones'=>$neto_a_pagar_sin_aplicar_retenciones, 
                            'saldo_contrato_al_corte'=>0,
                            'salud'=>$solicitud[0]['salud'],
                            'pension'=>$solicitud[0]['pension'],
                            'pensionado'=>$solicitud[0]['pensionado'],
                            'pago_saldo_menores'=>$solicitud[0]['pago_saldo_menores'],
                            'pasante_monitoria'=>$solicitud[0]['pasante_monitoria'],
                            'num_solicitud_pago'=>$solicitud[0]['num_solicitud_pago']);
            $aprobado=$this->insertarDetalleNomina($datos);
            return $aprobado;
    }
  
    /**
     *
     * @param <array> $datos_detalle (id_detalle, id_nomina, id_cumplido, vigencia, porc_retefuente, neto_abonar_cta_bancaria, 
     *                  neto_aplicar_sic, saldo_antes_pago, fecha_inicio_per, fecha_final_per, num_dias_pagados, regimen_comun,
     *                  valor_liq_antes_iva, valor_iva, valor_total, base_retefuente_renta, valor_retefuente_renta, valor_reteiva, 
     *                  base_ica_estampillas, valor_ica, estampilla_ud, estampilla_procultura, estampilla_proadultomayor, arp, 
     *                  cooperativas_depositos, afc, total_dctos_sin_retenciones, neto_pagar_sin_retenciones, 
     *                  saldo_contrato_al_corte,salud, pension, pensionado, pago_saldo_menores, pasante_monitoria, num_solicitud_pago)
     * @return type 
     */
    function insertarDetalleNomina($datos_detalle){
            
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"insertar_detalle_nomina",$datos_detalle);
             echo "cadena ".$cadena_sql;//exit;
            $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "");
            return $this->totalAfectados($this->configuracion, $this->acceso_nomina);
    }
   
    function periodosPago(){
            $anio_inicial=2009;
            $anio_final=date('Y');
            $mes_inicial='01';
            $mes_final=date('m');
            $fecha_inicial=$anio_inicial.$mes_inicial;
            $fecha_final=$anio_final.$mes_final;
            $indice=0;
            for($i=$anio_inicial;$i<=$anio_final;$i++){
                    for($mes=1;$mes<=12;$mes++){

                        if($mes<10)
                            $mes="0".$mes;
                        $fecha=$i.$mes;
                        if($fecha>=$fecha_inicial && $fecha<=$fecha_final){
                            $periodo[$indice][0]=$i.$mes;
                            $periodo[$indice][1]=$i."- ".$this->nombreMes($mes);
                            $indice++;
                        }
                    }
            }
            $periodo = $this->ordenarMeses($periodo);
            return $periodo;         
    }
    
    
    /**
     * Funcion que retorna el nombre de un mes de acuerdo a un número de mes
     * @param String $numero_mes
     * @return string 
     */
    function nombreMes($numero_mes){
        switch ($numero_mes) {
            case '01':
                $mes="ENERO";
                break;

            case '02':
                $mes="FEBRERO";
                break;

            case '03':
                $mes="MARZO";
                break;

            case '04':
                $mes="ABRIL";
                break;

            case '05':
                $mes="MAYO";
                break;

            case '06':
                $mes="JUNIO";
                break;

            case '07':
                $mes="JULIO";
                break;

            case '08':
                $mes="AGOSTO";
                break;

            case '09':
                $mes="SEPTIEMBRE";
                break;

            case '10':
                $mes="OCTUBRE";
                break;

            case '11':
                $mes="NOVIEMBRE";
                break;

            case '12':
                $mes="DICIEMBRE";
                break;

            default:
                 $mes="";
                break;
        }
            return $mes;
        
    }
    
    /**
     * Funcion que ordena descendentemente un arreglo de meses
     * @param <array> $meses
     * @return <array> 
     */
    function ordenarMeses($meses){
            foreach ($meses as $key => $fila) {
                    $ids[$key]  = $fila[0]; // columna de identificador
                    $nombres[$key] = $fila[1]; //columna de nombre
                }
            //ordenamos descendente por la columna elegida
            array_multisort($ids, SORT_DESC, $meses);
            return $meses;
    }
    
       function eliminarTmpDetalleNomina($id_detalle){
           
            $cadena_sql = $this->sql->cadena_sql($this->configuracion,$this->acceso_nomina,"eliminar_tmp_detalle_nomina",$id_detalle);
             echo "cadena ".$cadena_sql;//exit;
            $this->ejecutarSQL($this->configuracion, $this->acceso_nomina, $cadena_sql, "");
            return $this->totalAfectados($this->configuracion, $this->acceso_nomina);
    }
    
    
} // fin de la clase
	

?>


                
                