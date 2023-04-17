<?php

$host = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "grab_a_cut";

$dbconn = new mysqli(hostname: $host, 
                     username:$dBUsername,
                     password: $dBPassword, 
                     database: $dBName);

if ($dbconn-> connect_errno) {
    echo "Failed to connect to MySQL: " . $dbconn->connect_error;
}
 return $dbconn;