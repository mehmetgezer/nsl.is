<?php
/**
 * Created by JetBrains PhpStorm.
 * User: AliRiza
 * Date: 13.12.2012
 * Time: 19:40
 * To change this template use File | Settings | File Templates.
 */

include("../source/Connection.php");
require_once("../source/Rest.inc.php");
class api extends REST
{
    var $db;

    public function  api(){
        $db = new Connection();
        $db->connectToDatabase();
        $db->selectDatabase();
    }

    public function processApi()
    {
        $this->api();
        $func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
        if((int)method_exists($this,$func) > 0)
            $this->$func();
        else
            $this->response('',404);
    }

    private function create(){
        if($this->get_request_method() != "POST"){
            $this->response('',406);
        }

        $url = $this->_request['url'];

        if(!empty($url) ){
            $urlCode = "http://nsl.is/".$this->generatePassword();
            $sql = mysql_query("INSERT INTO links (REAL_PATH,SHORT_LINK) VALUES ('".$url."','".$urlCode."')", $this->db);
            if(mysql_num_rows($sql) > 0){
                $result = mysql_fetch_array($sql,MYSQL_ASSOC);

                $this->response($this->json($result), 200);
            }
        }

        $error = array('status' => "Failed", "msg" => "Short Link creation fail");
        $this->response($this->json($error), 400);
    }

    private function json($data){
        if(is_array($data)){
            return json_encode($data);
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
}

$api = new api();
$api->processApi();
