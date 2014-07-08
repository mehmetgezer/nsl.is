<?php
date_default_timezone_set('Europe/Istanbul');
include("source/Connection.php");
require "service/types/LinkType.php";
require "source/Scripts.php";

$conn = new Connection();
$conn->connectToDatabase();
$conn->selectDatabase();

$resultArray = array();
session_start();
if(isset($_SESSION["login"])){
    $result = mysql_query("select p.id as sh,p.click_count as cc, p.url as uu, p.title as tt from path p,  user_path up ,user u where u.id = '".$_SESSION["userid"]."' and u.ID = up.USER_ID and up.PATH_ID = p.ID order by up.ID desc limit 10;");

    while ($row=mysql_fetch_assoc($result,MYSQL_BOTH)) {
        $item = new LinkType();
        $item->clickCount=$row["cc"];
        $item->id=$row["sh"];
        $item->link=get_base_url().$row["sh"];
        $item->url=$row["uu"];
        $item->faviconUrl="http://www.fvicon.com/".$row["uu"];
        $item->chartUrl=get_base_url()."chart.php?pathId=".$row["sh"];
        if(strlen($row["tt"])<75)
            $item->title=$row["tt"];
        else
            $item->title=substr($row["tt"],0,75)."...";
        array_push($resultArray,$item);
    }

}else{
    if (!isset($_COOKIE["NSL-ID"])){
        $username = md5(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
        setcookie("NSL-ID[0]",$username,time() + (20 * 365 * 24 * 60 * 60));
        $sql = mysql_query("insert into user(username, password,email) values ('".$username."','123456','guestUser@nsl.is')");
        $id=mysql_insert_id();
        setcookie("NSL-ID[1]",$id,time() + (20 * 365 * 24 * 60 * 60));
        if($sql){
            $conn->closeConnection();
        }
    }else{
        $result = mysql_query("select p.id as sh,p.click_count as cc, p.url as uu, p.title as tt from path p,  user_path up ,user u where u.id = '".$_COOKIE["NSL-ID"][1]."' and u.ID = up.USER_ID and up.PATH_ID = p.ID order by up.ID desc limit 10;");
        while ($row=mysql_fetch_assoc($result,MYSQL_BOTH)) {
            $item = new LinkType();
            $item->clickCount=$row["cc"];
            $item->id=$row["sh"];
            $item->link=get_base_url().$row["sh"];
            $item->url=$row["uu"];
            $item->faviconUrl="http://www.fvicon.com/".$row["uu"];
            $item->chartUrl=get_base_url()."chart.php?pathId=".$row["sh"];
            if(strlen($row["tt"])<75)
                $item->title=$row["tt"];
            else
                $item->title=substr($row["tt"],0,75)."...";
            array_push($resultArray,$item);
        }
    }
}

echo json_encode($resultArray);
