<?php
/*
  ############################################################################
  #    UNIVERSIDAD DISTRITAL Francisco Jose de Caldas                        #
  #    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
  ############################################################################
 */

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;

    include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/dbms.class.php");
    include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/sesion.class.php");
    include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/encriptar.class.php");
}

class html_liquidador {

    public $configuracion;
    public $cripto;
    public $indice;

    function __construct($configuracion) {
        $this->configuracion = $configuracion;
        include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/encriptar.class.php");
        include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/html.class.php");
        $indice = $this->configuracion["host"] . $this->configuracion["site"] . "/index.php?";
        $this->cripto = new encriptar();
        $this->indice = $configuracion["host"] . $configuracion["site"] . "/index.php?";
        $this->html = new html();
    }

    function formularioDatos() {
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/dbms.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/sesion.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/encriptar.class.php");
        $this->formulario = "liquidador";

//Datos traídos desde la tabla datos básicos
        ?>
        <script>
            function acceptNum(e) {
                key = e.keyCode || e.which;
                tecla = String.fromCharCode(key).toLowerCase();
                letras = "01234567890";
                especiales = [8, 39, 9];
                tecla_especial = false
                for (var i in especiales) {
                    if (key == especiales[i]) {
                        tecla_especial = true;
                        break;
                    }
                }

                if (letras.indexOf(tecla) == -1 && !tecla_especial) {
                    return false;
                }
            }
        </script>
        <link href = "<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/cuentaCobro/cuentaC.css" rel = "stylesheet" type = "text/css" />
        <form method='POST' action='index.php' name='<?php echo $this->formulario; ?>'>
            <h2>Ingrese la cédula a liquidar:</h2>
            <br>
            <input type="text" name="cedula" required='required' onKeyPress='return acceptNum(event)'>
            <br>  <br>
            <center> <input id="registrarBoton" type="submit" class="navbtn"  value="Enviar" ></center>
            <input type='hidden' name='pagina' value='liquidadorCP'>
            <input type='hidden' name='opcion' value='recuperar'>
            <br>
        </form>
        <?php
    }

    function formularioDatosReporte() {
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/dbms.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/sesion.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/encriptar.class.php");
        $this->formulario = "liquidador";

//Datos traídos desde la tabla datos básicos
        ?>
        <script>
            function acceptNum(e) {
                key = e.keyCode || e.which;
                tecla = String.fromCharCode(key).toLowerCase();
                letras = "01234567890";
                especiales = [8, 39, 9];
                tecla_especial = false
                for (var i in especiales) {
                    if (key == especiales[i]) {
                        tecla_especial = true;
                        break;
                    }
                }

                if (letras.indexOf(tecla) == -1 && !tecla_especial) {
                    return false;
                }
            }
        </script>
        <link href = "<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/cuentaCobro/cuentaC.css" rel = "stylesheet" type = "text/css" />
        <form method='POST' action='index.php' name='<?php echo $this->formulario; ?>'>
            <h2>Ingrese la cédula a generar reportes de liquidación:</h2>
            <br>
            <input type="text" name="cedula" required='required' onKeyPress='return acceptNum(event)'>
            <br>  <br>
            <center> <input id="registrarBoton" type="submit" class="navbtn"  value="Enviar" ></center>
            <input type='hidden' name='pagina' value='liquidadorCP'>
            <input type='hidden' name='opcion' value='recuperar_reporte'>
            <br>
        </form>
        <?php
    }

