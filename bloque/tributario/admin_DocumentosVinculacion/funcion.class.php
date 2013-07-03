<?php
/* --------------------------------------------------------------------------------------------------------------------------
  @ Derechos de Autor: Vea el archivo LICENCIA.txt que viene con la distribucion
  --------------------------------------------------------------------------------------------------------------------------- */

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}


include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/funcionGeneral.class.php");

class funciones_adminVinculacion extends funcionGeneral {

    //Crea un objeto tema y un objeto SQL.
    private $pagina;
    private $opcion;
    private $configuracion;
    private $path;

    function __construct($configuracion, $sql) {
        //[ TO DO ]En futuras implementaciones cada usuario debe tener un estilo
        //include ($configuracion["raiz_documento"].$configuracion["estilo"]."/".$this->estilo."/tema.php");
        //include ($configuracion["raiz_documento"].$configuracion["estilo"]."/basico/tema.php");
        include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/encriptar.class.php");
        include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/html.class.php");
        include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/log.class.php");



        $indice = $this->configuracion["host"] . $this->configuracion["site"] . "/index.php?";
        $this->indice = $configuracion["host"] . $configuracion["site"] . "/index.php?";
        $this->html = new html();
        $this->cripto = new encriptar();
        //$this->tema=$tema;
        $this->sql = $sql;

        //Conexion General
        $this->acceso_db = $this->conectarDB($configuracion, "");
        //Conexion SICAPITAL
        $this->accesoSICAPITAL = $this->conectarDB($configuracion, "oracleSIC");
        //Conexion Oracle
        $this->accesoOracle = $this->conectarDB($configuracion, "cuotasP");
        //Conexion postgres
        $this->acceso_pg = $this->conectarDB($configuracion, "tributario");
        //Conexion Oracle
        $this->accesoOracle = $this->conectarDB($configuracion, "cuotasP");


//Datos de sesion
        $this->formulario = "registro_adicionarTablaHomologacion";
        $this->usuario = $this->rescatarValorSesion($configuracion, $this->acceso_db, "id_usuario");
        $this->identificacion = $this->rescatarValorSesion($configuracion, $this->acceso_db, "identificacion");
        $this->nivel = $this->rescatarValorSesion($configuracion, $this->acceso_db, "nivelUsuario");
        $this->pagina = "adminDocumentosVinculacion";
        $this->opcion = "mostrar";

        $this->configuracion = $configuracion;
        $this->log_us = new log();
    }

