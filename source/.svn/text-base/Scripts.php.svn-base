<?php
/**
 * Created by JetBrains PhpStorm.
 * User: AliRiza
 * Date: 14.12.2012
 * Time: 21:08
 * To change this template use File | Settings | File Templates.
 */

function get_base_url()
{
    /* First we need to get the protocol the website is using */
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';

    /* returns /myproject/index.php */
    $path = $_SERVER['PHP_SELF'];

    /*
    * returns an array with:
    * Array (
    *  [dirname] => /myproject/
    *  [basename] => index.php
    *  [extension] => php
    *  [filename] => index
    * )
    */
    $path_parts = pathinfo($path);
    $directory = $path_parts['dirname'];
    /*
    * If we are visiting a page off the base URL, the dirname would just be a "/",
    * If it is, we would want to remove this
    */
    //$directory = ($directory == "/") ? "" : $directory;

    $chars = explode("/",$directory);

    /* Returns localhost OR mysite.com */
    $host = $_SERVER['HTTP_HOST'];
    if($host == "localhost"){
        $directory = "/".$chars[1];
    }
    else{
        $directory = "/";
    }
    /*
    * Returns:
    * http://localhost/mysite
    * OR
    * https://mysite.com
    */
    if(endsWith($directory,"/"))
        return $protocol . $host . $directory;
    else
        return $protocol . $host . $directory."/";
}

function endsWith( $str, $sub ) {
    return ( substr( $str, strlen( $str ) - strlen( $sub ) ) == $sub );
}

function urlIsValid($url){
    $headers = @get_headers($url);
    if(strpos($headers[0],'200')===false)return false;
    else return true;
}