    function formularioEntidad($cedula_em, $datos_en) {
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/dbms.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/sesion.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/encriptar.class.php");

        $this->formulario = "liquidador";
        ?>
        <!referencias a estilos y plugins>
        <script type = "text/javascript" src = "<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["plugins"]; ?>/datepicker/js/datepicker.js"></script>
        <link href = "<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/cuentaCobro/cuentaC.css" rel = "stylesheet" type = "text/css" />
        <link href = "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel = "stylesheet" type = "text/css"/>
        <script type = "text/javascript" src = "http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

        <form id="form" method="post" action='index.php' name='<?php echo $this->formulario; ?>'>
            <h2>Seleccione la entidad a liquidar:</h2>
            <div class="formrow f1">
                <div class="formrow f1">
                    <div id="p1f4" class="field n1">
                        <div class="staticcontrol">
                            <div class="hrcenter px1"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="formrow f1">
                <div id="p1f7" class="field n1">
                    <div class="caption capleft alignleft">
                        <label class="fieldlabel" for="p1f7c"><span><span class="pspan arial" style="text-align:right;font-size:14px;"><span class="ispan" style="color:#9393FF" xml:space="preserve">Cédula Empleado</span></span></span></label>
                    </div>
                    <div class="control capleft">
                        <div>
                            <input type="text" id="p1f7c" readonly name="cedula" class="fieldcontent" value="<?php echo $cedula_em ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div id="p1f103" class="field n1">
                <div class="caption capleft alignleft">
                    <label class="fieldlabel" for="entidades"><span><span class="pspan arial" style="text-align:right;font-size:14px;"><span class="ispan" style="color:#9393FF" >Entidad a cobrar:</span></span></span></label>
                    <div class="null"></div>
                </div>
            </div>
            <div class="control capleft">
                <div class="dropdown">
                    <select name='prev_nit' required>
                        <?php
                        foreach ($datos_en as $key => $value) {
                            ?>
                            <option id='prev_nit' name='prev_nit' value ="<?php echo $datos_en[$key]['prev_nit']; ?>"><?php echo $datos_en[$key]['prev_nombre']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div>
                <div class="null"></div>
                <input id="generarBoton" type="submit" class="navbtn"  value="Procesar">
                <input type='hidden' name='pagina' value='liquidadorCP'>
                <input type='hidden' name='opcion' value='liquidarfechas'>
            </div>
        </form>
        <?php
    }

    function formularioEntidadReporte($cedula_em, $datos_en) {
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/dbms.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/sesion.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/encriptar.class.php");

        $this->formulario = "liquidador";
        ?>
        <!referencias a estilos y plugins>
        <script type = "text/javascript" src = "<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["plugins"]; ?>/datepicker/js/datepicker.js"></script>
        <link href = "<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/cuentaCobro/cuentaC.css" rel = "stylesheet" type = "text/css" />
        <link href = "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel = "stylesheet" type = "text/css"/>
        <script type = "text/javascript" src = "http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

        <form id="form" method="post" action='index.php' name='<?php echo $this->formulario; ?>'>
            <h2>Seleccione la entidad a generar reportes:</h2>
            <div class="formrow f1">
                <div class="formrow f1">
                    <div id="p1f4" class="field n1">
                        <div class="staticcontrol">
                            <div class="hrcenter px1"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="formrow f1">
                <div id="p1f7" class="field n1">
                    <div class="caption capleft alignleft">
                        <label class="fieldlabel" for="p1f7c"><span><span class="pspan arial" style="text-align:right;font-size:14px;"><span class="ispan" style="color:#9393FF" xml:space="preserve">Cédula Empleado</span></span></span></label>
                    </div>
                    <div class="control capleft">
                        <div>
                            <input type="text" id="p1f7c" readonly name="cedula" class="fieldcontent" value="<?php echo $cedula_em ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div id="p1f103" class="field n1">
                <div class="caption capleft alignleft">
                    <label class="fieldlabel" for="entidades"><span><span class="pspan arial" style="text-align:right;font-size:14px;"><span class="ispan" style="color:#9393FF" >Entidad a cobrar:</span></span></span></label>
                    <div class="null"></div>
                </div>
            </div>
            <div class="control capleft">
                <div class="dropdown">
                    <select name='prev_nit' required>
                        <?php
                        foreach ($datos_en as $key => $value) {
                            ?>
                            <option id='prev_nit' name='prev_nit' value ="<?php echo $datos_en[$key]['prev_nit']; ?>"><?php echo $datos_en[$key]['prev_nombre']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div>
                <div class="null"></div>
                <input id="generarBoton" type="submit" class="navbtn"  value="Procesar">
                <input type='hidden' name='pagina' value='liquidadorCP'>
                <input type='hidden' name='opcion' value='recuperar_formato'>
            </div>
        </form>
        <?php
    }

    function formularioPeriodo($parametros, $fecha_inicial) {
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/dbms.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/sesion.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/encriptar.class.php");

        $this->formulario = "liquidador";
        $annio = date('Y', (strtotime("" . str_replace('/', '-', $fecha_inicial))));
        ?>
        <!referencias a estilos y plugins>
        <script>
                $(document).ready(function () {
                    $("#liquidar_desde").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        yearRange: '<?php echo $annio ?>:c',
                        dateFormat: 'dd/mm/yy',
                        maxDate: "+1Y",
                        onSelect: function (dateValue) {
                            $("#liquidar_hasta").datepicker("option", "minDate", dateValue)
                        }
                    });
                    $("#liquidar_desde").datepicker('option', 'minDate', '<?php echo $fecha_inicial ?>');
                });

                $(document).ready(function () {
                    $("#liquidar_hasta").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        yearRange: '<?php echo $annio ?>:c',
                        dateFormat: 'dd/mm/yy',
                        maxDate: "+0D",
                    });
                });

        </script>
        <script>
            function  validarFecha() {
                var desde = (document.getElementById("liquidar_desde").value);
                var hasta = (document.getElementById("liquidar_hasta").value);
                var y1 = desde.substring(6);
                var m13 = desde.substring(3, 5);
                var m12 = m13 - 1;
                var m1 = '0' + m12;
                var d1 = desde.substring(0, 2);
                var y2 = hasta.substring(6);
                var m23 = hasta.substring(3, 5);
                var m22 = m23 - 1;
                var m2 = '0' + m22;
                var d2 = hasta.substring(0, 2);
                var cadena1 = new Date(y1, m1, d1);
                var cadena2 = new Date(y2, m2, d2);
                var cadena3 = new Date();

                if (cadena1.getTime() > cadena2.getTime()) {
                    document.getElementById("liquidar_desde").focus();
                    document.getElementById("liquidar_hasta").focus();
                    alert("Fecha Final no válida");
                    return false
                }

                if (cadena2.getTime() > cadena3.getTime()) {
                    document.getElementById("liquidar_desde").focus();
                    document.getElementById("liquidar_hasta").value = "";
                    document.getElementById("liquidar_hasta").focus();
                    alert("Fecha Final no válida");
                    return false
                }

                return true
            }
        </script>

        <script type = "text/javascript" src = "<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["plugins"]; ?>/datepicker/js/datepicker.js"></script>
        <link href = "<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/cuentaCobro/cuentaC.css" rel = "stylesheet" type = "text/css" />
        <link href = "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel = "stylesheet" type = "text/css"/>
        <script type = "text/javascript" src = "http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>


        <form id="form" method="post" action='index.php' name='<?php echo $this->formulario; ?>' onSubmit="return validarFecha();">
            <h2>Proporcione el periodo a liquidar:</h2>
            <div class="formrow f1">
                <div class="formrow f1">
                    <div id="p1f4" class="field n1">
                        <div class="staticcontrol">
                            <div class="hrcenter px1"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="formrow f1">
                <div id="p1f7" class="field n1">
                    <div class="caption capleft alignleft">
                        <label class="fieldlabel" for="p1f7c"><span><span class="pspan arial" style="text-align:right;font-size:14px;"><span class="ispan" style="color:#9393FF" xml:space="preserve">Cédula Empleado</span></span></span></label>
                    </div>
                    <div class="control capleft">
                        <div>
                            <input type="text" id="p1f7c" readonly name="cedula" class="fieldcontent" value="<?php echo $parametros['cedula'] ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="formrow f1">
                <div id="p1f7" class="field n1">
                    <div class="caption capleft alignleft">
                        <label class="fieldlabel" for="p1f7c"><span><span class="pspan arial" style="text-align:right;font-size:14px;"><span class="ispan" style="color:#9393FF" xml:space="preserve">Entidad a Cobrar</span></span></span></label>
                    </div>
                    <div class="control capleft">
                        <div>
                            <input type="text" id="p1f7c" readonly name="entidad" class="fieldcontent" value="<?php echo $parametros['entidad'] ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="formrow f1 f2">
                <div id="p1f12" class="field n1">
                    <div class="caption capleft alignleft">
                        <label class="fieldlabel" for="liquidar_desde"><span><span class="pspan arial" style="text-align:right;font-size:14px;"><span class="ispan" style="color:#9393FF" ><a STYLE="color: red" >* </a>Liquidar desde</span></span></span></label>
                    </div>
                    <div class="control capleft">
                        <div>
                            <input type="text" id="liquidar_desde" title="*Campo Obligatorio" onpaste="return false" name="liquidar_desde" value="<?php echo $fecha_inicial ?>" placeholder="dd/mm/aaaa" required='required' pattern="(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/](19|20)\d\d">
                        </div> 
                    </div> 
                </div>

                <div id="p1f12" class="field n1">
                    <div class="caption capleft alignleft">
                        <label class="fieldlabel" for="liquidar_hasta"><span><span class="pspan arial" style="text-align:right;font-size:14px;"><span class="ispan" style="color:#9393FF" ><a STYLE="color: red" >* </a>Liquidar hasta</span></span></span></label>
                    </div>
                    <div class="control capleft">
                        <div>
                            <input type="text" id="liquidar_hasta" title="*Campo Obligatorio" onpaste="return false" name="liquidar_hasta" placeholder="dd/mm/aaaa" required='required' pattern="(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/](19|20)\d\d" onchange="validarFecha()">
                        </div>
                    </div>
                </div> 
            </div>

            <div>
                <div class="null"></div>
                <input id="generarBoton" type="submit" class="navbtn"  value="Liquidar">
                <input type='hidden' name='pagina' value='liquidadorCP'>
                <input type='hidden' name='opcion' value='liquidar'>
            </div>
        </form>

        <?php
    }

    function liquidador($liquidacion, $datos_basicos, $totales_liquidacion) {

        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/dbms.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/sesion.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/encriptar.class.php");

        $this->formulario = "liquidador";

        $datos_basicos['nombre_emp'] = str_replace("'", "", $datos_basicos['nombre_emp']);
        ?>
        <link	href="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/liquidador/form_estilo.css"	rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["plugins"]; ?>/jPages-master/css/jPages.css">
        <script src="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["plugins"]; ?>/jPages-master/js/jPages.js"></script>
        <!-- permite la paginacion-->        

        <script>
                                $(function () {
                                    $("div.holder").jPages({
                                        containerID: "itemContainer",
                                        previous: "←",
                                        next: "→",
                                        perPage: 5,
                                        delay: 20
                                    });
                                });
        </script>
        <form method="post" action='index.php' name='<?php echo $this->formulario; ?>' >
            <h1>Liquidación Cuota Parte para la Entidad <?php echo $datos_basicos['entidad_nombre'] ?> </h1>

            <center>
                <table class='bordered'  width ="68%">
                    <thead>
                        <tr>
                            <th  class='encabezado_registro' width="15%" colspan="1" rowspan="2">
                                <img alt="Imagen" width="50%" src="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/Images/escudo1.png" />
                            </th>
                            <th  colspan="1" style="font-size:14px;" class='subtitulo_th centrar'>
                                <br>UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS
                                <br> NIT 899999230-7<br>
                                <br> Detalle Liquidación Preliminar<br><br>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="1" style="font-size:12px;" class='subtitulo_th2'>
                                <?php
                                $dias = array("Domingo, ", "Lunes, ", "Martes, ", "Miercoles, ", "Jueves, ", "Viernes, ", "Sábado, ");
                                $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                                echo "Bogotá D.C, " . $fecha_cc = $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " de " . date('Y');
                                ?>

                            </th>
                        </tr>
                    </thead>      

                    <tr>
                        <td class='texto_elegante estilo_td' >Entidad Concurrente:</td>
                        <td class='texto_elegante estilo_td ' colspan='1'><?php echo'&nbsp;&nbsp;' . $datos_basicos['entidad_nombre'] ?></td>
                    </tr>
                    <tr> 
                        <td class='texto_elegante estilo_td' >NIT:</td>
                        <td class='texto_elegante estilo_td' colspan='1'><?php echo '&nbsp;&nbsp;' . $datos_basicos['entidad'] ?></td>
                    </tr>
                    <tr> 
                        <td class='texto_elegante estilo_td' >Fecha Corte Cuenta:</td>
                        <td class='texto_elegante estilo_td' colspan="2"><?php echo '&nbsp;&nbsp;' . $datos_basicos['liquidar_hasta'] ?></td>
                    </tr>
                </table> </center>
            <br>
            <center>
                <table class='bordered'  width ="60%">
                    <tr>
                        <td class='texto_elegante estilo_td' >Nombre Pensionado:</td>
                        <td class='texto_elegante estilo_td ' colspan='1'><?php echo'&nbsp;&nbsp;' . $datos_basicos['nombre_emp'] ?></td>
                        <td class='texto_elegante estilo_td' >Documento Pensionado:</td>
                        <td class='texto_elegante estilo_td ' colspan='1'><?php echo'&nbsp;&nbsp;' . $datos_basicos['cedula'] ?></td>
                    </tr>
                    <!--tr>
                        <td class='texto_elegante estilo_td' >Nombre Sustituto:</td>
                        <td class='texto_elegante estilo_td ' colspan='1'><?php echo'&nbsp;&nbsp;' ?></td>
                        <td class='texto_elegante estilo_td' >Documento Sustituto:</td>
                        <td class='texto_elegante estilo_td ' colspan='1'><?php echo'&nbsp;&nbsp;' ?></td>
                    </tr-->
                </table>
            </center>
            <br>
            <center>
                <table class='bordered'  width ="68%" >
                    <tr>
                        <th colspan="8" class="subtitulo_th" style="font-size:12px;">DETALLE DE LA LIQUIDACIÓN</th>
                    </tr>
                    <tr>
                        <th class='subtitulo_th centrar'>FECHA PAGO</th>
                        <th class='subtitulo_th centrar'>MESADA</th>
                        <th class='subtitulo_th centrar'>VALOR<br>CUOTA</th>
                        <!--th class='subtitulo_th centrar'>AJUSTE PENSION</th-->
                        <th class='subtitulo_th centrar'>MESADA<br>ADICIONAL</th>
                        <th class='subtitulo_th centrar'>INCREMENTO<br>SALUD</th>
                        <th class='subtitulo_th centrar'>INTERÉS<br>L_68/1923</th>
                        <th class='subtitulo_th centrar'>INTERÉS<br>L_1066/2006</th>
                        <th class='subtitulo_th centrar'>TOTAL MES</th>
                    </tr>
                    <tbody id="itemContainer">
                        <?php
                        if (is_array($liquidacion)) {
                            foreach ($liquidacion as $key => $value) {

                                echo "<tr>";
                                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>" . date('d/m/Y', strtotime(str_replace('/', '-', $liquidacion[$key]['fecha']))) . "</td>";
                                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($liquidacion[$key]['mesada'], 2, ',', '.') . "</td>";
                                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($liquidacion[$key]['cuota_parte'], 2, ',', '.') . "</td>";
                                //echo "<td class='texto_elegante estilo_td' style='text-align:center;' >" . $liquidacion[$key]['ajuste_pension'] . "</td>";
                                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>" . number_format($liquidacion[$key]['mesada_adc'], 2, ',', '.') . "</td>";
                                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>" . number_format($liquidacion[$key]['incremento'], 2, ',', '.') . "</td>";
                                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($liquidacion[$key]['interes_a2006'], 2, ',', '.') . "</td>";
                                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($liquidacion[$key]['interes_d2006'], 2, ',', '.') . "</td>";
                                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($liquidacion[$key]['total'], 2, ',', '.') . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            //echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            echo "</tr>";
                        }
                        ?>
                </table>
                <center><div class="holder" style="-moz-user-select: none;"></div></center>
            </center>
            <br>
            <center>
                <table class='bordered'  width ="75%" >
                    <tr>
                        <th colspan="10" class="subtitulo_th" style="font-size:12px;">TOTALES LIQUIDACIÓN</th>
                    </tr>
                    <tr>
                        <th class='encabezado_registro' width="5%" rowspan="2">TOTAL</th>
                        <th class='subtitulo_th centrar'>MESADA</th>
                        <th class='subtitulo_th centrar'>VALOR<br>CUOTA</th>
                        <!--th class='subtitulo_th centrar'>AJUSTE PENSION</th-->
                        <th class='subtitulo_th centrar'>MESADA<br>ADICIONAL</th>
                        <th class='subtitulo_th centrar'>INCREMENTO<br>SALUD</th>
                        <th class='subtitulo_th centrar'>INTERES ANTES<br>07/2006</th>
                        <th class='subtitulo_th centrar'>INTERES DESPUÉS<br>07/2006</th>
                        <th class='subtitulo_th centrar'>INTERESES<br>CONSOLIDADO</th>
                        <th class='subtitulo_th centrar'>TOTAL<br>LIQUIDADO</th>
                    </tr>
                    <?php
                    if (is_array($totales_liquidacion)) {

                        echo "<tr>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion['mesada'], 2, ',', '.') . "</td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion['cuota_parte'], 2, ',', '.') . "</td>";
                        //echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion['ajuste_pension']) . "</td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion['mesada_adc'], 2, ',', '.') . "</td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion['incremento']) . "</td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion['interes_a2006'], 2, ',', '.') . "</td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion['interes_d2006'], 2, ',', '.') . "</td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion['interes'], 2, ',', '.') . "</td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion['total'], 2, ',', '.') . "</td>";
                        echo "</tr>";
                    } else {
                        echo "<tr>";
                        //echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </center>

            <br><br>
            <div>
                <div class="null"></div>
                <input id="generarBoton" type="submit" class="navbtn" name="reportes_formato" value="Generar Reportes">
                <input type='hidden' name='pagina' value='liquidadorCP'>
                <input type='hidden' name='opcion' value='formatos'>
                <input type="hidden" name='datos_basicos' value='<?php echo serialize($datos_basicos) ?>'>
                <input type="hidden" name='totales_liquidacion' value='<?php echo serialize($totales_liquidacion) ?>'>

                <input id="generarBoton" type="submit" class="navbtn" name="reportes_formato" value="Cancelar">
                <input type='hidden' name='pagina' value='liquidadorCP'>
                <input type='hidden' name='opcion' value='formatos'>
                <input type="hidden" name='datos_basicos' value='<?php echo serialize($datos_basicos) ?>'>
                <input type="hidden" name='totales_liquidacion' value='<?php echo serialize($totales_liquidacion) ?>'>
            </div>
        </form>

        <?php
    }

    function generarReportes($datos_basicos, $totales_liquidacion, $sustitutos) {

        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/dbms.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/sesion.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/encriptar.class.php");

        $this->formulario = "liquidador";
        ?>
        <link	href="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/liquidador/form_estilo.css"	rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["plugins"]; ?>/jPages-master/css/jPages.css">
        <script src="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["plugins"]; ?>/jPages-master/js/jPages.js"></script>
        <!-- permite la paginacion-->        

        <script>
                                $(function () {
                                    $("div.holder").jPages({
                                        containerID: "itemContainer",
                                        previous: "←",
                                        next: "→",
                                        perPage: 5,
                                        delay: 20
                                    });
                                });
        </script>


        <form method="post" action='index.php' name='<?php echo $this->formulario; ?>' >
            <h1>Reportes Cuota Parte para la Entidad <?php echo $datos_basicos['entidad_nombre'] ?> </h1>

            <center>
                <table class='bordered'  width ="90%">
                    <thead>
                        <tr>
                            <th  class='encabezado_registro' width="15%" colspan="1" rowspan="2">
                                <img alt="Imagen" width="50%" src="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/Images/escudo1.png" />
                            </th>
                            <th  colspan="1" style="font-size:14px;" class='subtitulo_th centrar'>
                                <br>UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS
                                <br> NIT 899999230-7<br>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="1" style="font-size:12px;" class='subtitulo_th2'>
                                <?php
                                $dias = array("Domingo, ", "Lunes, ", "Martes, ", "Miercoles, ", "Jueves, ", "Viernes, ", "Sábado, ");
                                $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                                echo "Bogotá D.C, " . $fecha_cc = $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " de " . date('Y');
                                ?>

                            </th>
                        </tr>
                    </thead>      

                    <tr>
                        <td class='texto_elegante estilo_td' >Entidad Concurrente:</td>
                        <td class='texto_elegante estilo_td ' colspan='1'><?php echo'&nbsp;&nbsp;' . $datos_basicos['entidad_nombre'] ?></td>
                    </tr>
                    <tr> 
                        <td class='texto_elegante estilo_td' >NIT:</td>
                        <td class='texto_elegante estilo_td' colspan='1'><?php echo '&nbsp;&nbsp;' . $datos_basicos['entidad'] ?></td>
                    </tr>
                </table> </center>
            <br>
            <center>
                <table class='bordered'  width ="75%">
                    <tr>
                        <td class='texto_elegante estilo_td' >Nombre Pensionado:</td>
                        <td class='texto_elegante estilo_td ' colspan='1'><?php echo'&nbsp;&nbsp;' . $datos_basicos['nombre_emp'] ?></td>
                        <td class='texto_elegante estilo_td' >Documento Pensionado:</td>
                        <td class='texto_elegante estilo_td ' colspan='1'><?php echo'&nbsp;&nbsp;' . $datos_basicos['cedula'] ?></td>
                    </tr>
                    <?php
                    if (is_array($sustitutos)) {
                        foreach ($sustitutos as $key => $value) {
                            echo "<tr> <td class='texto_elegante estilo_td' >Nombre Sustituto:</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:right'>&nbsp;&nbsp;" . $sustitutos[$key]['sus_nombresus'] . "</td>";
                            echo "<td class='texto_elegante estilo_td' >Documento Sustituto:</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:right'>&nbsp;&nbsp;" . $sustitutos[$key]['sus_cedulasus'] . "</td></tr>";
                        }
                    } else {
                        echo "<tr> <td class='texto_elegante estilo_td' >Nombre Sustituto:</td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:right'>&nbsp;&nbsp; </td>";
                        echo "<td class='texto_elegante estilo_td' >Documento Sustituto:</td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:right'>&nbsp;&nbsp;</td></tr>";
                    }
                    ?>
                </table>
            </center>
            <br>
            <center>
                <table class='bordered'  width ="90%" >
                    <tr>
                        <th colspan="14" class="subtitulo_th" style="font-size:12px;">DETALLE DE LA LIQUIDACIÓN</th>
                    </tr>
                    <tr>
                        <th class='subtitulo_th centrar' rowspan='2'>ID</th>
                        <th class='subtitulo_th centrar' rowspan='2'>FECHA GENERADO</th>
                        <th class='subtitulo_th centrar' colspan="2">LIQUIDACIÓN</th>
                        <th class='subtitulo_th centrar' rowspan='2'>MESADA</th>
                        <th class='subtitulo_th centrar' rowspan='2'>VALOR CUOTA</th>
                        <!--th class='subtitulo_th centrar' rowspan='2'>AJUSTE PENSION</th-->
                        <th class='subtitulo_th centrar' rowspan='2'>MESADA AD.</th>
                        <th class='subtitulo_th centrar' rowspan='2'>INCREMENTO SALUD</th>
                        <th class='subtitulo_th centrar' rowspan='2'>INTERESES</th>

                        <th class='subtitulo_th centrar' rowspan='2'>TOTAL MES</th>
                        <th class='subtitulo_th centrar' colspan='3'>TIPO DE REPORTE</th>
                        <th class='subtitulo_th centrar' rowspan='2'>ESTADO COBRO</th>
                    </tr>
                    <tr>
                        <th class='subtitulo_th centrar'>DESDE</th>
                        <th class='subtitulo_th centrar'>HASTA</th>
                        <th class='subtitulo_th centrar'>CUENTA COBRO</th>
                        <th class='subtitulo_th centrar'>RESUMEN CUENTA COBRO</th>
                        <th class='subtitulo_th centrar'>DETALLE LIQUIDACIÓN</th>
                    </tr>
                    <?php
                    if (is_array($totales_liquidacion)) {
                        foreach ($totales_liquidacion as $key => $values) {

                            echo "<tr>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>" . $totales_liquidacion[$key]['liq_consecutivo'] . "</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>" . $totales_liquidacion[$key]['liq_fgenerado'] . "</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>" . $totales_liquidacion[$key]['liq_fdesde'] . "</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>" . $totales_liquidacion[$key]['liq_fhasta'] . "</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_mesada']) . "</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_cuotap']) . "</td>";
                            //echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_ajustepen']) . "</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_mesada_ad']) . "</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_incremento']) . "</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_interes']) . "</td>";

                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_total']) . "</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>"
                            . " <a href='";
                            $variable = 'pagina=liquidadorCP';
                            $variable.='&opcion=cuentacobro';
                            $variable.='&consecutivo_liq=' . $totales_liquidacion[$key]['liq_consecutivo'];
                            $variable.='&datos_basicos=' . serialize($datos_basicos);
                            $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                            echo " " . $this->indice . $variable . "'>
                            <img alt='Imagen' width='20px' src='" . $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] . "/nomina/cuotas_partes/liquidador/icons/cuentacobro.png'/></td>";


                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>"
                            . " <a href = '";
                            $variable = 'pagina=liquidadorCP';
                            $variable.='&opcion=resumencuenta';
                            $variable.='&consecutivo_liq=' . $totales_liquidacion[$key]['liq_consecutivo'];
                            $variable.='&datos_basicos=' . serialize($datos_basicos);
                            $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                            echo " " . $this->indice . $variable . "'>
                            <img alt = 'Imagen' width = '20px' src = '" . $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] . "/nomina/cuotas_partes/liquidador/icons/resumen.png'/></td>";


                            echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'>"
                            . " <a href = '";
                            $variable = 'pagina=liquidadorCP';
                            $variable.='&opcion=detallecuenta';
                            $variable.='&consecutivo_liq=' . $totales_liquidacion[$key]['liq_consecutivo'];
                            $variable.='&datos_basicos=' . serialize($datos_basicos);
                            //$variable.='&liquidacion='.serialize($liquidacion);
                            $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                            echo " " . $this->indice . $variable . "'>
                            <img alt = 'Imagen' width = '20px' src = '" . $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] . "/nomina/cuotas_partes/liquidador/icons/detalle.png'/></td>";

                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'> " . $totales_liquidacion[$key]['liq_estado_cc'] . "</p></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                        echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'></td>";
                        echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'></td>";
                        echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'></td>";
                        echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'></td>";
                        echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'></td>";
                        //echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'></td>";
                        echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'></td>";
                        echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'></td>";
                        echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'></td>";
                        echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'></td>";
                        echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'></td>";
                        echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'></td>";
                        echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'></td>";
                        echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'></td>";
                        echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </center>
            <br><br><br>
        </form>

        <?php
    }

    //PDF

    function reporteDetalle($datos_basicos, $liquidacion, $totales_liquidacion, $consecu_cc, $detalle_indice, $fecha_cobro, $jefeRecursos, $sustitutos) {
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/dbms.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/sesion.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/encriptar.class.php");

        $this->formulario = "liquidador";
        ?>
        <link	href="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/liquidador/form_estilo.css"	rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["plugins"]; ?>/jPages-master/css/jPages.css">
        <script src="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["plugins"]; ?>/jPages-master/js/jPages.js"></script>
        <!-- permite la paginacion-->        

        <script>
                                $(function () {
                                    $("div.holder").jPages({
                                        containerID: "itemContainer",
                                        previous: "←",
                                        next: "→",
                                        perPage: 5,
                                        delay: 20
                                    });
                                });
                                $(function () {
                                    $("div.holder2").jPages({
                                        containerID: "itemContainer2",
                                        previous: "←",
                                        next: "→",
                                        perPage: 3,
                                        delay: 20
                                    });
                                });
        </script>
        <form method="post" action='index.php' name='<?php echo $this->formulario; ?>' >
            <h1>Liquidación Cuota Parte para la Entidad <?php echo $datos_basicos['entidad_nombre'] ?> </h1>

            <center>
                <a href=
                   "<?php
                   $variable = "pagina=liquidadorCP";
                   $variable.="&opcion=recuperar_formato";
                   $variable.="&cedula=" . $datos_basicos['cedula'];
                   $variable.="&prev_nit=" . $datos_basicos['entidad'];
                   $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                   echo $this->indice . $variable;
                   ?>"><p style="font-size:12px; color: red; text-align: left"> <<< Volver a Reportes</p></a>
                <br><br><br>
                <table class='bordered'  width ="68%">
                    <thead>
                        <tr>
                            <th  class='encabezado_registro' width="15%" colspan="1" rowspan="2">
                                <img alt="Imagen" width="70%" src="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/Images/escudo1.png" />
                            </th>
                            <th  colspan="1" style="font-size:14px;" class='subtitulo_th centrar'>
                                <br>UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS
                                <br> NIT 899999230-7<br><br>
                                Detalle Cuenta de Cobro 
                                <br><?php echo $consecu_cc ?><br><br>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="1" style="font-size:12px;" class='subtitulo_th2'>
                                <?php
                                $dias = array("Domingo, ", "Lunes, ", "Martes, ", "Miercoles, ", "Jueves, ", "Viernes, ", "Sábado, ");
                                $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                                echo "Bogotá D.C, " . $fecha_cc = $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " de " . date('Y');
                                ?>

                            </th>
                        </tr>
                    </thead>      

                    <tr>
                        <td class='texto_elegante estilo_td' >Entidad Concurrente:</td>
                        <td class='texto_elegante estilo_td ' colspan='1'><?php echo'&nbsp;&nbsp;' . $datos_basicos['entidad_nombre'] ?></td>
                    </tr>
                    <tr> 
                        <td class='texto_elegante estilo_td' >NIT:</td>
                        <td class='texto_elegante estilo_td' colspan='1'><?php echo '&nbsp;&nbsp;' . $datos_basicos['entidad'] ?></td>
                    </tr>
                    <tr> 
                        <td class='texto_elegante estilo_td' >Fecha Corte Cuenta:</td>
                        <td class='texto_elegante estilo_td' colspan="2"><?php echo '&nbsp;&nbsp' . $fecha_cobro ?></td>
                    </tr>
                </table> </center>
            <br>
            <center>
                <table class='bordered'  width ="60%">
                    <tr>
                        <td class='texto_elegante estilo_td' >Nombre Pensionado:</td>
                        <td class='texto_elegante estilo_td ' colspan='1'><?php echo'&nbsp;&nbsp;' . $datos_basicos['nombre_emp'] ?></td>
                        <td class='texto_elegante estilo_td' >Documento Pensionado:</td>
                        <td class='texto_elegante estilo_td ' colspan='1'><?php echo'&nbsp;&nbsp;' . $datos_basicos['cedula'] ?></td>
                    </tr>

                    <?php
                    if (is_array($sustitutos)) {
                        foreach ($sustitutos as $key => $value) {
                            echo "<tr> <td class='texto_elegante estilo_td' >Nombre Sustituto:</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:right'>&nbsp;&nbsp;" . $sustitutos[$key]['sus_nombresus'] . "</td>";
                            echo "<td class='texto_elegante estilo_td' >Documento Sustituto:</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:right'>&nbsp;&nbsp;" . $sustitutos[$key]['sus_cedulasus'] . "</td></tr>";
                        }
                    } else {
                        echo "<tr> <td class='texto_elegante estilo_td' >Nombre Sustituto:</td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:right'>&nbsp;&nbsp; </td>";
                        echo "<td class='texto_elegante estilo_td' >Documento Sustituto:</td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:right'>&nbsp;&nbsp;</td></tr>";
                    }
                    ?>

                </table>
            </center>
            <br>
            <center>
                <table class='bordered'  width ="68%" >
                    <tr>
                        <th colspan="8" class="subtitulo_th" style="font-size:12px;">DETALLE DE LA LIQUIDACIÓN</th>
                    </tr>
                    <tr>
                        <th class='subtitulo_th centrar'>CICLO</th>
                        <th class='subtitulo_th centrar'>MESADA</th>
                        <th class='subtitulo_th centrar'>VALOR CUOTA</th>
                        <!--th class='subtitulo_th centrar'>AJUSTE PENSION</th-->
                        <th class='subtitulo_th centrar'>MESADA AD.</th>
                        <th class='subtitulo_th centrar'>INCREMENTO SALUD</th>
                        <th class='subtitulo_th centrar'>INTERÉS L_68/1923</th>
                        <th class='subtitulo_th centrar'>INTERÉS L_1066/2006</th>
                        <th class='subtitulo_th centrar'>TOTAL MES</th>
                    </tr>
                    <tbody id="itemContainer">
                        <?php
                        if (is_array($liquidacion)) {
                            foreach ($liquidacion as $key => $value) {

                                echo "<tr>";
                                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>" . date('Y-m', strtotime(str_replace('/', '-', $liquidacion[$key]['fecha']))) . "</td>";
                                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($liquidacion[$key]['mesada']) . "</td>";
                                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($liquidacion[$key]['cuota_parte']) . "</td>";
                                //echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;' >" . $liquidacion[$key]['ajuste_pension'] . "</td>";
                                echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'>" . number_format($liquidacion[$key]['mesada_adc']) . "</td>";
                                echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'>" . number_format($liquidacion[$key]['incremento']) . "</td>";
                                echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'>$ " . number_format($liquidacion[$key]['interes_a2006']) . "</td>";
                                echo "<td class = 'texto_elegante estilo_td' style = 'text-align:center;'>$ " . number_format($liquidacion[$key]['interes_d2006']) . "</td > ";
                                echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($liquidacion[$key]['total']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            //echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                            echo "</tr>";
                        }
                        ?>
                </table>
                <center><div class="holder" style="-moz-user-select: none;"></div></center>
            </center>
            <br>
            <center>
                <table class='bordered'  width ="68%" >
                    <tr>
                        <th colspan="9" class="subtitulo_th" style="font-size:12px;">PARCIALES LIQUIDACIÓN</th>
                    </tr>
                    <tr>
                        <th class='encabezado_registro' width="12%" rowspan="2">TOTAL</th>
                        <!--th class='subtitulo_th centrar'>AJUSTE PENSION</th-->
                        <th class='subtitulo_th centrar'>VALOR CUOTA</th>
                        <th class='subtitulo_th centrar'>MESADA AD.</th>
                        <th class='subtitulo_th centrar'>INCREMENTO SALUD</th>
                        <th class='subtitulo_th centrar'>INTERES LEY 68/1923</th>
                        <th class='subtitulo_th centrar'>INTERES LEY 1066/2006</th>
                        <th class='subtitulo_th centrar'>ACUMULADO INTERES</th>
                    </tr>
                    <?php
                    if (is_array($totales_liquidacion)) {

                        foreach ($totales_liquidacion as $key => $values) {

                            echo "<tr>";
                            //echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_ajustepen']) . "</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_cuotap']) . "</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_mesada_ad']) . "</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_incremento']) . "</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_interes_a2006']) . "</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_interes_d2006']) . "</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:center;'>$ " . number_format($totales_liquidacion[$key]['liq_interes']) . "</td>";
                            echo "</tr>";
                            $total[$key] = $totales_liquidacion[$key]['liq_total'];
                        }
                    } else {
                        echo "<tr>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:center;'></td>";
                        echo "</tr>";
                    }
                    ?>
                    <tr>
                        <th class='subtitulo_th2' colspan="1">TOTAL&nbsp;&nbsp;</th>
                        <td class='texto_elegante estilo_td3' colspan="8" style='text-align:center'><?php echo " $ " . number_format($total[0]) ?></td>
                    </tr>
                </table>
            </center>

            <br><br>
            <center>
                <table class='bordered'  width ="20%" >
                    <tr>
                        <th colspan="3" class="subtitulo_th" style="font-size:12px;">AJUSTES ANUALES PENSIÓN APLICADOS (Ley 4a/76, Ley 71/88 y Ley 100 de 1993)</th>
                    </tr>
                    <tr>
                        <th class='subtitulo_th centrar'>VIGENCIA</th>
                        <th class = 'subtitulo_th centrar'>PORCENTAJE (IPC)</th>
                        <th class = 'subtitulo_th centrar'>SUMAFIJA</th>
                    </tr>
                    <tbody id="itemContainer2">
                        <?php
                        foreach ($detalle_indice as $key => $values) {
                            echo "<tr>";
                            echo " <td class='texto_elegante estilo_td' style='text-align:center;'>" . $detalle_indice[$key]['vigencia'] . "</td> ";
                            echo " <td class='texto_elegante estilo_td' style='text-align:center;'>" . $detalle_indice[$key]['ipc'] . "</td> ";
                            echo " <td class='texto_elegante estilo_td' style='text-align:center;'>" . $detalle_indice[$key]['suma_fija'] . "</td> ";
                            echo "</tr>";
                        }
                        ?>
                </table>
                <center><div class="holder2" style="-moz-user-select: none;"></div></center>
            </center>
            <br><br>
            <center>
                <table class = 'bordered' width = "60%">
                    <tr>
                        <td class = 'estilo_td' align = justify style = "font-size:12px" colspan = "9">
                            <br><br><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class = 'estilo_td' align = center style = "font-size:12px" colspan = "9">
                            <?php echo $jefeRecursos[0][0] ?>
                            <br>Jefe(a) División de Recursos Humanos
                        </td>
                    </tr>
                </table>
                <p style="font-size:9px">Diseño forma: J.D.C.M.
                    <br><br><br><br><br>
                <p>______________________________________________________________________________
                <p style="font-size:12px">UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS
                <p style="font-size:12px">Carrera 7 40-53 PBX: 323 93 00, Ext. 1618 - 1603.
            </center>

            <br><br><br>
            <div>
                <div class="null"></div>
                <input id="generarBoton" type="submit" class="navbtn" value="Generar PDF">
                <input type='hidden' name='no_pagina' value="liquidadorCP">
                <input type='hidden' name='opcion' value='pdf_detalle'>
                <input type="hidden" name='datos_basicos' value='<?php echo serialize($datos_basicos) ?>'>
                <input type="hidden" name='totales_liquidacion' value='<?php echo serialize($totales_liquidacion) ?>'>
                <input type="hidden" name='detalle_indice' value='<?php echo serialize($detalle_indice) ?>'>
                <input type="hidden" name='liquidacion' value='<?php echo serialize($liquidacion) ?>'>
                <input type="hidden" name='consecutivo' value='<?php echo $consecu_cc ?>'>
                <input type="hidden" name='fecha_cobro' value='<?php echo $fecha_cobro ?>'>
                <input type="hidden" name='jRecursos' value='<?php echo $jefeRecursos[0][0] ?>'>
            </div>
        </form>

        <a href=
           "<?php
           $variable = "pagina=liquidadorCP";
           $variable.="&opcion=recuperar_formato";
           $variable.="&cedula=" . $datos_basicos['cedula'];
           $variable.="&prev_nit=" . $datos_basicos['entidad'];
           $variable = $this->cripto->codificar_url($variable, $this->configuracion);
           echo $this->indice . $variable;
           ?>"><p style="font-size:12px; color: red; text-align: left"> <<< Volver a Reportes</p></a>
        <br><br><br>


        <?php
    }

    function reporteCuenta($datos_basicos, $totales_liquidacion, $enletras, $consecutivo, $jefeRecursos, $jefeTesoreria, $sustitutos) {
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/dbms.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/sesion.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/encriptar.class.php");

        $this->formulario = "liquidador";
        ?>

        <link	href="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/liquidador/form_estilo.css"	rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["plugins"]; ?>/jPages-master/css/jPages.css">
        <script src="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["plugins"]; ?>/jPages-master/js/jPages.js"></script>
        <!-- permite la paginacion-->        

        <form method="post" action='index.php' name='<?php echo $this->formulario; ?>' >
            <h1>Cuenta Cobro para la Entidad <?php echo $datos_basicos['entidad_nombre'] ?> </h1>

            <center>
                <a href=
                   "<?php
                   $variable = "pagina=liquidadorCP";
                   $variable.="&opcion=recuperar_formato";
                   $variable.="&cedula=" . $datos_basicos['cedula'];
                   $variable.="&prev_nit=" . $datos_basicos['entidad'];
                   $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                   echo $this->indice . $variable;
                   ?>"><p style="font-size:12px; color: red; text-align: left"> <<< Volver a Reportes</p></a>

                <br><br>
                <table class='bordered'  width ="68%">
                    <thead>
                        <tr>
                            <th  class='encabezado_registro' width="15%" colspan="1" rowspan="2">
                                <img alt="Imagen" width="50%" src="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/Images/escudo1.png" />
                            </th>
                            <th  colspan="1" style="font-size:14px;" class='subtitulo_th centrar'>
                                <br>UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS
                                <br> NIT 899999230-7<br>
                                <br> DIVISIÓN DE RECURSOS HUMANOS<br><br>
                            </th>
                            <th  colspan="1" style="font-size:14px;" class='subtitulo_th centrar'>
                                <br>CUENTA DE COBRO No.
                                <br> <?php echo $consecutivo; ?><br>
                                <br> <?php
                                $dias = array("Domingo, ", "Lunes, ", "Martes, ", "Miercoles, ", "Jueves, ", "Viernes, ", "Sábado, ");
                                $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                                echo $fecha_cc = $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
                                ?><br><br>
                            </th>
                        </tr>

                    </thead>      

                    <tr>
                        <td class='texto_elegante estilo_td' >Entidad Concurrente:</td>
                        <td class='texto_elegante estilo_td ' colspan='2'><?php echo'&nbsp;&nbsp;' . $datos_basicos['entidad_nombre'] ?></td>
                    </tr>
                    <tr> 
                        <td class='texto_elegante estilo_td' >NIT:</td>
                        <td class='texto_elegante estilo_td' colspan='2'><?php echo '&nbsp;&nbsp;' . $datos_basicos['entidad'] ?></td>
                    </tr>
                    <tr> 
                        <td class='texto_elegante estilo_td' >Fecha Vencimiento Cuenta:</td>
                        <td class='texto_elegante estilo_td' colspan="2"><?php echo '&nbsp;&nbsp; 30 días calendario a partir de la fecha de recibido' ?></td>
                    </tr>
                </table> </center>
            <br>
            <center>
                <table class='bordered'  width ="60%">
                    <tr>
                        <td class='texto_elegante estilo_td' >Nombre Pensionado:</td>
                        <td class='texto_elegante estilo_td ' colspan='1'><?php echo'&nbsp;&nbsp;' . $datos_basicos['nombre_emp'] ?></td>
                        <td class='texto_elegante estilo_td' >Documento Pensionado:</td>
                        <td class='texto_elegante estilo_td ' colspan='1'><?php echo'&nbsp;&nbsp;' . $datos_basicos['cedula'] ?></td>
                    </tr><?php
                    if (is_array($sustitutos)) {
                        foreach ($sustitutos as $key => $value) {
                            echo "<tr> <td class='texto_elegante estilo_td' >Nombre Sustituto:</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:right'>&nbsp;&nbsp;" . $sustitutos[$key]['sus_nombresus'] . "</td>";
                            echo "<td class='texto_elegante estilo_td' >Documento Sustituto:</td>";
                            echo "<td class='texto_elegante estilo_td' style='text-align:right'>&nbsp;&nbsp;" . $sustitutos[$key]['sus_cedulasus'] . "</td>";
                        }
                    } else {
                        echo "<tr> <td class='texto_elegante estilo_td' >Nombre Sustituto:</td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:right'>&nbsp;&nbsp; </td>";
                        echo "<td class='texto_elegante estilo_td' >Documento Sustituto:</td>";
                        echo "<td class='texto_elegante estilo_td' style='text-align:right'>&nbsp;&nbsp;</td>";
                    }
                    ?>
                </table>
            </center>
            <br>
            <center>
                <table class='bordered'  width ="68%" >

                    <tr>
                        <th class='subtitulo_th centrar'>Item</th>
                        <th class='subtitulo_th centrar'>Descripción</th>
                        <th class='subtitulo_th centrar'>DESDE</th>
                        <th class='subtitulo_th centrar'>HASTA</th>
                        <th class='subtitulo_th centrar'>Valor</th>
                    </tr>
                    <tr>
                        <td class='texto_elegante estilo_td'>1</td>
                        <td class='texto_elegante estilo_td'>Cuotas Partes Pensionales (mesadas ordinarias y adicionales)</td>
                        <td class='texto_elegante estilo_td'><?php echo "&nbsp;&nbsp;" . $totales_liquidacion[0]['liq_fdesde'] ?></td>
                        <td class='texto_elegante estilo_td'><?php echo "&nbsp;&nbsp;" . $totales_liquidacion[0]['liq_fhasta'] ?></td>
                        <td class='texto_elegante estilo_td'><?php echo "&nbsp;&nbsp;$ " . number_format($totales_liquidacion[0]['liq_cuotap'] + $totales_liquidacion[0]['liq_mesada_ad']) ?></td>
                    </tr>
                    <tr>
                        <td class='texto_elegante estilo_td'>2</td>
                        <td class='texto_elegante estilo_td'>Incremento en Cotización Salud</td>
                        <td class='texto_elegante estilo_td'><?php echo "&nbsp;&nbsp;" . $totales_liquidacion[0]['liq_fdesde'] ?></td>
                        <td class='texto_elegante estilo_td'><?php echo "&nbsp;&nbsp;" . $totales_liquidacion[0]['liq_fhasta'] ?></td>
                        <td class='texto_elegante estilo_td'><?php echo "&nbsp;&nbsp;$ " . number_format($totales_liquidacion[0]['liq_incremento']) ?></td>
                    </tr>
                    <tr>
                        <td class='texto_elegante estilo_td'>3</td>
                        <td class='texto_elegante estilo_td'>Valor Intereses Ley 68/1923</td>
                        <td class='texto_elegante estilo_td'><?php echo "&nbsp;&nbsp;" . $totales_liquidacion[0]['liq_fdesde'] ?></td>
                        <td class='texto_elegante estilo_td'><?php echo "&nbsp;&nbsp;" . $totales_liquidacion[0]['liq_fhasta'] ?></td>
                        <td class='texto_elegante estilo_td'><?php echo "&nbsp;&nbsp;$ " . number_format($totales_liquidacion[0]['liq_interes_a2006']) ?></td>
                    </tr>
                    <tr>
                        <td class='texto_elegante estilo_td'>4</td>
                        <td class='texto_elegante estilo_td'>Valor Intereses Ley 1066/2006</td>
                        <td class='texto_elegante estilo_td'><?php echo "&nbsp;&nbsp;" . $totales_liquidacion[0]['liq_fdesde'] ?></td>
                        <td class='texto_elegante estilo_td'><?php echo "&nbsp;&nbsp;" . $totales_liquidacion[0]['liq_fhasta'] ?></td>
                        <td class='texto_elegante estilo_td'><?php echo "&nbsp;&nbsp;$ " . number_format($totales_liquidacion[0]['liq_interes_d2006']) ?></td>
                    </tr>

                    <tr>
                        <th class='subtitulo_th2' colspan="4">TOTAL&nbsp;&nbsp;</th>
                        <td class='texto_elegante estilo_td3'><?php echo "&nbsp;&nbsp;$ " . number_format($totales_liquidacion[0]['liq_total']) ?></td>
                    </tr>
                    <tr>
                        <td class='estilo_td' align="center"  colspan="45">SON&nbsp;<?php echo $enletras ?></td>
                    </tr>
                </table>
            </center>
            <br>
            <center>
                <table class='bordered'  width ="60%">
                    <tr>
                        <td class='estilo_td' align:justify style="font-size:12px" colspan="2">
                            El (La) Jefe de la División de Recursos Humanos y la (el) Tesorero (a) de 
                            la UNIVERSIDAD DISTRITAL FRANCISCO JOSE DE CALDAS, certifican que  la persona 
                            por quien se realiza este cobro se encuentra incluida en nomina  de pensionados y se le ha pagado las mesadas cobradas.
                            La supervivencia fue verificada de conformidad con el articulo 21 del Decreto 19 de 2012.</td>
                    </tr>
                    <tr>
                        <td class='estilo_td' align=justify style="font-size:12px" colspan="2">
                            La suma adeudada debe ser consignada (en efectivo, cheque de gerencia o transferencia electronica) en la Cuenta 
                            de Ahorros No 251–80660–0 del Banco de Occcidente, a nombre del FONDO DE PENSIONES UNIVERSIDAD DISTRITAL y remitir 
                            copia de la misma a la carrera 7 Nº 40-53, piso 6, Division de Recursos Humanos y al correo electronico rechumanos@udistrital.edu.co.
                            <br><br>
                            En caso de haber pagado parcial o totalmente esta cuenta, favor descontar el valor de dicho abono (s) del presente 
                            cobro y remitir el (los) comprobante (s) del (los) pago (s) realizado (s).</td>
                    </tr>
                    <tr>
                        <td class='estilo_td' align=justify style="font-size:12px" colspan="2">
                            <br><br><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class='estilo_td' align=center style="font-size:12px">
                            <?php echo $jefeTesoreria[0][0] ?>
                            <br>Tesorero(a)
                        </td>
                        <td class='estilo_td' align=center style="font-size:12px">
                            <?php echo $jefeRecursos[0][0] ?>
                            <br>Jefe(a) División de Recursos Humanos
                        </td>
                    </tr>
                </table>
                <p style="font-size:9px">Diseño forma: J.D.C.M.
                    <br><br><br><br><br>
                <p>______________________________________________________________________________
                <p style="font-size:12px">UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS
                <p style="font-size:12px">Carrera 7 40-53 PBX: 323 93 00, Ext. 1618 - 1603.
            </center>
            <br>
            <div>
                <div class="null"></div>
                <input id="generarBoton" type="submit" class="navbtn" value="Generar PDF">
                <input type='hidden' name='no_pagina' value="liquidadorCP">
                <input type='hidden' name='opcion' value='pdf_cuenta'>
                <input type="hidden" name='datos_basicos' value='<?php echo serialize($datos_basicos) ?>'>
                <input type="hidden" name='totales_liquidacion' value='<?php echo serialize($totales_liquidacion) ?>'>
                <input type="hidden" name='consecutivo' value='<?php echo $consecutivo ?>'>
                <input type="hidden" name='letras' value='<?php echo $enletras ?>'>
                <input type="hidden" name='jRecursos' value='<?php echo $jefeRecursos[0][0] ?>'>
                <input type="hidden" name='jTesoreria' value='<?php echo $jefeTesoreria[0][0] ?>'>
            </div>
        </form>

        <a href=
           "<?php
           $variable = "pagina=liquidadorCP";
           $variable.="&opcion=recuperar_formato";
           $variable.="&cedula=" . $datos_basicos['cedula'];
           $variable.="&prev_nit=" . $datos_basicos['entidad'];
           $variable = $this->cripto->codificar_url($variable, $this->configuracion);
           echo $this->indice . $variable;
           ?>"><p style="font-size:12px; color: red; text-align: left"> <<< Volver a Reportes</p></a>
        <br><br><br>
        <?php
    }

    function reporteResumen($datos_basicos, $consecu_cc, $datos_concurrencia, $datos_pensionado, $liquidacion_anual, $dias_cargo, $jefeRecursos, $sustitutos) {

        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/dbms.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/sesion.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/encriptar.class.php");

        $this->formulario = "liquidador";
        ?>
        <link	href="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/liquidador/form_estilo.css"	rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["plugins"]; ?>/jPages-master/css/jPages.css">
        <script src="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["plugins"]; ?>/jPages-master/js/jPages.js"></script>
        <!-- permite la paginacion-->        

        <form method="post" action='index.php' name='<?php echo $this->formulario; ?>' >
            <h2>Resumen Cuenta Cobro para la Entidad <?php echo $datos_basicos['entidad_nombre'] ?> </h2><br><br>

            <center>
                <a href=
                   "<?php
                   $variable = "pagina=liquidadorCP";
                   $variable.="&opcion=recuperar_formato";
                   $variable.="&cedula=" . $datos_basicos['cedula'];
                   $variable.="&prev_nit=" . $datos_basicos['entidad'];
                   $variable = $this->cripto->codificar_url($variable, $this->configuracion);
                   echo $this->indice . $variable;
                   ?>"><p style="font-size:12px; color: red; text-align: left"> <<< Volver a Reportes</p></a>
                <br><br><br>
                <table class='bordered'  width ="60%">
                    <thead>
                        <tr>
                            <th  class='encabezado_registro' width="15%" colspan="1" rowspan="2">
                                <img alt="Imagen" width="50%" src="<?php echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["bloques"] ?>/nomina/cuotas_partes/Images/escudo1.png" />
                            </th>
                            <th  colspan="1" style="font-size:14px;" class='subtitulo_th centrar'>
                                <br>UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS
                                <br> NIT 899999230-7<br>
                                <br> DIVISIÓN DE RECURSOS HUMANOS<br><br>
                            </th>
                            <th  colspan="1" style="font-size:14px;" class='subtitulo_th centrar'>
                                <br>RESUMEN CUENTA DE COBRO
                                <br> No.<?php echo $consecu_cc ?><br>
                                <br> <?php
                                $dias = array("Domingo, ", "Lunes, ", "Martes, ", "Miercoles, ", "Jueves, ", "Viernes, ", "Sábado, ");
                                $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                                echo "Bogotá D.C. " . $fecha_cc = $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
                                ?><br><br>
                            </th>
                        </tr>

                    </thead>      

                    <tr>
                        <td class='texto_elegante estilo_td' >Entidad Concurrente:</td>
                        <td class='texto_elegante estilo_td ' colspan='2'><?php echo'&nbsp;&nbsp;' . $datos_basicos['entidad_nombre'] ?></td>
                    </tr>
                    <tr> 
                        <td class='texto_elegante estilo_td' >NIT:</td>
                        <td class='texto_elegante estilo_td' colspan='2'><?php echo '&nbsp;&nbsp;' . $datos_basicos['entidad'] ?></td>
                    </tr>
                </table> </center>
            <br>
            <center>
                <table class='bordered'  width ="60%">
                    <tr>
                        <th class='subtitulo_th centrar' colspan="11">DATOS PENSIONADO - PENSIÓN</th>
                    </tr>
                    <tr>
                        <td class='texto_elegante estilo_td' colspan='3'>Nombres y Apellidos del Titular:</td>
                        <td class='texto_elegante estilo_td' colspan='8'><?php echo'&nbsp;&nbsp;' . $datos_basicos['nombre_emp'] ?></td>
                    </tr>
                    <tr>
                        <td class='texto_elegante estilo_td' colspan='3'>Documento:</td>
                        <td class='texto_elegante estilo_td' colspan='8'><?php echo'&nbsp;&nbsp;' . $datos_basicos['cedula'] ?></td>
                    </tr>
                    <tr>
                        <td class='texto_elegante estilo_td' colspan='3'>Fecha de Nacimiento:</td>
                        <td class='texto_elegante estilo_td' colspan='8'><?php echo'&nbsp;&nbsp;' . $datos_pensionado[0]['FECHA_NAC'] ?></td>
                    </tr>
                    <tr>
                        <td class='texto_elegante estilo_td' colspan='3'>Resolución Reconocimiento Concurrencia:</td>
                        <td class='texto_elegante estilo_td' colspan='3'><?php echo'&nbsp;&nbsp;' . $datos_concurrencia[0]['dcp_actoadmin'] ?></td>
                        <td class='texto_elegante estilo_td' colspan='3'>Fecha Resolución Reconocimiento:</td>
                        <td class='texto_elegante estilo_td' colspan='2'><?php echo'&nbsp;&nbsp;' . $datos_concurrencia[0]['dcp_factoadmin'] ?></td>
                    </tr>
                    <tr>
                        <td class='texto_elegante estilo_td' colspan='3'>Fecha Resolución Pensión:</td>
                        <td class='texto_elegante estilo_td' colspan='3'><?php echo'&nbsp;&nbsp;' . date('d/m/Y', strtotime(str_replace('/', '-', $datos_concurrencia[0]['dcp_resol_pension_fecha']))); ?></td>
                        <td class='texto_elegante estilo_td' colspan='3'>Fecha Pensión:</td>
                        <td class='texto_elegante estilo_td' colspan='2'><?php echo'&nbsp;&nbsp;' . date('d/m/Y', strtotime(str_replace('/', '-', $datos_concurrencia[0]['dcp_fecha_pension']))); ?></td>
                    </tr>
                    <tr>
                        <td class='texto_elegante estilo_td' colspan='3'>Fecha Inicio de Concurrencia:</td>
                        <td class='texto_elegante estilo_td' colspan='8'><?php echo'&nbsp;&nbsp;' . date('d/m/Y', strtotime(str_replace('/', '-', $datos_concurrencia[0]['dcp_fecha_concurrencia']))); ?></td>
                    </tr>
                    <tr>
                        <!--td class='texto_elegante estilo_td' colspan='1'>Días a Cargo:</td>
                        <td class='texto_elegante estilo_td' colspan='1'><?php echo'&nbsp;&nbsp;' . $dias_cargo[$datos_basicos['entidad']]['total_dia'] ?></td>
                        <td class='texto_elegante estilo_td' colspan='1'>Total Días</td>
                        <td class='texto_elegante estilo_td' colspan='2'><?php echo'&nbsp;&nbsp;' . $dias_cargo['Total'] ?></td-->
                        <td class='texto_elegante estilo_td' colspan='3'>Porcentaje Aceptado:</td>
                        <td class='texto_elegante estilo_td' colspan='8'><?php echo'&nbsp;&nbsp;' . (($datos_concurrencia[0]['dcp_porcen_cuota']) * 100) . '&nbsp;%' ?></td>
                        <!--td class='texto_elegante estilo_td' colspan='1'>Porcentaje Calculado:</td>
                        <td class='texto_elegante estilo_td' colspan='1'><?php echo'&nbsp;&nbsp;' . round(((($dias_cargo[$datos_basicos['entidad']]['total_dia']) / ($dias_cargo['Total'])) * 100), 3) . '&nbsp;%' ?></td-->
                    </tr>
                    <tr>
                        <td class='texto_elegante estilo_td' colspan='2'>Mesada Inicial:</td>
                        <td class='texto_elegante estilo_td' colspan='3'><?php echo'&nbsp;$&nbsp;' . number_format($datos_concurrencia[0]['dcp_valor_mesada']) ?></td>
                        <td class='texto_elegante estilo_td' colspan='2'>Cuota Parte:</td>
                        <td class='texto_elegante estilo_td' colspan='4'><?php echo'&nbsp;$&nbsp;' . number_format($datos_concurrencia[0]['dcp_valor_cuota']) ?></td>
                    </tr>
                    <!--tr>
                        <td class='texto_elegante estilo_td' colspan='3'>Resolución que modifica o reliquida:</td>
                        <td class='texto_elegante estilo_td' colspan='8'><?php echo'&nbsp;&nbsp;' ?></td>
                    </tr-->
                    <?php
                    if (is_array($sustitutos)) {
                        echo " <tr> ";
                        echo "      <th class='subtitulo_th centrar' colspan='11'>DATOS PENSIONADO - SUSTITUTO</th> ";
                        echo " </tr> ";
                        echo " <tr> ";
                        echo "      <td class = 'texto_elegante estilo_td' colspan = '2'>Fecha Defunción Titular:</td > ";
                        echo "      <td class='texto_elegante estilo_td' colspan='9'>" . $sustitutos[0]['sus_fdefuncion'] . "</td> ";
                        echo " </tr> ";

                        foreach ($sustitutos as $key => $values) {

                            echo " <tr> ";
                            echo "      <td class='texto_elegante estilo_td' colspan='2'>Nombre Sustituto:</td> ";
                            echo "      <td class='texto_elegante estilo_td' colspan='6'>" . $sustitutos[$key]['sus_nombresus'] . "</td> ";
                            echo "      <td class='texto_elegante estilo_td' colspan='2'>Documento Sustituto:</td> ";
                            echo "      <td class='texto_elegante estilo_td' colspan='6'>" . $sustitutos[$key]['sus_cedulasus'] . "</td> ";
                            echo " </tr> ";
                            echo " <tr> ";
                            echo "      <td class='texto_elegante estilo_td' colspan='2'>Fecha Nacimiento Sustituto:</td> ";
                            echo "      <td class='texto_elegante estilo_td' colspan='6'>" . $sustitutos[$key]['sus_fnac_sustituto'] . "</td> ";
                            echo "      <td class='texto_elegante estilo_td' colspan='2'>Resolución de Sustitución:</td> ";
                            echo "      <td class='texto_elegante estilo_td' colspan='6'>" . $sustitutos[$key]['sus_resol_sustitucion'] . "</td> ";
                            echo " </tr> ";
                        }
                    }
                    ?>
                </table>
            </center>
            <br>
            <center>
                <table class='bordered'  width ="60%" >
                    <tr>
                        <th class = 'subtitulo_th centrar' colspan = '2'>PERIODO</th>
                        <th class = 'subtitulo_th centrar' rowspan = '2'>MONTO DE MESADA</th>
                        <th class = 'subtitulo_th centrar' rowspan = '2'>CUOTA MENSUAL</th>
                        <th class = 'subtitulo_th centrar' rowspan = '2'>MESADA ADICIONAL</th>
                        <th class = 'subtitulo_th centrar' rowspan = '2'>INCREMENTO SALUD (7%)</th>
                        <th class = 'subtitulo_th centrar' rowspan = '2'>INTERÉS LEY 68/1923</th>
                        <th class = 'subtitulo_th centrar' rowspan = '2'>INTERÉS LEY 1066/2006</th>
                        <th class = 'subtitulo_th centrar' rowspan = '2'>TOTAL AÑO</th>
                    </tr>
                    <tr>
                        <th class = 'subtitulo_th centrar' colspan="2">AÑO</th>
                        <!--th class = 'subtitulo_th centrar'>MESES</th-->
                    </tr>
                    <?php
                    $total = 0;
                    foreach ($liquidacion_anual as $key => $values) {
                        echo " <tr> ";
                        echo " <td class = 'texto_elegante estilo_td' colspan='2'>" . $liquidacion_anual[$key]['vigencia'] . "</td> ";
                        //echo " <td class = 'texto_elegante estilo_td'>MM/MM</td> ";
                        echo " <td class = 'texto_elegante estilo_td'>&nbsp;$&nbsp;" . number_format($liquidacion_anual[$key]['mesada'], 2, ',', '.') . "</td> ";
                        echo " <td class = 'texto_elegante estilo_td'>&nbsp;$&nbsp;" . number_format($liquidacion_anual[$key]['cuota_parte'], 2, ',', '.') . "</td> ";
                        echo " <td class = 'texto_elegante estilo_td'>&nbsp;$&nbsp;" . number_format($liquidacion_anual[$key]['mesada_adc'], 2, ',', '.') . "</td> ";
                        echo " <td class = 'texto_elegante estilo_td'>&nbsp;$&nbsp;" . number_format($liquidacion_anual[$key]['incremento'], 2, ',', '.') . "</td> ";
                        echo " <td class = 'texto_elegante estilo_td'>&nbsp;$&nbsp;" . number_format($liquidacion_anual[$key]['interes_a2006'], 2, ',', '.') . "</td> ";
                        echo " <td class = 'texto_elegante estilo_td'>&nbsp;$&nbsp;" . number_format($liquidacion_anual[$key]['interes_d2006'], 2, ',', '.') . "</td> ";
                        echo " <td class = 'texto_elegante estilo_td'>&nbsp;$&nbsp;" . number_format($liquidacion_anual[$key]['total'], 2, ',', '.') . "</td> ";
                        echo " </tr> ";
                        $total = $liquidacion_anual[$key]['total'] + $total;

                        $total_entero = round($total);
                        $exceso = $total_entero - $total;
                    }
                    ?>
                    <tr>
                        <th class='subtitulo_th2' colspan="6">Valor liquidado a la fecha de corte&nbsp;&nbsp;</th>
                        <td class='texto_elegante estilo_td3' colspan="3">&nbsp;$&nbsp;<?php echo number_format($total, 2, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <th class='subtitulo_th2' colspan="6">Ajuste al peso&nbsp;&nbsp;</th>
                        <td class='texto_elegante estilo_td3' colspan="3">&nbsp;$&nbsp;<?php echo number_format($exceso, 2, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <th class='subtitulo_th2' colspan="6">VALOR A COBRAR&nbsp;&nbsp;</th>
                        <td class='texto_elegante estilo_td3' colspan="3">&nbsp;$&nbsp;<?php echo number_format($total_entero, 2, ',', '.') ?></td>
                    </tr>
                    </tr>

                </table>
            </center>

            <br>
            <center>
                <table class='bordered'  width ="60%">

                    <tr>
                        <td class='estilo_td' align=justify style="font-size:12px" colspan="9">
                            <br><br><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class='estilo_td' align=center style="font-size:12px" colspan="9">
                            <?php echo $jefeRecursos[0][0] ?>
                            <br>Jefe(a) División de Recursos Humanos
                        </td>
                    </tr>
                </table>
                <p style="font-size:9px">Diseño forma: J.D.C.M.
                    <br><br><br><br><br>
                <p>______________________________________________________________________________
                <p style="font-size:12px">UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS
                <p style="font-size:12px">Carrera 7 40-53 PBX: 323 93 00, Ext. 1618 - 1603.
            </center>
            <br><br>

            <div>
                <div class="null"></div>
                <input id="generarBoton" type="submit" class="navbtn" value="Generar PDF">
                <input type='hidden' name='no_pagina' value="liquidadorCP">
                <input type='hidden' name='opcion' value='pdf_resumen'>
                <input type="hidden" name='datos_basicos' value='<?php echo serialize($datos_basicos) ?>'>
                <input type="hidden" name='datos_concurrencia' value='<?php echo serialize($datos_concurrencia) ?>'>
                <input type="hidden" name='datos_pensionado' value='<?php echo serialize($datos_pensionado) ?>'>
                <input type="hidden" name='liquidacion_anual' value='<?php echo serialize($liquidacion_anual) ?>'>
                <input type="hidden" name='consecutivo' value='<?php echo $consecu_cc ?>'>
                <input type="hidden" name='dias_cargo' value='<?php echo $dias_cargo[$datos_basicos['entidad']]['total_dia'] ?>'>
                <input type="hidden" name='total_dias' value='<?php echo $dias_cargo['Total'] ?>'>
                <input type="hidden" name='jRecursos' value='<?php echo $jefeRecursos[0][0] ?>'>
            </div>
        </form>

        <a href=
           "<?php
           $variable = "pagina=liquidadorCP";
           $variable.="&opcion=recuperar_formato";
           $variable.="&cedula=" . $datos_basicos['cedula'];
           $variable.="&prev_nit=" . $datos_basicos['entidad'];
           $variable = $this->cripto->codificar_url($variable, $this->configuracion);
           echo $this->indice . $variable;
           ?>"><p style="font-size:12px; color: red; text-align: left"> <<< Volver a Reportes</p></a>
        <br><br><br>

        <?php
    }

}
?>