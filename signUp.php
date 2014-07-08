<?php
date_default_timezone_set('Europe/Istanbul');
if ( $_POST ){
    include("source/Connection.php");
    $conn = new Connection();
    $conn->connectToDatabase();
    $conn->selectDatabase();
    $result = mysql_query("select c.email from user c where c.email='".$_POST["email"]."'");
    $row = mysql_fetch_row($result, MYSQL_NUM);

    if (empty($row)){
        $sql = mysql_query("insert into user(username, password, email) values ('".$_POST["username"]."','".$_POST["password"]."','".$_POST["email"]."')");
        if($sql){
            $conn ->closeConnection();
            session_start();
            ob_start();
            $_SESSION["login"] = "true";
            $_SESSION["username"] = $_POST["username"];
            $_SESSION["password"] = $_POST["password"];
            $_SESSION["email"] = $_POST["email"];
            header("Refresh: 0; url=.");
        }

    }else{
        echo "This email address is in use. Ply try with different email address.";
    }
}
?>
<!--<form action="signUp.php" method="post">
    <div id="signin_account" align="center">
        <div class="form_row">
            <input type="email" name="email" placeholder="Email" id="signin_email" data-required="required">
        </div>
        <div class="form_row">
            <input type="password" name="password" placeholder="Password" id="signin_password" data-required="required">
        </div>
        <div class="form_row username">
            <input type="text" name="username" placeholder="Username" id="signin_username" maxlength="32">
        </div>
    </div>
    <div align="center">
        <input type="submit" value="Start"/>
    </div>
</form>-->