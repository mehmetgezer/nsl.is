<?php
date_default_timezone_set('Europe/Istanbul');
if ( $_POST ){
    session_start();
    ob_start();

    $_SESSION["login"]="true";
    $_SESSION["username"] = $_POST["mydata1"];
    $_SESSION["password"] = $_POST["mydata2"];
    $_SESSION["userid"] = $_POST["mydata3"];
    $_SESSION["email"] = $_POST["email"];
    header('Refresh: 0; url=.');
}
?>

<!--<form action="signIn.php" method="post" style="margin: 0px auto;">
    <div id="signin_account" align="center">
        <div class="form_row">
            <input type="email" name="email" required="required" placeholder="E-mail" id="signin_email" data-required="required" autofocus="autofocus">
        </div>
        <div class="form_row">
            <input type="password" name="password" required="required" placeholder="Password" id="signin_password" data-required="required" autofocus="autofocus">
        </div>
    </div>
    <div align="center">
        <input type="submit" value="Start"/>
    </div>
</form>-->
