<head>
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

  

    $user = 'postgres';
    $passwd = '';
    $db = 'cuotas_partes2';
    $port = 5432;
    $host = '10.20.2.101';
    $strCnx = "host=$host port=$port dbname=$db user=$user password=$passwd";
    $cnx = pg_connect($strCnx) or die("Error de conexion. " . pg_last_error());
    $set = pg_exec($cnx, "SET DATESTYLE TO postgres, dmy");

    if ($_POST) {
        $result = pg_query($cnx, "INSERT INTO entidades_cp VALUES ('$_REQUEST[cedula_emp]','$_REQUEST[nit_entidad]','$_REQUEST[nombre_entidad]','$_REQUEST[direccion]','$_REQUEST[ciudad]',to_date('$_REQUEST[fecha_ingreso]','dd-mm-yyyy'),to_date('$_REQUEST[fecha_salida]','dd-mm-yyyy'))");
        if (!$result) {
            echo "Query: Un error ha occurido.\n";
            exit;
        }
    }
    if ($_POST)
        ?>
        <script language="javascript">    window.location.href = "http://10.20.2.101/gefad/index.php?gefad=8AFKwH5on1HdyirSxdw7WjjruINZyzXCoQCRk8vRvnXs6RySeT8"</script>
    ?>