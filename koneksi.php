<?php
    date_default_timezone_set('Asia/Jakarta');
    $host           = "10.0.0.174";
    $username       = "ditprogram";
    $password       = "Xou@RUnivV!6";
    $db_name        = "TM";
    $connInfo       = array("Database" => $db_name, "UID" => $username, "PWD" => $password);
    $conn           = sqlsrv_connect($host, $connInfo);
    $con            = mysqli_connect("10.0.0.10", "dit", "4dm1n", "db_finishing");
    //$con          = mysqli_connect("localhost", "root", "", "db_finishing");

    $hostname       = "10.0.0.21";
    $database       = "NOWPRD";
    $user           = "db2admin";
    $passworddb2    = "Sunkam@24809";
    $port           = "25000";
    $conn_string    = "DRIVER={IBM ODBC DB2 DRIVER}; HOSTNAME=$hostname; PORT=$port; PROTOCOL=TCPIP; UID=$user; PWD=$passworddb2; DATABASE=$database;";
    $conn_db2   = db2_connect($conn_string, '', '');
?>