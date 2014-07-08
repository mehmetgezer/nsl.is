<?php

require_once __DIR__.'/../../lib/oauth/pdo/lib/OAuth2StoragePdo.php';
require 'types/Client.php';
require 'types/ApiKey.php';

class Authorize
{
    var $oauth = null;
    public function __construct($pdo) {

        $this->oauth = new OAuth2StoragePDO($pdo);
    }
    public function addClient($userid){
        if ($_POST && isset($_POST["application_name"]) && isset($_POST["redirect_uri"])) {
            $ret = new Client();
            $ret ->application_name =$_POST["application_name"];
            $ret ->client_id =generatePassword(16);
            $ret ->client_secret =generatePassword(24);
            $ret ->redirect_uri =$_POST["redirect_uri"];
            $ret ->apikey = generatePassword(32);
            $this->oauth->addClient($ret ->application_name, $ret ->client_id, $ret ->client_secret,$ret ->redirect_uri, $ret->apikey);
            $this->oauth->mapUserClientId($userid,$ret->client_id);
            return $ret;
        }
    }

    public function getUserClient($user_id){
        $client = new Client();
        $client_id = $this->oauth->getUserClient($user_id);
        if($client_id == null){
            return $client;
        }
        else{
            $result = $this->oauth->getClientDetails($client_id);
            $client->apikey = $result["apikey"];
            $client->client_id = $result["client_id"];
            $client->redirect_uri = $result["redirect_uri"];
            $client->application_name = $result["application_name"];
            return $client;
        }
    }

    public function getClient($client_id, $client_secret, $redirect_uri){
        $apikey = new ApiKey();
        $detail = $this->oauth->getClientDetails($client_id);
        if($detail != null){
            if(strstr($redirect_uri,$detail["redirect_uri"]) != false){
                $result = $this->oauth->checkClientCredentials($client_id,$client_secret);
                if($result){
                    $apikey->apikey = $detail["apikey"];
                }
            }
        }

        return $apikey;

    }

    public function refreshApiKey($client_id){
        $apikey = new ApiKey();
        $apikey->apikey=generatePassword(32);
        $this->oauth->refreshApiKey($client_id,$apikey->apikey);
        return $apikey;
    }

    public function refreshClienSecret($client_id){
        $client = new Client();
        $client->client_secret=generatePassword(24);
        $this->oauth->refreshClientSecret($client_id,$client->client_secret);
        return $client;
    }

    /**
     * her api methodu çağrısında kullanılmalı;
     * @param $apikey
     * @param $referer
     * @return bool
     */
    public function checkApiKey($apikey,$referer){
        $detail = $this->oauth->checkApiKey($apikey);
        if($detail != null){
            if(strstr($referer,$detail["redirect_uri"]) != false){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
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
