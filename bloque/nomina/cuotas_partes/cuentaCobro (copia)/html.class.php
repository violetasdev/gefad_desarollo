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
}

class html_adminCuentaCobro {

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

    function form_valores_cuotas_partes() {

        include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/dbms.class.php");
        include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/sesion.class.php");
        include_once($configuracion["raiz_documento"] . $configuracion["clases"] . "/encriptar.class.php");
        $this->formulario = "cuentaCobro";
        ?>


            <link href="<? echo $configuracion["host"] . $configuracion["site"] . $configuracion["bloques"] ?>/nomina/cuotas_partes/formHistoria/form_estilo.css"	rel="stylesheet" type="text/css" />


            <form enctype='multipart/form-data' method='POST' action='index.php' name='<? echo $this->formulario; ?>'>
                <h1>Ingrese la cédula a realizar la cuenta de cobro: </h1>
                <br>
                <input type="text" name="cedula_emp">
                <br>
                <center> <input id="registrarBoton" type="submit" class="navbtn"  value="Consultar"></center>
                <input type='hidden' name='pagina' value='cuentaCobro'>
                <input type='hidden' name='action' value='cuentaCobro'>
                <input type='hidden' name='opcion' value='verificar'>

                <br>
            </form>

   
        <?
    }


}
?>
