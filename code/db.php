<?php

$serverName = "DESKTOP-FCQJEHS";
$connectionInfo = array( "Database"=>"CarWash");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if(!$conn)
{
    echo "Connection could not be established.\n";
    die( print_r( sqlsrv_errors(), true));
}

?>