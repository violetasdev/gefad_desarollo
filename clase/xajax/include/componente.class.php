<?

function tipoEA($tipo)
{	//rescata el valor de la configuracion
	require_once("clase/config.class.php");
	setlocale(LC_MONETARY, 'en_US');
	
	$esta_configuracion=new config();
	$configuracion=$esta_configuracion->variable(); 
	//Buscar un registro que coincida con el valor
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
	// crea objeto y se conecta a la base de datos
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();	
	$html=new html();
	
	//rescata el valor del tipo de variable	
	$busqueda="SELECT id_tipo ";
	$busqueda.="FROM ";
	$busqueda.=$configuracion["prefijo"]."variable_tipo";
	$busqueda.=" WHERE ";
	$busqueda.="tipo_variable= ";
	$busqueda.="'".$tipo."'";
	$busqueda.=" AND ";
	$busqueda.="modulo='ESPACIO_ACADEMICO'";
	
	//echo $busqueda;
	$resultado=$acceso_db->ejecutarAcceso($busqueda,"busqueda");
	
	//se crea el formulario para enviarlo y mostrarlo por xajax
	$cadena_html="
	<form enctype='tipo:multipart/form-data,application/x-www-form-urlencoded,text/plain' method='POST' name='formulario' id='formulario'>
	<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
	<tr>
	<td>
	<table align='center' width='100%' cellpadding='7' cellspacing='1'>
		<tr class='texto_subtitulo'>
				<td colspan='3'>
				Agregar ".$tipo." de Espacio	
				<hr class='hr_subtitulo'>
			</tr>
		<tr class='bloquecentralcuerpo'>
			<td > Nombre </td>
			<td>
				<input type='text' name='valor' id='valor' size='40' maxlength='100'>
			</td>
	
		</tr>
		<tr class='bloquecentralcuerpo' >
			<td>	descripcion	</td>
			<td>
				<input type='text' name='descripcion' id='descripcion' size='40' maxlength='255'>
			</td>
		</tr>
		<tr align='center'>
			<td colspan='2' rowspan='1'>
				<input type='hidden' name='id_tipo' id='id_tipo' value='".$resultado[0][0]."'>
				<input type='hidden' name='tipo' id='tipo' value='".$tipo."'>
				<input type='button' name='aceptar' value='Aceptar' onclick=\"xajax_procesar_formulario(xajax.getFormValues('formulario'))\"><br>
			</td>
		</tr>
	</table>
	</td>
	</tr>
	</table>
	</form>
	";
	//se crea el objeto xajax para enviar la respuesta
	$respuesta = new xajaxResponse();
	//Se asignan los valores al objeto y se envia la respuesta	
	$respuesta->addAssign("divForm","innerHTML",$cadena_html);
	return $respuesta;
}

