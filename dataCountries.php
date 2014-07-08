<?php
date_default_timezone_set('Europe/Istanbul');
include ('source/Connection.php');
$connection = new Connection(); //i created a new object
$connection->connectToDatabase(); // connected to the database
$connection->selectDatabase();// closed connection


$result = mysql_query("select country as c ,count(country) as cc from log_meta where path_id = '".$_GET['path_id']."' group by country ");

while($row = mysql_fetch_array($result)) {
    echo $row['c'] . "\t" . $row['cc']. "\n";
}
//
//echo "Safari"."\t"."53"."\n"."Opera"."\t"."47";