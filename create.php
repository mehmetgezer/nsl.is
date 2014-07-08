<?php
date_default_timezone_set('Europe/Istanbul');
include("source/Connection.php");
include("source/Scripts.php");
require "source/getmetatag.php";
require "service/types/LinkType.php";

$conn = new Connection();
$conn->connectToDatabase();
$conn->selectDatabase();
$url = $_POST['url'];

echo getLink($url,$conn);

function getLink($url,$conn){
    session_start();
    if(isset($_SESSION["login"])){
        $userName =$_SESSION["userid"];
    }else{
        $userName =  $_COOKIE["NSL-ID"][1];
    }
    $remoteIp=$_SERVER['REMOTE_ADDR'];

    if(!isset($_SESSION["login"])){

        $result = mysql_query("select s.click_count, s.id from path s where s.url like '%".$url."' and s.anonymous = 1");
        $row = mysql_fetch_row($result, MYSQL_NUM);

        if (!empty($row)) {

            $result = mysql_query("select up.id from user_path up where up.user_id = '".$userName."' and up.path_id = '".$row[1]."'");
            $rowUserPath = mysql_fetch_row($result, MYSQL_NUM);
            if(empty($rowUserPath)){
                $sql = mysql_query("insert into user_path (path_id, user_id,ip) values ('".$row[1]."','".$userName."','".$remoteIp."')");
            }
            $conn->closeConnection();
            $response = "{";
            $response = $response."\"link\":\"".get_base_url().$row[1]."\"";
            $response = $response.",\"clickCount\":\"".$row[0]."\"";
            $response = $response."}";
            return $response;

        }else{
            try{

                $urlCode = generatePassword();
                $title = '';
                $graph = fetchOpenGraphMeta($url);
                $sql = mysql_query("delete from open_graph_meta where path_id = '".$urlCode."'");
                if($graph !== false){
                    foreach ($graph as $key => $val) {
                        if($key =='title'){
                            $title=$val;
                        }
                        $sql = mysql_query("insert into open_graph_meta(path_id,tag_key,tag_value) values ('".$urlCode."','".$key."','".$val."');");
                    }
                }
                if($title==''){
                    $title=mysql_real_escape_string(getMetaTag($url)->title);
                }
                $sql = mysql_query("insert into path(id,url,time,ip,title) values ('".$urlCode."','".$url."',NOW(),'".$remoteIp."','".$title."');");
                if($sql){
                    $sql = mysql_query("insert into user_path (path_id, user_id,ip,country_code) values ('".$urlCode."','".$userName."','".$remoteIp."','unknown')");


                    if($sql){
                        $conn->closeConnection();
                        $response = new LinkType();
                        $response->link = get_base_url().$urlCode;
                        $response->clickCount = "0";
                        return json_encode($response);
                    }
                }else{
                    return "{\"link\":\"".'Error. Try again :('."\"}";
                }
                //echo "<a href='".$urlCode."'>".$urlCode."</a>";
            }catch (Exception $e){
            }
        }
    }else{
        try{
            $urlCode = generatePassword();
            $title = mysql_real_escape_string(getMetaTag($url)->title);
            $sql = mysql_query("insert into path(id, url,time,ip,title,anonymous) values ('".$urlCode."','".$url."',NOW(),'".$remoteIp."','".$title."',0)");
            if($sql){
                if(isset($_SESSION["login"])){
                    $userName =$_SESSION["userid"];
                }
                $graph = fetchOpenGraphMeta($url);
                $sql = mysql_query("delete from open_graph_meta where path_id = '".$urlCode."'");
                if($graph !== false){
                    foreach ($graph as $key => $value) {
                        $sql = mysql_query("insert into open_graph_meta(path_id,tag_key,tag_value) values ('".$urlCode."','".$key."','".$value."');");
                    }
                }
                $sql = mysql_query("insert into user_path (path_id, user_id,ip,country_code) values ('".$urlCode."','".$userName."','.$remoteIp.','unknown')");
                if($sql){
                    $conn->closeConnection();
                    $response = new LinkType();
                    $response->link = get_base_url().$urlCode;
                    $response->clickCount = "0";
                    return json_encode($response);
                }
            }else{
                return "{\"link\":\"".'Error. Try again :('."\"}";
            }
        }catch (Exception $e){
        }
    }
}

function generatePassword ($length = 5)
{
    $password = "";
    $possible = "0123456789abcdefghijklmnopqrstuvwxyzABCDFGHIJKLMNOPQRSTUVWXYZ";

    $maxlength = strlen($possible);

    if ($length > $maxlength) {
        $length = $maxlength;
    }

    $i = 0;

    while ($i < $length) {
        $char = substr($possible, mt_rand(0, $maxlength-1), 1);
        if (!strstr($password, $char)) {
            $password .= $char;
            $i++;
        }
    }
    return $password;

}

