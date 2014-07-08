<?php
date_default_timezone_set('Europe/Istanbul');
include ('source/Connection.php');
$connection = new Connection(); //i created a new object
$connection->connectToDatabase(); // connected to the database
$connection->selectDatabase();// closed connection


$result = mysql_query("select DATE_FORMAT(time, '%Y-%m-%d') as t ,count(time) as ct from log_meta where path_id = '".$_GET['path_id']."' group by DATE_FORMAT(time, '%Y-%m-%d')");

while($row = mysql_fetch_array($result)) {
    echo $row['t'] . "\t" . $row['ct']. "\n";
}
//
//echo "Safari"."\t"."53"."\n"."Opera"."\t"."47";