    /**
     * Funcion que da la bienvenida la usuario
     * @param <array> $this->verificar
     * @param <array> $this->formulario
     * @param <array> $_REQUEST (pagina,opcion,cod_proyecto)
     * Utiliza los metodos insertarDatos, mostrarInicio, historialVinculacion
     */
    function insertarDatos($resp_encuesta) {

        //var_dump($resp_encuesta);


        if (isset($resp_encuesta['func_documento']) && $resp_encuesta['func_documento'] == $this->identificacion) {

            //echo 'comprobacion datos exactos';

            $id_num = $resp_encuesta['func_documento'];
            $id_tipo = $resp_encuesta['tipo_documento'];
            $vigencia = $resp_encuesta['annio'];
            $contrato = $resp_encuesta['contrato'];
            $fec_registro = $resp_encuesta['fecha_registro'];
            $id_enc = $resp_encuesta['id_encuesta'];


            $parametros = array(
                'id_enc' => $id_enc,
                'id_num' => $id_num,
                'id_tipo' => $id_tipo,
                'vigencia' => $vigencia,
                'contrato' => $contrato,
                'fecha_reg' => $fec_registro);

            // var_dump($parametros);

            $cont = 1;

            foreach ($resp_encuesta as $key => $values) {
                if ($key == 'id_pregunta' . $cont && ($resp_encuesta['respuesta_' . $cont] != 'SI' && $resp_encuesta['respuesta_' . $cont] != 'NO')) {
                    echo "<script type=\"text/javascript\">" .
                    "alert('Formulario NO diligenciado correctamente');" .
                    "</script> ";
                    unset($resp_encuesta);
                    $pagina = $this->configuracion["host"] . $this->configuracion["site"] . "/index.php?";
                    $variable = 'pagina=encuestaTributario';
                    $variable.='&opcion=';
                    $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                    echo "<script>location.replace('" . $pagina . $variable . "')</script>";
                    exit;
                } elseif ($key == 'id_pregunta' . $cont) {
                    $cont++;
                }
            }

            $cont = 1;
            foreach ($resp_encuesta as $key => $values) {

                if ($key == 'id_pregunta' . $cont) {

                    $parametros['id_preg'] = $resp_encuesta['id_pregunta' . $cont];
                    $parametros['resp'] = $resp_encuesta['respuesta_' . $cont];

                    $cadena_sql = $this->sql->cadena_sql("insertar_respuestas", $parametros);
                    //echo '<br>' . $cadena_sql;
                    $insertar = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql, "busqueda");

                    //clase log para registrar los cambios en la BDD
                    //VARIABLES PARA EL LOG
                    $registro[0] = "GUARDAR"; //
                    $registro[1] = $parametros['id_num'] . '|' . $parametros['id_enc'] . '|' . $parametros['id_preg']; //
                    $registro[2] = "TRIBUTARIO"; //
                    $registro[3] = $parametros['id_enc'] . '|' . $parametros['id_preg'] . '|' . $parametros['resp']; //
                    $registro[4] = time(); //
                    $registro[5] = "Registra datos insertados a la base de datos para el usuario con  "; //
                    $registro[5] .= " identificacion =" . $parametros['id_num'];
                    $this->log_us->log_usuario($registro, $this->configuracion);

                    $cont++;
                }
            }


            //AÑADIR UNA ALERTA DE ÉXITO O FRACASO EN LA INSERSIÓN DE LOS DATOS

            /* if ($insertar) {

              echo "<script type=\"text/javascript\">" .
              "alert('Datos ingresados con éxito');" .
              "</script>";
              } else {
              echo "<script type=\"text/javascript\">" .
              "alert('No fue posible realizar el registro');" .
              "</script>";
              }
             */

            $variable = 'pagina=asistenteTributario';
            $variable.='&opcion=';
            $variable = $this->cripto->codificar_url($variable, $this->configuracion);
            ?>
            <script language="javascript">    window.location.href = "<? echo $this->indice . $variable; ?>"</script>
            <?
        } else {

            //echo 'comprobacion diferentes datos';

            $pagina = $this->configuracion["host"] . $this->configuracion["site"] . "/index.php?";
            $variable = "pagina=asistenteTributario";
            $variable .= "&opcion=";
            $variable = $this->cripto->codificar_url($variable, $this->configuracion);
            echo "<script>location.replace('" . $pagina . $variable . "')</script>";
        }
    }

    function mostrarInicio() {
        if (date('m') <= '07') {
            $per = '1';
        } else {
            $per = '3';
        }

        $funcionario = array('identificacion' => $this->identificacion,
            'anio' => date('Y'),
            'periodo' => $per);


        $cadena_sql = $this->sql->cadena_sql("datosUsuarioSDH", $funcionario);
        //echo $cadena_sql;
        //exit;
        $cadena_sql2 = $this->sql->cadena_sql("datosUsuario", $funcionario);
        $cadena_sql3 = $this->sql->cadena_sql("datos_contrato", $funcionario);

        $cadena_sql9 = $this->sql->cadena_sql("consultar_telefono_SHD", $funcionario);
        $cadena_sql8 = $this->sql->cadena_sql("consultar_direccion_SHD", $funcionario);


        $datosU = $this->ejecutarSQL($this->configuracion, $this->accesoSICAPITAL, $cadena_sql, "busqueda");
        $datosSDH = $this->ejecutarSQL($this->configuracion, $this->accesoOracle, $cadena_sql2, "busqueda");


        $datos_dir = $this->ejecutarSQL($this->configuracion, $this->accesoSICAPITAL, $cadena_sql8, "busqueda");
        $datos_tel = $this->ejecutarSQL($this->configuracion, $this->accesoSICAPITAL, $cadena_sql9, "busqueda");



        if ($datosSDH == "") {
            $datosusuario = $datosU;
        } else {
            $datosusuario = $datosSDH;
        }

        //var_dump($datosusuario);
        //exit;
        //buscavinculaciones activas
        $cadena_sql = $this->sql->cadena_sql("vinculaciones", $funcionario);
        $datosVinculacion = $this->ejecutarSQL($this->configuracion, $this->accesoOracle, $cadena_sql, "busqueda");

        //var_dump($datosVinculacion);

        $datosContrato = $this->ejecutarSQL($this->configuracion, $this->accesoSICAPITAL, $cadena_sql3, "busqueda");

        // var_dump($datosContrato);
        ?>
        <script src="<? echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["javascript"] ?>/jquery.js" type="text/javascript" language="javascript"></script>

        <table class="bordered" width="100%" border="0" align="center" cellpadding="4 px" cellspacing="1px" >



            <th class='titulo_th' colspan ="5" >FUNCIONARIO </th>

            <tbody>
                <tr>
                    <td align="center"  class='cuadro_plano '>
                        <table class="bordered"  width="100%">
                            <tr>
                                <td class='texto_elegante estilo_td2' width='20%' height="30">
                                    Tipo de documento:
                                </td>
                                <td class='texto_elegante estilo_td2' width='20%' align="left">
                                    <?
                                    if ($datosusuario[0]['PLA_TIPO_IDEN'] = 1)
                                        echo 'CC';
                                    ?>
                                </td>
                                <td class='texto_elegante estilo_td2' width='20%'>
                                    Identificaci&oacute;n:
                                </td>
                                <td class='texto_elegante estilo_td2' width='20%' align="left">
                                    <? echo $datosusuario[0]['PLA_NRO_IDEN']; ?>
                                </td>

                            </tr>

                            <tr>
                                <td class='texto_elegante estilo_td2' width='15%' height="30">
                                    Nombre:
                                </td>
                                <td class='texto_elegante estilo_td2' width='15%' align="left">
                                    <? echo $datosusuario[0]['PLA_NOMBRE1'] . ' ' . $datosusuario[0]['PLA_NOMBRE2']; ?>
                                </td>
                                <td class='texto_elegante estilo_td2'  width=15%' height="30">
                                    Apellido:
                                </td>
                                <td class='texto_elegante estilo_td2' width='15%' align="left">
                                    <? echo $datosusuario[0]['PLA_APELLIDO1'] . ' ' . $datosusuario[0]['PLA_APELLIDO2']; ?>
                                </td>

                            </tr>
                            <tr>
                                <td class='texto_elegante estilo_td2' width='15%' height="30">
                                    Email:
                                </td>
                                <td class='texto_elegante estilo_td2' width='15%' align="left">
                                    <? echo $datosusuario[0]['PLA_EMAIL'] . '<br><br>'; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class='texto_elegante estilo_td2' width='15%' height="30">
                                    Dirección:
                                </td>
                                <td class='texto_elegante estilo_td2' width='15%' align="left">
                                    <?
                                    if ($datosusuario[0]['PLA_DIRECC'] == "") {
                                        echo $datos_dir[0]['DATO_B_V_DIR'] . '<br><br>';
                                    } else {

                                        echo $datosusuario[0]['PLA_DIRECC'] . '<br><br>';
                                    }
                                    ?>
                                </td>
                                <td class='texto_elegante estilo_td2' width='15%' height="30">
                                    Teléfono:
                                </td>
                                <td class='texto_elegante estilo_td2' width='15%' align="left">
                                    <?
                                    if ($datosusuario[0]['PLA_TELE'] == "") {
                                        echo $datos_tel[0]['DATO_B_V_TEL'] . '<br><br>';
                                    } else {

                                        echo $datosusuario[0]['PLA_TELE'] . '<br><br>';
                                    }
                                    ?>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </tbody>

        </tr>
        </table>
        <div id="div_mensaje1" align="center" class="ab_name">
        </div>
        <?
    }

    function historialVinculacion() {

        $funcionario = array('identificacion' => $this->identificacion);

        $cadena_sql = $this->sql->cadena_sql("datosUsuarioSDH", $funcionario);
        $cadena_sql2 = $this->sql->cadena_sql("datosUsuario", $funcionario);
        $cadena_sql3 = $this->sql->cadena_sql("datos_contrato", $funcionario);

        $datosU = $this->ejecutarSQL($this->configuracion, $this->accesoSICAPITAL, $cadena_sql, "busqueda");
        $datosSDH = $this->ejecutarSQL($this->configuracion, $this->accesoOracle, $cadena_sql2, "busqueda");

        $cadena_sql4 = $this->sql->cadena_sql("consultar_respuestas", $funcionario);
        $datos_consulta = $this->ejecutarSQL($this->configuracion, $this->acceso_pg, $cadena_sql4, "busqueda");

        //var_dump($datos_consulta);
        //var_dump($datosSDH);
        //var_dump($datosU);

        if ($datosSDH == "") {
            $datosusuario = $datosU;
        } else {
            $datosusuario = $datosSDH;
        }

        //var_dump($datosusuario);
        //exit;
        //buscavinculaciones activas
        $cadena_sql = $this->sql->cadena_sql("vinculaciones", $funcionario);
        $datosVinculacion = $this->ejecutarSQL($this->configuracion, $this->accesoOracle, $cadena_sql, "busqueda");
        $datosContrato = $this->ejecutarSQL($this->configuracion, $this->accesoSICAPITAL, $cadena_sql3, "busqueda");



        //var_dump($datosContrato);
        //var_dump($datosVinculacion);
        //exit;
        ?>
        <table class="bordered" width="100%" >

            <th class='espacios_proyecto' colspan ="5"><? echo "<br>HISTORIAL DE VINCULACIONES - " . $datosusuario[0]['PLA_APELLIDO1'] . ' ' . $datosusuario[0]['PLA_APELLIDO2'] . ' ' . $datosusuario[0]['PLA_NOMBRE1'] . ' ' . $datosusuario[0]['PLA_NOMBRE2'] . '<br>    <br>'; ?></th>
            <tr>    <th class = 'subtitulo_th centrar' > Periodo </th>
                <th class = 'subtitulo_th centrar' > Tipo Vinculación</th>
                <th class = 'subtitulo_th centrar' > Estado</th>
                <th class = 'subtitulo_th centrar' > Resoluci&oacute;n/Contrato</th>
                <th class = 'subtitulo_th centrar' > Registrar Información Tributaria</th>
            </tr>
            <?
            //Impresión de vinculaciones como Funcionario de Planta

            if ($datosusuario[0]['PLA_ESTADO'] != " ") {
                ?>

                <tr >
                    <td width="10%" class='texto_elegante estilo_td' style="text-align:center;">
                        <? echo $anio = date('Y'); ?>
                    </td>

                    <td width="20%" class='texto_elegante estilo_td'>
                        <? echo $datosusuario[0]['VINCULACION']; ?>
                    </td>

                    <td width="15%" class='texto_elegante estilo_td' style="text-align:center;">
                        <?
                        echo $datosusuario[0]['PLA_ESTADO'];
                        ?>
                    </td>

                    <td width="20%" class='texto_elegante estilo_td'  style="text-align:center;">
                        <? echo $datosusuario[0]['PLA_RES']; ?>
                    </td>

                    <td width="20%" class='texto_elegante estilo_td' style="text-align:center;">
                        <?
                        if ($anio == date('Y')) {



                            if ($datos_consulta[0]['resp_annio'] == $anio) {
                                ?>   
                                <a href="
                                <?
                                $variable = 'pagina=encuestaTributario';
                                $variable.='&opcion=consultar';

                                $variable.='&vigencia=' . $anio;
                                $variable.='&vinculacion=' . $datosusuario[0]['VINCULACION'];
                                $variable.='&estado=' . $datosusuario[0]['PLA_ESTADO'];
                                $variable.='&contrato=' . $datosusuario[0]['PLA_RES'];

                                $variable.='&nombre=' . $datosusuario[0]['PLA_NOMBRE1'];
                                $variable.='&nombre2=' . $datosusuario[0]['PLA_NOMBRE2'];
                                $variable.='&apellido=' . $datosusuario[0]['PLA_APELLIDO1'];
                                $variable.='&ap2=' . $datosusuario[0]['PLA_APELLIDO2'];
                                $variable.='&identificacion=' . $datosusuario[0]['PLA_NRO_IDEN'];
                                $variable.='&id_tipo=' . $datosusuario[0]['PLA_TIPO_IDEN'];

                                $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                                echo $this->indice . $variable;
                                ?>" >
                                    <img alt="Ir a Formulario" src="<? echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/tributario/magi_form.jpg" /></a> 
                            <? } else {
                                ?>   
                                <a href="
                                <?
                                $variable = 'pagina=encuestaTributario';
                                $variable.='&opcion=';

                                $variable.='&vigencia=' . $anio;
                                $variable.='&vinculacion=' . $datosusuario[0]['VINCULACION'];
                                $variable.='&estado=' . $datosusuario[0]['PLA_ESTADO'];
                                $variable.='&contrato=' . $datosusuario[0]['PLA_RES'];

                                $variable.='&nombre=' . $datosusuario[0]['PLA_NOMBRE1'];
                                $variable.='&nombre2=' . $datosusuario[0]['PLA_NOMBRE2'];
                                $variable.='&apellido=' . $datosusuario[0]['PLA_APELLIDO1'];
                                $variable.='&ap2=' . $datosusuario[0]['PLA_APELLIDO2'];
                                $variable.='&identificacion=' . $datosusuario[0]['PLA_NRO_IDEN'];
                                $variable.='&id_tipo=' . $datosusuario[0]['PLA_TIPO_IDEN'];

                                $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                                echo $this->indice . $variable;
                                ?>" >
                                    <img alt="Ir a Formulario" src="<? echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/tributario/icon_form_1.jpg" /></a> 
                                <?
                            }
                            ?> 
                        </td>

                    </tr>

                    <?
                }
            }

            //Impresión de vinculaciones como Contratista
            if (is_array($datosContrato)) {
                foreach ($datosContrato as $key => $value) {
                    ?> <tr >
                        <td width="10%" class='texto_elegante estilo_td' style="text-align:center;">
                            <? echo $datosContrato[$key]['VIGENCIA'];
                            ?>
                        </td>

                        <td width="20%" class='texto_elegante estilo_td'>
                            <? echo $datosContrato[$key]['TIPO_CONTRATO']; ?>
                        </td>

                        <td width="15%" class='texto_elegante estilo_td'>
                            <?
                            echo '';
                            ?>
                        </td>

                        <td width="20%" class='texto_elegante estilo_td' style="text-align:center;">
                            <? echo $datosContrato[$key]['NUM_CONTRATO'] ?>
                        </td>

                        <td width="20%" height="26" class='texto_elegante estilo_td' style="text-align:center;">
                            <?
                            if ($datosContrato[$key]['VIGENCIA'] == date('Y')) {
                                if ($datos_consulta[$key]['resp_annio'] == $datosContrato[$key]['VIGENCIA']) {
                                    ?>
                                    <a href="
                                    <?
                                    $variable = 'pagina=encuestaTributario';
                                    $variable.='&opcion=consultar';

                                    $variable.='&vigencia=' . $datosContrato[$key]['VIGENCIA'];
                                    $variable.='&vinculacion=' . $datosContrato[$key]['TIPO_CONTRATO'];
                                    //$variable.='$estadoC=' .
                                    $variable.='&contrato=' . $datosContrato[$key]['NUM_CONTRATO'];

                                    $variable.='&nombre=' . $datosusuario[0]['PLA_NOMBRE1'];
                                    $variable.='&nombre2=' . $datosusuario[0]['PLA_NOMBRE2'];
                                    $variable.='&apellido=' . $datosusuario[0]['PLA_APELLIDO1'];
                                    $variable.='&ap2=' . $datosusuario[0]['PLA_APELLIDO2'];
                                    $variable.='&identificacion=' . $datosusuario[0]['PLA_NRO_IDEN'];
                                    $variable.='&id_tipo=' . $datosusuario[0]['PLA_TIPO_IDEN'];
                                    $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                                    echo $this->indice . $variable;
                                    ?>"> 
                                        <img alt="Ir a Formulario" src="<? echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/tributario/magi_form.jpg" /></a> 
                                    <?
                                } else {
                                    ?>
                                    <a href="
                                    <?
                                    $variable = 'pagina=encuestaTributario';
                                    $variable.='&opcion=';

                                    $variable.='&vigencia=' . $datosContrato[$key]['VIGENCIA'];
                                    $variable.='&vinculacion=' . $datosContrato[$key]['TIPO_CONTRATO'];
                                    //$variable.='$estadoC=' .
                                    $variable.='&contrato=' . $datosContrato[$key]['NUM_CONTRATO'];

                                    $variable.='&nombre=' . $datosusuario[0]['PLA_NOMBRE1'];
                                    $variable.='&nombre2=' . $datosusuario[0]['PLA_NOMBRE2'];
                                    $variable.='&apellido=' . $datosusuario[0]['PLA_APELLIDO1'];
                                    $variable.='&ap2=' . $datosusuario[0]['PLA_APELLIDO2'];
                                    $variable.='&identificacion=' . $datosusuario[0]['PLA_NRO_IDEN'];
                                    $variable.='&id_tipo=' . $datosusuario[0]['PLA_TIPO_IDEN'];
                                    $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                                    echo $this->indice . $variable;
                                    ?>"> 
                                        <img alt="Ir a Formulario" src="<? echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/tributario/icon_form_1.jpg" /></a> 
                                    <?
                                }
                                ?> 
                            </td>

                        </tr>

                        <?
                    }
                }
            }

            //Impresión de vinculaciones como Docente
            if (is_array($datosVinculacion)) {

                foreach ($datosVinculacion as $key => $value) {
                    ?> <tr >
                        <td width="10%" class='texto_elegante estilo_td' style="text-align:center;">
                            <? echo $datosVinculacion[$key]['VIN_ANIO']; ?>
                        </td>

                        <td width="20%" class='texto_elegante estilo_td'>
                            <? echo $datosVinculacion[$key]['VIN_NOMBRE']; ?>
                        </td>

                        <td width="5%" class='texto_elegante estilo_td' style="text-align:center;">
                            <? echo $datosVinculacion[$key]['VIN_ESTADO']; ?>
                        </td>

                        <td width="15%" class='texto_elegante estilo_td'  style="text-align:center;">
                            <?
                            if ($datosVinculacion[$key]['VIN_COD'] == 1 || $datosVinculacion[$key]['VIN_COD'] == 8 || $datosVinculacion[$key]['VIN_COD'] == 6)
                                echo $datosusuario[0]['PLA_RES'];
                            ?>
                        </td>

                        <td width="20%" height="26" class='texto_elegante estilo_td' style="text-align:center;">
                            <?
                            if ($datosVinculacion[$key]['VIN_ANIO'] == date('Y')) {
                                if ($datos_consulta[0]['resp_annio'] == $datosVinculacion[$key]['VIN_ANIO']) {
                                    ?>   
                                    <a href="<?
                                    $variable = 'pagina=encuestaTributario';
                                    $variable.='&opcion=consultar';

                                    $variable.='&vigencia=' . $datosVinculacion[$key]['VIN_ANIO'];
                                    $variable.='&vinculacion=' . $datosVinculacion[$key]['VIN_NOMBRE'];
                                    $variable.='&estado=' . $datosVinculacion[$key]['VIN_ESTADO'];
                                    $variable.='&contrato=' . $datosusuario[0]['PLA_RES'];

                                    $variable.='&nombre=' . $datosusuario[0]['PLA_NOMBRE1'];
                                    $variable.='&nombre2=' . $datosusuario[0]['PLA_NOMBRE2'];
                                    $variable.='&apellido=' . $datosusuario[0]['PLA_APELLIDO1'];
                                    $variable.='&ap2=' . $datosusuario[0]['PLA_APELLIDO2'];
                                    $variable.='&identificacion=' . $datosusuario[0]['PLA_NRO_IDEN'];
                                    $variable.='&id_tipo=' . $datosusuario[0]['PLA_TIPO_IDEN'];

                                    $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                                    echo $this->indice . $variable;
                                    ?>" >    
                                        <img alt="Ir a Formulario" src="<? echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/tributario/magi_form.jpg" /></a> 
                                </td>

                            </tr>

                            <?
                        } else {
                            ?>   
                            <a href="<?
                            $variable = 'pagina=encuestaTributario';
                            $variable.='&opcion=';

                            $variable.='&vigencia=' . $datosVinculacion[$key]['VIN_ANIO'];
                            $variable.='&vinculacion=' . $datosVinculacion[$key]['VIN_NOMBRE'];
                            $variable.='&estado=' . $datosVinculacion[$key]['VIN_ESTADO'];
                            $variable.='&contrato=' . $datosusuario[0]['PLA_RES'];

                            $variable.='&nombre=' . $datosusuario[0]['PLA_NOMBRE1'];
                            $variable.='&nombre2=' . $datosusuario[0]['PLA_NOMBRE2'];
                            $variable.='&apellido=' . $datosusuario[0]['PLA_APELLIDO1'];
                            $variable.='&ap2=' . $datosusuario[0]['PLA_APELLIDO2'];
                            $variable.='&identificacion=' . $datosusuario[0]['PLA_NRO_IDEN'];
                            $variable.='&id_tipo=' . $datosusuario[0]['PLA_TIPO_IDEN'];

                            $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                            echo $this->indice . $variable;
                            ?>" >    
                                <img alt="Ir a Formulario" src="<? echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/tributario/icon_form_1.jpg" /></a> 
                        </td>

                        </tr>

                        <?
                    }
                }
            }
        }
        echo '<br>';
        ?>

        </table>
        <?
    }

    function noData($mensaje) {

        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/alerta.class.php");
        $cadena = ".::" . $mensaje . "::.";
        $cadena = htmlentities($cadena, ENT_COMPAT, "UTF-8");
        alerta::sin_registro($this->configuracion, $cadena);
    }

}
?>