function procesar_formulario($form_entrada)
{
	//rescata el valor de la configuracion
	require_once("clase/config.class.php");
	setlocale(LC_MONETARY, 'en_US');
	
	$esta_configuracion=new config();
	$configuracion=$esta_configuracion->variable(); 
	//Buscar un registro que coincida con el valor
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/log.class.php");
	// crea objeto y se conecta a la base de datos
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();	
	$html=new html();
	
	//sentencia que agrega la nueva variable	
	$cadena_sql="INSERT INTO academico_variable "; 
	$cadena_sql.="( "; 
	$cadena_sql.="`id_tipo`, "; 
	$cadena_sql.="`id_variable`, "; 
	$cadena_sql.="`valor`, ";
	$cadena_sql.="`descripcion` "; 
	$cadena_sql.=") "; 
	$cadena_sql.="VALUES "; 
	$cadena_sql.="( "; 
	$cadena_sql.="'".$form_entrada["id_tipo"]."', "; 
	$cadena_sql.="NULL, "; 
	$cadena_sql.="'".$form_entrada["valor"]."', "; 
	$cadena_sql.="'".$form_entrada["descripcion"]."' "; 
	$cadena_sql.=")"; 
	$resultado=$acceso_db->ejecutarAcceso($cadena_sql,"busqueda");
	$recuperado=mysql_insert_id();

	
	//VARIABLES PARA EL LOG

	$log_us= new log();
	$registro[0]="CREAR";
	$registro[1]= $recuperado;
	$registro[2]=strtoupper($form_entrada["tipo"]);
	$registro[3]=$form_entrada["valor"];
	$registro[4]=time();
	$registro[5]="Se registra un ".$form_entrada["tipo"]." de espacio academico, con nombre ".$registro[3];
	$log_us->log_usuario($registro,$configuracion);

	$respuesta = new xajaxResponse();
	$respuesta->addAssign("divForm","innerHTML","");	

	//genera la nueva busqueda para los selectes
	$html=new html();
		
	$busqueda="SELECT AV.id_variable, AV.valor ";
	$busqueda.="FROM ";
	$busqueda.=$configuracion["prefijo"]."variable AS AV ";
	$busqueda.="INNER JOIN ";
	$busqueda.=$configuracion["prefijo"]."variable_tipo AS AVT ";
	$busqueda.="USING ( id_tipo ) ";
	$busqueda.="WHERE ";
	$busqueda.="AVT.tipo_variable= ";
	$busqueda.="'".$form_entrada["tipo"]."'";
	$busqueda.=" AND ";
	$busqueda.="AVT.modulo='ESPACIO_ACADEMICO'";
	$busqueda.="ORDER BY AV.valor";
		
	switch($form_entrada["tipo"])
		{case 'tipo':	
				$mi_cuadro=$html->cuadro_lista($busqueda,"id_tipo",$configuracion,$recuperado,1,FALSE,0,"tipo");
				$respuesta->addAssign("divTipo","innerHTML",$mi_cuadro);
			break;
	 	 case 'subtipo':	
				$mi_cuadro=$html->cuadro_lista($busqueda,"id_subtipo",$configuracion,$recuperado,1,FALSE,0,"subtipo");
				$respuesta->addAssign("divSubTipo","innerHTML",$mi_cuadro);
			break;
		 case 'modalidad':	
				$mi_cuadro=$html->cuadro_lista($busqueda,"id_modalidad",$configuracion,$recuperado,1,FALSE,0,"modalidad");
				$respuesta->addAssign("divModalidad","innerHTML",$mi_cuadro);
			break;
		 case 'subtipo':	
				$mi_cuadro=$html->cuadro_lista($busqueda,"id_naturaleza",$configuracion,$recuperado,1,FALSE,0,"naturaleza");
				$respuesta->addAssign("divNaturaleza","innerHTML",$mi_cuadro);
			break;	
		}
	//tenemos que devolver la instanciación del objeto xajaxResponse
	return $respuesta;
}

function busqueda($form_entrada)
{
	//rescata el valor de la configuracion
	require_once("clase/config.class.php");
	setlocale(LC_MONETARY, 'en_US');
	
	$esta_configuracion=new config();
	$configuracion=$esta_configuracion->variable(); 
	//Buscar un registro que coincida con el valor
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");

	// crea objeto y se conecta a la base de datos
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();	
	$html=new html();
	
	$respuesta = new xajaxResponse();

	//genera la nueva busqueda para los selectes
	$html=new html();
		
	$busqueda="SELECT id_variable, valor ";
	$busqueda.="FROM ";
	$busqueda.=$configuracion["prefijo"]."variable ";
	$busqueda.="WHERE ";
	$busqueda.="id_tipo=";
	$busqueda.="'".$form_entrada["caracteristica"]."'";
	$busqueda.="ORDER BY valor";


	$mi_cuadro=$html->cuadro_lista($busqueda,"id_variable",$configuracion,1,1,FALSE,0,"id_variable");
	$respuesta->addAssign("Variable","innerHTML",$mi_cuadro);
	
	//tenemos que devolver la instanciación del objeto xajaxResponse
	return $respuesta;
}


