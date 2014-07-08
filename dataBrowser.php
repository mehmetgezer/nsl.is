<?php
date_default_timezone_set('Europe/Istanbul');
include ('source/Connection.php');
$connection = new Connection(); //i created a new object
$connection->connectToDatabase(); // connected to the database
$connection->selectDatabase();// closed connection


$result = mysql_query("select user_agent as ua,count(user_agent) as cua from log_meta where path_id = '".$_GET['path_id']."' group by user_agent ");

while($row = mysql_fetch_array($result)) {
    echo $row['ua'] . "\t" . $row['cua']. "\n";
}
//
//echo "Safari"."\t"."53"."\n"."Opera"."\t"."47";