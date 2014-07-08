<?php session_start();?>
<?php include "header.php" ;
date_default_timezone_set('Europe/Istanbul');
?>
    <div class="gboxtop" style="display: none"></div>
    <div class="gbox" style="text-align: center;display: none">
        <div id="title"></div>
        <div id="description"></div>
        <div id="url"></div>
        <div id="clickCount"></div>
    </div>
    <p class="separator" id="up_to_10" style="display: none">
        <span onclick="$('#history').slideToggle('slow')" style="cursor: hand">Up to 10 most recently shortened links</span>
    </p>
    <div id="template" style="display: none">
        <li class="template" onmouseover="$(this).css('backgroundColor','#E1E1E1')" onmouseout="$(this).css('backgroundColor','white')">
            <!--<div class="smallboxtop"></div>
            <div class="smallbox">-->
                <table width="100%">
                    <tr>
                        <td style="width: 95%">
                            <div>
                                <img id="favicon" alt="favicon" height="16px" width="16px" />
                                <a id="urlLink"></a>
                            </div>
                            <div>
                                <div id="urlText" style="width: 650px"></div>
                            </div>
                            <div>
                                <a id="shortLink" style="display:block;width: 150px;float:left"></a><span id="historyClickCount" style="font-size:10px;margin-left:100px;width: 100px;float: left"></span>
                            </div>
                        </td>
                        <td style="width: 5%;vertical-align: top; padding-top: 0">
                            <div  id="historyCopyLink">Copy</div>
                        </td>
                    </tr>

                </table>

            <!--</div>-->
        </li>
    </div>
    <ul id="history" style="display: none">

</ul>

<?php include "footer.php" ?>
