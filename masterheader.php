<?php
date_default_timezone_set('Europe/Istanbul');
$usernameErr=$username=$emailErr=$email="";
if ( $_POST ){

    include("source/Connection.php");
    $conn = new Connection();
    $conn->connectToDatabase();
    $conn->selectDatabase();

    $result = mysql_query("select c.username, c.password, c.id from user c where c.email='".$_POST["email"]."' and c.password='".$_POST["password"]."'");
    $row = mysql_fetch_row($result, MYSQL_NUM);

    if (!empty($row)) {
        session_start();
        ob_start();
        $_SESSION["login"]="true";
        $_SESSION["username"]=$row[0];
        $_SESSION["password"]=$row[1];
        $_SESSION["userid"]=$row[2];
        header('Refresh: 0; url=index.php');
    }else{
        echo 'Wrong e-mail and password.';
    }
}

?>
<?php require_once "source/Scripts.php" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9,IE=8">
    <meta name="description" content="Promote your links, learn about analyze of your links, and find ways to improve your shares; Url Shortening on NSL.is">
    <meta name="verify-v1" content="0Y3X9Tk9vhlySkP5QOZAySUb4ZQzkv3XcEhkFHRVqGM=">
    <meta name="verify-v1" content="8kpHpaImCGkSeOspy+RXxqXN2yOqm6e6sN2+iB11xsI=">
    <meta name="verify-v1" content="qMtBAmvV6/I3w+OGeZjoPnh342XxqmpE+dT3AsuREbQ=">
    <meta name="google-site-verification" content="LMElaUUSUk_uQ_Xx4C1toWCY9xfMYvm1LbBMCOvkySA">
    <meta name="msvalidate.01" content="8D2CE9019ADB8EEFFB06D2D69E900D15">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <META http-equiv=content-type content=text/html;charset=iso-8859-9>
    <META http-equiv=content-type content=text/html;charset=windows-1254>
    <META http-equiv=content-type content=text/html;charset=x-mac-turkish>
    <link rel="canonical" href="http://nsl.is/" />
    <script type="text/javascript" src="js/jquery-1.9.1.min.js" ></script>
    <script type="text/javascript" src="js/jquery.expander.min.js" ></script>
    <script type="text/javascript" src="js/jquery.qtip-1.0.0-rc3.min.js" ></script>
    <script type="text/javascript" src="js/serialize-json.jquery.js"></script>
    <script type="text/javascript" src="js/json2.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <script type="text/javascript" src="js/jquery.zclip.min.js"></script>
    <script type="text/javascript" src="js/jquery.fancybox.js"></script>
    <script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="ZeroClipboard.js"></script>
    <title>Your new URL shortener. Share your Short URLs and QR Codes.</title>
    <link rel="shortcut icon" href="style/images/favicon.ico">
    <link rel="icon" type="image/gif" href="style/images/animated_favicon1.gif">
    <link rel="stylesheet" href="style/style.css" type="text/css" />
    <link rel="stylesheet" href="style/cbdb-search-form.css" type="text/css" />
    <link rel="stylesheet" href="style/south-street/jquery-ui-1.9.2.custom.min.css" />
    <link rel="stylesheet" type="text/css" href="style/fancybox/jquery.fancybox.css?v=2.1.4" media="screen" />
    <script type="text/javascript" src="js/pinterest.js"></script>
    <script type="text/javascript" src="js/jquery.qrcode.min.js"></script>
    <script type="text/javascript" src="js/jquery.xdomainajax.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="js/profilemenu.js"></script>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    <script type="XING/Share" data-counter="no_count" data-lang="en" data-button-shape="square"></script>
    <script>
        ;(function(d, s) {
            var x = d.createElement(s),
                    s = d.getElementsByTagName(s)[0];
            x.src ='<?php echo get_base_url()?>js/xing.js';
            s.parentNode.insertBefore(x, s);
        })(document, 'script');
    </script>
</head>
<body>