<?php

require '../source/Connection.php';
require '../lib/Slim/Slim.php';
require 'types/LinkType.php';
require '../source/Scripts.php';
require '../source/authorize/Authorize.php';
require '../source/login/Login.php';
require '../source/authorize/types/Link.php';
require '../source/authorize/types/ErrorOnGetLongUrl.php';
require '../source/authorize/types/ErrorOnGetShortUrl.php';
include '../source/getmetatag.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(array('debug' => true));

$app->post('/link', 'createLink');
$app->post('/link', 'getFavicon');
//$app->get('/link/:id', 'getLink');
$app->post('/signup/validate','signupValidate');
$app->post('/login/validate','loginValidate');
$app->post('/login','login');
$app->post('/login/user/:username','changePassword');
$app->get('/authorize/client','addClientPage');
$app->post('/authorize/client/:userid','addClientService');
$app->put('/authorize/client/:client_id','refreshClientSecret');
$app->get('/authorize/client/apikey/:client_id/:client_secret','getKey');
$app->put('/authorize/client/apikey/:client_id','refreshApiKey');
$app->get('/authorize','getAuthorizePage');
$app->post('/authorize','performAuthorize');
$app->get('/link/shorten','shortLink');
$app->get('/link/expand','longLink');
$app->run();

function createLink(){
    $request = \Slim\Slim::getInstance()->request();
    $conn = new Connection();
    $params = json_decode($request->getBody());

    $sql = "insert into path(url, short_url,time,ip) values (:url,:short_url,:time,:ip)";
    $db = $conn->getDbSource();

    $urlCode = generatePassword();
    $result = new LinkType();
    try{
        $stmt = $db->prepare($sql);
        $stmt->bindParam("url", $params->url);
        $stmt->bindParam("short_url", $urlCode);
        $stmt->bindParam("time", "NOW()");
        $stmt->bindParam("ip", $_SERVER['REMOTE_ADDR']);
        $stmt->execute();

        $result = new LinkType();
        $result->link = $urlCode;
        $result->clickCount = "0";
    }
    catch(PDOException $e){
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    echo json_encode($result);
};

function getLink($id){
    $conn = new Connection();
    $conn->connectToDatabase();
    $conn->selectDatabase();
    $result = mysql_query("select s.short_url,s.click_count from path s where s.short_url like '%".$id."'");
    //$result = mysql_query("select count(*) from path");
    $row = mysql_fetch_row($result, MYSQL_BOTH);

    $result = new LinkType();
    $result->link = $row[0];
    $result->clickCount = $row[1];
    echo json_encode($result);
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

function getFavicon () {
    $request = \Slim\Slim::getInstance()->request();
    //$params = json_decode($request->getBody());
    $url=$request->getBody();//$params->url;
    $file_headers = @get_headers($url);
    $found = FALSE;
    // 1. CHECK THE DOM FOR THE <link> TAG
    // check if the url exists - if the header returned is not 404
    if($file_headers[0] != 'HTTP/1.1 404 Not Found') {
        $dom = new DOMDocument();
        $dom->strictErrorChecking = FALSE;
        @$dom->loadHTMLfile($url);  //@ to discard all the warnings of malformed htmls
        if (!$dom) {
            $error[]='Error parsing the DOM of the file';
        } else {
            $domxml = simplexml_import_dom($dom);
            //check for the historical rel="shortcut icon"
            if ($domxml->xpath('//link[@rel="shortcut icon"]')) {
                $path = $domxml->xpath('//link[@rel="shortcut icon"]');
                $faviconURL = $path[0]['href'];
                $found == TRUE;
                return $faviconURL;
                //check for the HTML5 rel="icon"
            } else if ($domxml->xpath('//link[@rel="icon"]')) {
                $path = $domxml->xpath('//link[@rel="icon"]');
                $faviconURL = $path[0]['href'];
                $found == TRUE;
                return $faviconURL;
            } else {
                $error[]="The URL does not contain a favicon <link> tag.";
            }
        }

        // 2. CHECK DIRECTLY FOR favicon.ico OR favicon.png FILE
        // the two seem to be most common
        if ($found == FALSE) {
            $parse = parse_url($url);
            $favicon_headers = @get_headers("http://".$parse['host']."/favicon.ico");
            if($favicon_headers[0] != 'HTTP/1.1 404 Not Found') {
                $faviconURL = "/favicon.ico";
                $found == TRUE;
                return $faviconURL;
            }
            $favicon_headers = @get_headers("http://".$parse['host']."/favicon.png");
            if($favicon_headers[0] != 'HTTP/1.1 404 Not Found') {
                $faviconURL = "/favicon.png";
                $found == TRUE;
                return $faviconURL;
            }
            if ($found == FALSE) {
                $error[]= "Files favicon.ico and .png do not exist on the server's root.";
            }
        }
        // if the URL does not exists ...
    } else {
        $error[]="URL does not exist";
    }

    if ($found == FALSE && isset($error) ) {
        return $error;
    }
}

function signupValidate(){
    $conn = new Connection();
    $conn->connectToDatabase();
    $conn->selectDatabase();

    $request = \Slim\Slim::getInstance()->request();

    $email = json_decode($request->getBody())->email;

    $result = mysql_query("select c.email from user c where c.email='".$email."'");
    $row = mysql_fetch_row($result, MYSQL_NUM);
    if($row){
        echo "1";
    }
    else{
        echo "0";
    }
}

function loginValidate(){

    $request = \Slim\Slim::getInstance()->request();

    $email = json_decode($request->getBody())->email;
    $password = json_decode($request->getBody())->password;

    $conn = new Connection();
    $conn->connectToDatabase();
    $conn->selectDatabase();

    $result = mysql_query("select c.username, c.password, c.id from user c where c.email='".$email."' and c.password='".$password."'");
    $row = mysql_fetch_row($result, MYSQL_NUM);
    if (!empty($row)) {
        echo json_encode($row);
    }else{
        echo '0';
    }
}

function login(){
    /**
    $login = new Login();
    $jsonBody =  json_decode(\Slim\Slim::getInstance()->request()->getBody());
    $status = $login->login($jsonBody->userid, $jsonBody->password);
    header("Refresh: 0; url=".$_SERVER['HTTP_REFERER']);
     * **/
}

function addClientPage(){
    \Slim\Slim::getInstance()->render("../../pages/addClient.php");
}

function getKey($client_id,$client_secret){
    $request = \Slim\Slim::getInstance()->request();
    //$client_secret = json_decode($request->getBody())->client_secret;
    $conn = new Connection();
    $auth = new Authorize($conn->getDbSource());
    if(isset($_SERVER["HTTP_REFERER"])){
        $resp = $auth->getClient($client_id,$client_secret,$_SERVER["HTTP_REFERER"]);
        echo json_encode($resp);
    }
}

function addClientService($userid){
    $conn = new Connection();
    $auth = new Authorize($conn->getDbSource());
    echo json_encode($auth->addClient($userid));
}

function refreshApiKey($client_id){
    $conn = new Connection();
    $auth = new Authorize($conn->getDbSource());
    echo json_encode($auth->refreshApiKey($client_id));
}

function refreshClientSecret($client_id){
    $conn = new Connection();
    $auth = new Authorize($conn->getDbSource());
    echo json_encode($auth->refreshClienSecret($client_id));
}
function getAuthorizePage(){
    $request = \Slim\Slim::getInstance()->request();
    $login = new Login();
    $user = $login->getAnonymousUser();
    $params = $request->get();

    $queryParam="?";
    foreach ($params as $key => $value) {
        $queryParam = $queryParam.$key."=".$value."&";
    }
    $queryParam = substr($queryParam,0,strlen($queryParam)-1);
    echo file_get_contents(get_base_url()."../pages/authorize.php".$queryParam);
}

function performAuthorize(){
    $request = \Slim\Slim::getInstance()->request();
    $con=new Connection();
    $oauth = new OAuth2(new OAuth2StoragePDO($con->getDbSource()));
    $login = new Login();
    $user = $login->getAnonymousUser();
    $oauth->finishClientAuthorization($_POST["accept"] == "Yep", $user->username, $request->post());
}

function shortLink(){
    $request = \Slim\Slim::getInstance()->request();
    $params = $request->get();
    $apiKey= $request->headers('apiKey');
    $longUrl = $params["url"];
    if (strpos($longUrl, 'http') !== 0) {
        $longUrl = "http://".$longUrl;
    }
    //$client_secret = json_decode($request->getBody())->client_secret;
    $conn = new Connection();
    $remoteIp=$_SERVER['REMOTE_ADDR'];


    $auth = new Authorize($conn->getDbSource());

    if(isset($_SERVER["HTTP_REFERER"]) && $auth->checkApiKey($apiKey,$_SERVER["HTTP_REFERER"])){
        $validate = preg_match("/\b(?:(?:https?|ftp):\/\/|\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $longUrl);
        if(!$validate)
        {
            $status = new ErrorOnGetShortUrl();

            $status->status_code = 200;
            $status->status_txt = "OK";
            $status->long_url = $longUrl;
            $status->error="INVALID URL";
            echo json_encode($status);
            return;
        }
        $conn->connectToDatabase();
        $conn->selectDatabase();
        $result = mysql_query("select client_id from clients where apikey = '".$apiKey."' limit 1");
        $row = mysql_fetch_row($result, MYSQL_NUM);
        $client_id ="";
        if(!empty($row)){
            $client_id = $row[0];
        }else{
            $status = new ErrorOnGetShortUrl();

            $status->status_code = 200;
            $status->status_txt = "OK";
            $status->long_url = $longUrl;
            $status->error="INVALID APIKEY";
            echo json_encode($status);
            return;
        }
        try{

            $urlCode = generatePassword();
            $title = mysql_real_escape_string(getMetaTag($longUrl)->title);
            $sql = mysql_query("insert into path(id, url,time,ip,title,anonymous) values ('".$urlCode."','".$longUrl."',NOW(),'".$remoteIp."','".$title."',0)");

            if($sql){
                $graph = fetchOpenGraphMeta($longUrl);
                $sql = mysql_query("delete from open_graph_meta where path_id = '".$urlCode."'");
                if($graph !== false){
                    foreach ($graph as $key => $value) {
                        $sql = mysql_query("insert into open_graph_meta(path_id,tag_key,tag_value) values ('".$urlCode."','".$key."','".$value."');");
                    }
                }
                $sql = mysql_query("insert into user_path (path_id, user_id,ip,country_code) values ('".$urlCode."','".$client_id."','.$remoteIp.','unknown')");
                if($sql){
                    $conn->closeConnection();
                    $status = new Link();

                    $status->status_code = 200;
                    $status->status_txt = "OK";
                    $status->short_url = get_base_url().$urlCode;
                    $status->long_url=$longUrl;
                    echo json_encode($status);
                    return;
                }else{
                    $status = new ErrorOnGetShortUrl();

                    $status->status_code = 200;
                    $status->status_txt = "OK";
                    $status->long_url = $longUrl;
                    $status->error="UNEXPECTING ERROR";
                    echo json_encode($status);
                    return;
                }
            }else{
                $conn->closeConnection();
                $status = new ErrorOnGetShortUrl();

                $status->status_code = 200;
                $status->status_txt = "OK";
                $status->long_url = $longUrl;
                $status->error="UNEXPECTING ERROR";
                echo json_encode($status);
                return;
            }
        }catch (Exception $e){
            $status = new ErrorOnGetShortUrl();
            $status->status_code = 200;
            $status->status_txt = "OK";
            $status->long_url = $longUrl;
            $status->error="UNEXPECTING ERROR";
            echo json_encode($status);
            return;
        }


    }else{
        $status = new ErrorOnGetShortUrl();
        $status->status_code = 200;
        $status->status_txt = "OK";
        $status->long_url = $longUrl;
        $status->error="UNEXPECTING ERROR";
        echo json_encode($status);
        return;
    }

}

function longLink(){
    $request = \Slim\Slim::getInstance()->request();
    $params = $request->get();
    $apiKey= $request->headers('apiKey');
    $shortUrl = $params["url"];
    if (strpos($shortUrl, 'http') !== 0) {
        $shortUrl = "http://".$shortUrl;
    }
    //$client_secret = json_decode($request->getBody())->client_secret;
    $conn = new Connection();

    $auth = new Authorize($conn->getDbSource());
    if(isset($_SERVER["HTTP_REFERER"]) && $auth->checkApiKey($apiKey,$_SERVER["HTTP_REFERER"])){
        $validate = preg_match("/\b(?:(?:https?|ftp):\/\/|\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $shortUrl);
        if(!$validate)
        {
            $status = new ErrorOnGetLongUrl();

            $status->status_code = 200;
            $status->status_txt = "OK";
            $status->short_url = $shortUrl;
            $status->error="INVALID URL";
            echo json_encode($status);
            return;
        }
        $conn->connectToDatabase();
        $conn->selectDatabase();
        try{
            $result = mysql_query("select url from path where id = '".substr($shortUrl, -5)."' limit 1");
            $row = mysql_fetch_row($result, MYSQL_NUM);
            if(!empty($row)){
                $longUrl = $row[0];
                $conn->closeConnection();
                $status = new Link();

                $status->short_url = $shortUrl;
                $status->long_url = $longUrl;
                $status->status_code=200;
                $status->status_txt="OK";
                echo json_encode($status);
            }else{

                $status = new ErrorOnGetLongUrl();

                $status->status_code = 200;
                $status->status_txt = "OK";
                $status->short_url = $shortUrl;
                $status->error="NO URL FOUND";
                echo json_encode($status);
                return;
            }
        }catch (Exception $e){
            $status = new ErrorOnGetLongUrl();

            $status->status_code = 200;
            $status->status_txt = "OK";
            $status->short_url = $shortUrl;
            $status->error="NOT FOUND";
            echo json_encode($status);
            return;
        }
    }
}

function changePassword($username){
    $request = \Slim\Slim::getInstance()->request();
    $params =json_decode($request->getBody());
    $login = new Login();
    echo $login->updatePassword($username,$params->old_password, $params->new_password);
}

function getMainBaseFromURL($url)
{
    $chars = preg_split('//', $url, -1, PREG_SPLIT_NO_EMPTY);
    $slash = 3; // 3rd slash
    $i = 0;

    foreach($chars as $key => $char){
        if($char == '/'){
            $j = $i++;
        }
        if($i == 3){
            $pos = $key; break;
        }
    }
    $main_base = substr($url, 0, $pos);
    return $main_base.'/';
}
