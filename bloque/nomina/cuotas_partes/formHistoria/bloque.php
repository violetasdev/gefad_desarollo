<?
/*
  ############################################################################
  #    UNIVERSIDAD DISTRITAL Francisco Jose de Caldas                        #
  #    Copyright: Vea el archivo EULA.txt que viene con la distribucion      #
  ############################################################################
 */
/* --------------------------------------------------------------------------------------------------------------------------
  @ Derechos de Autor: Vea el archivo LICENCIA.txt que viene con la distribucion
  --------------------------------------------------------------------------------------------------------------------------- */
/* ---------------------------------------------------------------------------------------
  |				Control Versiones				    	|
  ----------------------------------------------------------------------------------------
  | fecha      |        Autor            | version     |              Detalle            |
  ----------------------------------------------------------------------------------------
  | 18/05/2013 | Violet Sosa             | 0.0.0.1     |                                 |
  ----------------------------------------------------------------------------------------
 */



include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/dbms.class.php");
include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/sesion.class.php");
include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/encriptar.class.php");
?>
<html>
    <head>

        <!referencias a estilos y plugins>
    <script type="text/javascript" src="<? echo $this->configuracion["host"] . $this->configuracion["site"] . $this->configuracion["plugins"]; ?>/datepicker/js/datepicker.js"></script>
    <link	href="<? echo $configuracion["host"] . $configuracion["site"] . $configuracion["bloques"] ?>/nomina/cuotas_partes/formHistoria/form_estilo.css"	rel="stylesheet" type="text/css" />
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#fecha_ingreso").datepicker(
                    {
                        changeMonth: true,
                        changeYear: true,
                        yearRange: '1920:2015',
                        dateFormat: 'dd/mm/yy'
                    }
            );

        });

        $(document).ready(function() {
            $("#fecha_salida").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '1920:2015',
                dateFormat: 'dd/mm/yy'
            });
        });
    </script>
</head>



