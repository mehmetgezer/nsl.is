<?php
date_default_timezone_set('Europe/Istanbul');
/**
 * Created by JetBrains PhpStorm.
 * User: AliRiza
 * Date: 22.12.2012
 * Time: 14:27
 * To change this template use File | Settings | File Templates.
 */
error_reporting(0);
require 'source/getmetatag.php';
$url = $_POST['url'];
if (strpos($url, 'http') !== 0) {
    $url = "http://".$url;
}
$url = str_replace("https","http",$url);
$tr = array('\u00fc','\u011f','\u0131','\u015f','\u00e7','\u00f6','\u00dc','\u011e','\u015e','\u00c7','\u00d6');
$eng = array('ü','ğ','ı','ş','ç','ö','Ü','Ğ','Ş','Ç', 'Ö');
echo str_replace($tr,$eng,getMetaTagAsJson(str_replace("%26","&",$url)));