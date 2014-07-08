<?php
date_default_timezone_set('Europe/Istanbul');
include ('source/Connection.php');
include ('utils.php');
$connection = new Connection(); //i created a new object
$connection->connectToDatabase(); // connected to the database
$connection->selectDatabase();// closed connection
$pathId = $_GET['l'];
$result = mysql_query("select s.url,s.click_count from path s where s.id = '".$pathId."'");
$remoteIp=$_SERVER['REMOTE_ADDR'];
if(isset($_SERVER['HTTP_REFERER'])){
    $httpReferer = parse_url($_SERVER['HTTP_REFERER']);
    $referer=$httpReferer["host"];
}else{
    $referer="Direct";
}
$array = json_decode(file_get_contents('http://api.hostip.info/get_json.php?ip='.$_SERVER['REMOTE_ADDR']));
$row = mysql_fetch_row($result, MYSQL_NUM);
$browser = getBrowser();
if(!empty($row)){

    if(!strpos($_SERVER['HTTP_USER_AGENT'], 'facebookexternalhit')){
        $row[1] = $row[1]+1;
        $sql = mysql_query("update path p set p.click_count =".$row[1]." where p.id ='".$pathId."'");

        $date = new DateTime();
        $date->sub(new DateInterval('P10D'));

        $sql2 = mysql_query("insert into log_meta (path_id,referer,country,country_code,time,user_agent,mobile,ip) values ('".$pathId."','".$referer."','".$array->{'country_name'}."','".$array->{'country_code'}."',NOW(),'".$browser["name"]."','".$browser["mobile"]."','".$remoteIp."')");
    }

    echo "<!DOCTYPE html><html lang='tr'><head>";
    if (strpos($row[0], 'http') === 0) {
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: '.$row[0]);
        die();
        //echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$row[0]."\">";
    }else{
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: http://'.$row[0]);
        die();
        //echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://".$row[0]."\">";
    }
    $sql23 = mysql_query("select * from open_graph_meta where path_id = '".$pathId."'");
    while ($row=mysql_fetch_assoc($sql23,MYSQL_BOTH)) {
        echo "<meta property=\"og:".$row["tag_key"]."\" content=\"".$row["tag_value"]."\">";
    }
    echo "</head><body></body></html>";
    $connection->closeConnection();
}else{
    header('location: index.php');
}