<body>

    <form id="form" method="post" action="<? echo $configuracion["host"] . $configuracion["site"] . $configuracion["bloques"] ?>/nomina/cuotas_partes/formHistoria/html.class.php">
        <h1>Formulario de Registro Historia Laboral Pensionado CP</h1>
        <div class="formrow f1">
            <div id="p1f1" class="field n1">
                <div class="staticcontrol"><span class="wordwrap"><span class="pspan arial" style="text-align: left; font-size:14px;"><span class="ispan" style="color:#000099" xml:space="preserve">INFORMACIÓN BÁSICA</span><span class="ispan" style="color:#EE3D23" xml:space="preserve"> </span></span></span></div>
                <div class="null"></div>
            </div>
            <div class="null"></div>
        </div>

        <div class="formrow f1">
            <div id="p1f2" class="field n1">
                <div class="caption capleft alignleft">
                    <label class="fieldlabel" for="p1f2c"><span><span class="pspan arial" style="text-align:left;font-size:14px;"><span class="ispan" style="color:#9393FF" xml:space="preserve">Cédula Pensionado</span></span></span></label>
                    <div class="null"></div>
                </div>
                <div>
                    <input type="text" id="p1f2c" name="cedula_emp" class="fieldcontent">

                </div>
            </div>

            <div class="formrow f1">
                <div id="p1f4" class="field n1">
                    <div class="staticcontrol">
                        <div class="hrcenter px1"></div>
                    </div>
                    <div class="null"></div>
                </div>
                <div class="null"></div>
            </div>
            <div class="formrow f1">
                <div id="p1f5" class="field n1">
                    <div class="staticcontrol"><span class="wordwrap"><span class="pspan arial" style="text-align: left; font-size:14px;"><span class="ispan" style="color:#000099" xml:space="preserve">REGISTRO ENTIDAD</span><span class="ispan" style="color:#EE3D23" xml:space="preserve"> </span></span></span></div>
                    <div class="null"></div>
                </div>
                <div class="null"></div>
            </div>
            <div class="formrow f1">
                <div id="p1f6" class="field n1">
                    <div class="caption capleft alignleft">
                        <label class="fieldlabel" for="p1f6c"><span><span class="pspan arial" style="text-align:left;font-size:14px;"><span class="ispan" style="color:#9393FF" xml:space="preserve">Nit Entidad</span></span></span></label>
                        <div class="null"></div>
                    </div>
                    <div class="control capleft">
                        <div>
                            <input type="text" id="p1f6c" name="nit_entidad" class="fieldcontent">

                        </div>
                        <div class="null"></div>
                    </div>
                    <div class="null"></div>
                </div>
                <div class="null"></div>
            </div>
            <div class="formrow f1">
                <div id="p1f7" class="field n1">
                    <div class="caption capleft alignleft">
                        <label class="fieldlabel" for="p1f7c"><span><span class="pspan arial" style="text-align:left;font-size:14px;"><span class="ispan" style="color:#9393FF" xml:space="preserve">Nombre Entidad</span></span></span></label>
                        <div class="null"></div>
                    </div>
                    <div class="control capleft">
                        <div>
                            <input type="text" id="p1f7c" name="nombre_entidad" class="fieldcontent">

                        </div>
                        <div class="null"></div>
                    </div>
                    <div class="null"></div>
                </div>
                <div class="null"></div>
            </div>
            <div class="formrow f1">
                <div id="p1f8" class="field n1">
                    <div class="caption capleft alignleft">
                        <label class="fieldlabel" for="p1f8c"><span><span class="pspan arial" style="text-align:left;font-size:14px;"><span class="ispan" style="color:#9393FF" xml:space="preserve">Dirección</span></span></span></label>
                        <div class="null"></div>
                    </div>
                    <div class="control capleft">
                        <div>
                            <input type="text" id="p1f8c" name="direccion" class="fieldcontent">

                        </div>
                        <div class="null"></div>
                    </div>
                    <div class="null"></div>
                </div>
                <div class="null"></div>
            </div>
            <div class="formrow f1">
                <div id="p1f9" class="field n1">
                    <div class="caption capleft alignleft">
                        <label class="fieldlabel" for="p1f9c"><span><span class="pspan arial" style="text-align:left;font-size:14px;"><span class="ispan" style="color:#9393FF" xml:space="preserve">Ciudad</span></span></span></label>
                        <div class="null"></div>
                    </div>
                    <div class="control capleft">
                        <div>
                            <input type="text" id="p1f9c" name="ciudad" class="fieldcontent">

                        </div>
                        <div class="null"></div>
                    </div>
                    <div class="null"></div>
                </div>
                <div class="null"></div>
            </div>
            <div class="formrow f1 f2">
                <div id="p1f10" class="field n1">
                    <div class="caption capleft alignleft">
                        <label class="fieldlabel" for="fecha_ingreso"><span><span class="pspan arial" style="text-align:left;font-size:14px;"><span class="ispan" style="color:#9393FF" >Fecha Ingreso</span></span></span></label>
                        <div class="null"></div>
                    </div>
                    <div class="control capleft">
                        <div>
                            <input type="text" id="fecha_ingreso" name="fecha_ingreso" >


                        </div>
                        <div class="null"></div>
                    </div>
                    <div class="null"></div>
                </div>

                <div id="p1f11" class="field n2">
                    <div class="caption capleft alignleft">
                        <label class="fieldlabel" for="p1f11c"><span><span class="pspan arial" style="text-align:left;font-size:14px;"><span class="ispan" style="color:#9393FF" >Fecha Retiro</span></span></span></label>
                        <div class="null"></div>
                    </div>


                    <div class="control capleft">
                        <div>
                            <input type="text" id="fecha_salida" name="fecha_salida">

                        </div>
                        <div class="null"></div>
                    </div>
                    <div class="null"></div>
                </div>
                <div class="null"></div>
            </div>
            <div class="formrow f1">
                <div id="p1f12" class="field n1">
                    <div class="caption capleft alignleft">
                        <label class="fieldlabel" for="p1f12c"><span><span class="pspan arial" style="text-align:left;font-size:14px;"><span class="ispan" style="color:#9393FF" xml:space="preserve">Mesada de Pensión</span></span></span></label>
                        <div class="null"></div>
                    </div>
                    <div class="control capleft">
                        <div>
                            <input type="text" id="p1f12c" name="mesada" class="fieldcontent">

                        </div>
                        <div class="null"></div>
                    </div>
                    <div class="null"></div>
                </div>
                <div class="null"></div>
            </div>
            <div class="null"></div>
            <center> <input id="registrarBoton" type="submit" class="navbtn"  value="Registrar"></center>

        </div>



    </form>
</body>
</html>



