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

        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/dbms.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/sesion.class.php");
        include_once($this->configuracion["raiz_documento"] . $this->configuracion["clases"] . "/encriptar.class.php");
        $this->formulario = "cuentaCobro";
        ?>


        <form method='POST' action='index.php' name='<? echo $this->formulario; ?>'>
            <br>
            <br>
            <h2>Ingrese la cédula a realizar la cuenta de cobro: </h2>
            <br>
            <input type="text" name="cedula_emp">
            <br>
            <center> <input id="registrarBoton" type="submit" class="navbtn"  value="Consultar" ></center>
            <input type='hidden' name='pagina' value='cuentaCobro'>
            <input type='hidden' name='opcion' value='verificar'>

            <br>
        </form>


        <?
    }

    function form_cuenta_cobro($datos_entidad, $datos, $datos_p, $acumulado) {


        //var_dump($datos_entidad);
        //var_dump($datos_p);

        $cedula_emp = (isset($datos[0]['cedula_emp']) ? $datos[0]['cedula_emp'] : '');
        $entidad = (isset($datos[0]['entidad']) ? $datos[0]['entidad'] : '');
        $mesada1 = (isset($datos[0]['mesada']) ? $datos[0]['mesada'] : '');

        $porcentaje_c = (isset($datos_entidad[2]['porcentaje_cuota']) ? $datos_entidad[2]['porcentaje_cuota'] : '');
        $fecha_ingreso = (isset($datos_entidad[2]['fecha_ingreso']) ? $datos_entidad[2]['fecha_ingreso'] : '');
        $fecha_salida = (isset($datos_entidad[2]['fecha_salida']) ? $datos_entidad[2]['fecha_salida'] : '');

        $nombre_p = (isset($datos_p[0]['EMP_NOMBRE']) ? $datos_p[0]['EMP_NOMBRE'] : '');
        $fecha_p = (isset($datos_p[0]['EMP_FECHA_PEN']) ? $datos_p[0]['EMP_FECHA_PEN'] : '');
        ?>
        <table class="bordered" width ="100%" align="center">
            <tr>
                <th colspan="6" class="estilo_th">DATOS PENSIONADO</th>
            </tr>

            <tr>

                <td class='texto_elegante estilo_td' >Nombre:</td>
                <td class='texto_elegante estilo_td'><? echo $nombre_p ?></td>
                <td class='texto_elegante estilo_td' >Cedula Pensionado:</td>
                <td class='texto_elegante estilo_td' ><? echo $cedula_emp ?></td>
                <td class='texto_elegante estilo_td' >Fecha Pensión:</td>
                <td class='texto_elegante estilo_td'><? echo $fecha_p ?></td>
            </tr>
            <tr>
                <td class='texto_elegante estilo_td' >Valor Primera Mesada:</td>
                <td class='texto_elegante estilo_td'><? echo "$ " . number_format($mesada1) ?></td>
            </tr>

        </table>


        <table class='bordered'  width ="100%" >
            <tr>
                <th colspan="6" class="estilo_th">DATOS ENTIDAD EXTERNA</th>
            </tr>
            <tr>
                <td class='texto_elegante estilo_td' >Entidad externa:</td>
                <td class='texto_elegante estilo_td' ><? echo $entidad ?></td>
                <td class='texto_elegante estilo_td' >Cuota Parte Porcentaje:</td>
                <td class='texto_elegante estilo_td' ><? echo $porcentaje_c . '%' ?></td>
            </tr>

            <tr>
                <td class='texto_elegante estilo_td' >Fecha inicio contrato:</td>
                <td class='texto_elegante estilo_td' ><? echo $fecha_ingreso ?></td>
                <td class='texto_elegante estilo_td' >Fecha final contrato:</td>
                <td class='texto_elegante estilo_td' ><? echo $fecha_salida ?></td>
            </tr>
        </table>

        <table class='bordered'  width ="100%" >
            <tr>
                <th colspan="8" class="estilo_th">VALORES CALCULADOS DE CUOTAS MES A MES</th>
            </tr>
            <tr>
                <td class='texto_elegante estilo_td' >FECHA DE PAGO</td>
                <td class='texto_elegante estilo_td' >MESADA</td>
                <td class='texto_elegante estilo_td' >AJUSTE</td>
                <td class='texto_elegante estilo_td' >MESADA ADICIONAL</td>
                <td class='texto_elegante estilo_td' >INCREMENTO</td>
                <td class='texto_elegante estilo_td' >VALOR CUOTA</td>
                <td class='texto_elegante estilo_td' >TOTAL MES</td>

            </tr>

            <?
            foreach ($datos as $key => $dato) {
                $fecha_pago = (isset($dato['fecha_pago']) ? $dato['fecha_pago'] : '');
                $mesada = (isset($dato['mesada']) ? $dato['mesada'] : '');
                $ajuste = (isset($dato['ajuste_pension']) ? $dato['ajuste_pension'] : '');
                $mesada_adicional = (isset($dato['mesada_adicional']) ? $dato['mesada_adicional'] : '');
                $incremento = (isset($dato['incremento_salud']) ? $dato['incremento_salud'] : '');
                $valor_cuota = (isset($dato['valor_cuota']) ? $dato['valor_cuota'] : '');
                $total_mes = (isset($dato['total_mes']) ? $dato['total_mes'] : '');
                echo "<tr>";
                echo "<td class='texto_elegante estilo_td' >" . $fecha_pago . "</td>";
                echo "<td class='texto_elegante estilo_td' >" . number_format($mesada) . "</td>";
                echo "<td class='texto_elegante estilo_td' >" . number_format($ajuste) . "</td>";
                echo "<td class='texto_elegante estilo_td' >" . number_format($mesada_adicional) . "</td>";
                echo "<td class='texto_elegante estilo_td' >" . number_format($incremento) . "</td>";
                echo "<td class='texto_elegante estilo_td' >" . number_format($valor_cuota) . "</td>";
                echo "<td class='texto_elegante estilo_td' >" . number_format($total_mes) . "</td>";
                echo "</tr>";
            }
            ?>



            <?
            $total_mayo = (isset($acumulado[0]['round']) ? $acumulado[0]['round'] : '');
            $fecha_actual = (isset($acumulado[0]['fecha']) ? $acumulado[0]['fecha'] : '');
            ?>


        </table>

        <table class='bordered'  width ="100%" >
            <tr>
                <th colspan="6" class="estilo_th">TOTALES ACUMULADOS</th>
            </tr>

            <tr>
                <td class='texto_elegante<? echo '' ?> estilo_td' >Entidad que genera:</td>
                <td class='texto_elegante estilo_td' ><? echo 'Universidad Distrital Francisco José de Caldas' ?></td>
                <td class='texto_elegante<? echo '' ?> estilo_td' >Nit entidad generadora:</td>
                <td class='texto_elegante estilo_td' ><? echo '899999230-7' ?></td>
            </tr>

            <tr>
                <td class='texto_elegante estilo_td' >Cuota Acumulada a la fecha:</td>
                <td class='texto_elegante estilo_td' ><? echo "$ " . number_format($total_mayo) ?></td>
                <!--td class='texto_elegante estilo_td' >Incrementos Acumulados a la fecha:</td>
                <td class='texto_elegante estilo_td' ><? echo '' ?></td-->
            </tr>

            <tr>
                <td class='texto_elegante estilo_td' >Fecha de generación:</td>
                <td class='texto_elegante estilo_td' ><? echo $fecha_actual ?></td>
            </tr>

        </table>






        <?
    }

}
?>
