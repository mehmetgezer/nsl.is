<?php
require "../source/Connection.php";
require "../lib/oauth/pdo/lib/OAuth2StoragePdo.php";
$con=new Connection();
$oauth = new OAuth2(new OAuth2StoragePDO($con->getDbSource()));
try {
    $auth_params = $oauth->getAuthorizeParams();
} catch (OAuth2ServerException $oauthError) {
    $oauthError->sendHttpResponse();
}
?>
<form method="post" action="authorize">
    <?php foreach ($auth_params as $key => $value) : ?>
    <input type="hidden"
           name="<?php htmlspecialchars($key, ENT_QUOTES); ?>"
           value="<?php echo htmlspecialchars($value, ENT_QUOTES); ?>" />
    <?php endforeach; ?>
    Do you authorize the app to do its thing?
    <p><input type="submit" name="accept" value="Yep" /> <input
            type="submit" name="accept" value="Nope" /></p>
</form>