function Componente($modulo)
{	 
        
        //rescata el valor de la configuracion
	require_once("clase/config.class.php");
	setlocale(LC_MONETARY, 'en_US');
	
	$esta_configuracion=new config();
	$configuracion=$esta_configuracion->variable(); 
	//Buscar un registro que coincida con el valor
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
	// crea objeto y se conecta a la base de datos
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();	
	$html=new html();
	
	//rescata el valor del tipo de variable	
	/*$busqueda="SELECT id_tipo ";
	$busqueda.="FROM ";
	$busqueda.=$configuracion["prefijo"]."variable_tipo";
	$busqueda.=" WHERE ";
	$busqueda.="tipo_variable= ";
	$busqueda.="'".$tipo."'";
	$busqueda.=" AND ";
	$busqueda.="modulo='ESPACIO_ACADEMICO'";
	
	//echo $busqueda;
	$resultado=$acceso_db->ejecutarAcceso($busqueda,"busqueda");*/
	
	//se crea el formulario para enviarlo y mostrarlo por xajax
	$cadena_html="
	<form enctype='tipo:multipart/form-data,application/x-www-form-urlencoded,text/plain' method='POST' name='formulario' id='formulario'>
	<table class='bloquelateral' align='center' width='100%' cellpadding='0' cellspacing='0'>
	<tr>
	<td>
	<table align='center' width='100%' cellpadding='7' cellspacing='1'>
		<tr class='texto_subtitulo'>
				<td colspan='3'>
				Agregar tipo de Componente	
				<hr class='hr_subtitulo'>
			</tr>
		<tr class='bloquecentralcuerpo'>
			<td > Nombre </td>
			<td>
				<input type='text' name='nombre' id='valor' size='40' maxlength='100'>
			</td>
	
		</tr>
               
		<tr class='bloquecentralcuerpo' >
			<td>	Descripcion	</td>
			<td>
				<input type='text' name='descripcion' id='descripcion' size='40' maxlength='255'>
                                <input type='hidden' name='modulo' id='modulo' value='".$modulo."'>
			</td>
		</tr>
		<tr align='center'>
			<td colspan='2' rowspan='1'>
				<input type='button' name='aceptar' value='Aceptar' onclick=\"xajax_procesar_componente(xajax.getFormValues('formulario'))\"><br>
			</td>
		</tr>
	</table>
	</td>
	</tr>
	</table>
	</form>
	";
	//se crea el objeto xajax para enviar la respuesta
	$respuesta = new xajaxResponse();
	//Se asignan los valores al objeto y se envia la respuesta	
	$respuesta->addAssign("divComp","innerHTML",$cadena_html);
	return $respuesta;
}


function procesar_componente($form_entrada)
{

        //rescata el valor de la configuracion
	require_once("clase/config.class.php");
	setlocale(LC_MONETARY, 'en_US');
	
	$esta_configuracion=new config();
	$configuracion=$esta_configuracion->variable(); 
	//Buscar un registro que coincida con el valor
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/html.class.php");
	include_once($configuracion["raiz_documento"].$configuracion["clases"]."/log.class.php");
	// crea objeto y se conecta a la base de datos
	$acceso_db=new dbms($configuracion);
	$enlace=$acceso_db->conectar_db();	
	$html=new html();
	
	//sentencia que agrega la nueva variable	
	$cadena_sql="INSERT INTO academico_variable_tipo "; 
	$cadena_sql.="( "; 
        $cadena_sql.="`id_tipo`, "; 
	$cadena_sql.="`tipo_variable`, "; 
	$cadena_sql.="`modulo`, ";
	$cadena_sql.="`descripcion` "; 
	$cadena_sql.=") "; 
	$cadena_sql.="VALUES "; 
	$cadena_sql.="( NULL,"; 
	$cadena_sql.="'".$form_entrada["nombre"]."', "; 
        $cadena_sql.="'".$form_entrada["modulo"]."', ";
	$cadena_sql.="'".$form_entrada["descripcion"]."' "; 
      	$cadena_sql.=")"; 
       

	$resultado=$acceso_db->ejecutarAcceso($cadena_sql,"busqueda");
	$recuperado=mysql_insert_id();

	//VARIABLES PARA EL LOG

	$log_us= new log();
	$registro[0]="CREAR";
	$registro[1]= $recuperado;
	$registro[2]='TIPO_VARIABLE';
	$registro[3]=$form_entrada["nombre"];
	$registro[4]=time();
	$registro[5]="Se registra un TIPO_VARIABLE de" .$modulo.", con nombre ".$registro[3];
	$log_us->log_usuario($registro,$configuracion);

	$respuesta = new xajaxResponse();
	$respuesta->addAssign("divComp","innerHTML","");	

	//genera la nueva busqueda para los selectes
	$html=new html();
		
	$busqueda="SELECT id_tipo, tipo_variable  ";
	$busqueda.="FROM ";
	$busqueda.=$configuracion["prefijo"]."variable_tipo AS AV ";
	$busqueda.="ORDER BY AV.tipo_variable";

        $mi_cuadro=$html->cuadro_lista($busqueda,"id_tipo",$configuracion,$recuperado,1,FALSE,0,"");
	$respuesta->addAssign("divComponente","innerHTML",$mi_cuadro);
		
	return $respuesta;
}
?>