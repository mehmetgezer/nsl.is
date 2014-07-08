<?php include 'masterheader.php' ?>
<?php include 'login.php' ?>
<?php include 'title.php' ?>


    <div id="tabs">

        <div id="search">
            <form method="post" id="shorten_form" onsubmit="submitForm();return false;">
                <div id="inputForm">
                    <input id="urlBox" type="text" name="url" class="search" placeholder="Paste Link"/>
                    <input id="submitButton" type="button" value="NSL It!" class="button" onclick="submitForm();" />
                    <div id="copyDiv"><input id="copyButton" type="button" value="Copy!" class="button" /></div>
                    <div id="share" style="display: none">
                        <img  id="qrcodeLink" src="style/images/qrcode.png" class="qrbutton" onclick="openQRCode()" />
                        <img  id="linkedin" src="style/images/linkedin32.png" class="button" />
                        <img  id="pinterest" src="style/images/pinterest32.png" class="button"/>
                        <img  id="twitter"  src="style/images/twitter32.png" class="button" />
                        <img  id="facebook" src="style/images/facebook32.png" class="button" />
                        <img  id="stumbleupon" src="style/images/stumbleupon32.png" class="button" />
                        <img  id="xing" src="style/images/xing32.png" class="button" />
                    </div>
                </div>
                <div id="qrcode"></div>
            </form>
            <a href="#" id="clearShortLink" class="clearShortLink" style="display: none" onclick="createNewLinkFunc()">x</a>
        </div>
    </div>