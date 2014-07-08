<?php
date_default_timezone_set('Europe/Istanbul');
include ('source/Connection.php');
$connection = new Connection(); //i created a new object
$connection->connectToDatabase(); // connected to the database
$connection->selectDatabase();// closed connection


$result = mysql_query("select referer as r ,count(referer) as cr from log_meta where path_id = '".$_GET['path_id']."' group by referer ");

while($row = mysql_fetch_array($result)) {
    echo $row['r'] . "\t" . $row['cr']. "\n";
}
//
//echo "Safari"."\t"."53"."\n"."Opera"."\t"."47";