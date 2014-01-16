<?php
error_reporting(E_ALL);
ini_set("display_startup_errors", true);
ini_set("display_errors", "On");

$ociExists = (function_exists("oci_connect")) ? "SI" : "NO";
$ocipExists = (function_exists("oci_pconnect")) ? "SI" : "NO";

echo "<br/>OCI EXISTS: $ociExists";
echo "<br/>OCI P EXISTS: $ocipExists";


// Conectar al servicio XE (es deicr, la base de datos) en la máquina "localhost"
$tnsname = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
            (HOST = 192.168.0.3)(PORT = 1521))
            (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = GGEST.CORMUP.CL)))';

$conn = oci_connect('rrhh', 'intranet.cormup', $tnsname);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid = oci_parse($conn, 'SELECT * FROM afp');
oci_execute($stid);

echo "<h1>TESTING OCI</h1>";
echo "<table border='1'>\n";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
    foreach ($row as $item) {
        echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
    }
    echo "</tr>\n";
}
echo "</table>\n";

?>