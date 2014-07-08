<?php
/**
 * Created by JetBrains PhpStorm.
 * User: AliRiza
 * Date: 20.01.2013
 * Time: 17:46
 * To change this template use File | Settings | File Templates.
 */

require_once __DIR__.'/../../lib/oauth/pdo/lib/OAuth2StoragePdo.php';
require_once __DIR__.'/../../source/Connection.php';
require 'types/Session.php';

class Login
{
    var $queryUser='SELECT * FROM user u WHERE u.EMAIL = :username AND u.PASSWORD = :password';
    var $createAnonymousUser = "insert into user(username, password,email) values (:username,'123456','guestUser@nsl.is')";
    var $updatePassword = "UPDATE user SET password =:password WHERE email=:username";

    var $connection = null;
    var $db = null;
    var $session = null;
    public function __construct(){
        $connection = new Connection();
        $this->db=$connection->getDbSource();
    }

    public function queryUser($username, $password){
        try{
            $stmt = $this->db->prepare($this->queryUser);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!empty($result)){
                $this->session = new Session();
                $this->session->id = $result["ID"];
                $this->session->email = $result["EMAIL"];
                $this->session->password = $result["PASSWORD"];
                $this->session->username = $result["USERNAME"];
                return true;
            }
            return false;
        }
        catch(PDOException $e){
            //$this->handleException($e);
        }
    }

    public function updatePassword($username,$old_password,$new_password){
        $ret = self::queryUser($username,$old_password);
        if($ret){
            $stmt = $this->db->prepare($this->updatePassword);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $new_password, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }
        else return false;
    }
}
