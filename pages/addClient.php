<?php include 'head.php' ?>
<div id="loginForm">
    <form method="post" id="clientForm" onsubmit="postForm();return false;">
        <table>
            <tr>
                <td>
                    <div  class="labelWidth">
                        <label for="application_name">Application Name:</label>
                    </div>
                </td>
                <td>
                    <input type="text" class="input" name="application_name" id="application_name" style="width: 280px;" />
                </td>
            </tr>
            <tr>
                <td>
                    <div  class="labelWidth">
                        <label for="redirect_uri">Redirect URI:</label>
                    </div>
                </td>
                <td>
                    <input type="text" class="input" name="redirect_uri" id="redirect_uri" style="width: 280px;" />
                </td>
            </tr>
            <tr>
                <td>
                    <div  class="labelWidth">
                        &nbsp;
                    </div>
                </td>
                <td style="text-align: right">
                    <input type="submit" value="Add" class="submit" />
                </td>
            </tr>
        </table>
    </form>
</div>
<div id="registerForm" style="display:none">
    <table>
        <tr>
            <td>
                <div  class="labelWidth">
                    <label for="application_name">Application Name:</label>
                </div>
            </td>
            <td colspan="2">
                <input type="text" class="input" id="application_name" readonly="readonly" style="width: 280px;"/>
            </td>
        </tr>
        <tr>
            <td>
                <div  class="labelWidth">
                    <label for="redirect_uri">Redirect URI:</label>
                </div>
            </td>
            <td colspan="2">
                <input type="text" class="input" id="redirect_uri" readonly="readonly" style="width: 280px;" />
            </td>
        </tr>
        <tr>
            <td>
                <div  class="labelWidth">
                    <label for="client_id">Client Id</label>
                </div>
            </td>
            <td colspan="2">
                <input type="text" class="input" id="client_id" readonly="readonly" style="width: 280px;"/>
            </td>
        </tr>
        <tr>
            <td>
                <div  class="labelWidth">
                    <label for="client_secret">Client Secret</label>
                </div>
            </td>
            <td>
                <input type="text"  class="input" id="client_secret" readonly="readonly" style="width: 280px;"/>
            </td>
            <td>
                <img src="style/images/gtk_refresh.png" width="24px;" height="24px" style="cursor: hand" onclick="refreshClientSecret();" />
            </td>
        </tr>
        <tr>
            <td>
                <div  class="labelWidth">
                    <label for="apikey">Api Key</label>
                 </div>
            </td>
            <td>
                <input type="text" class="input"  id="apikey" readonly="readonly" style="width: 280px;"/>
            </td>
            <td>
                <img src="style/images/gtk_refresh.png" width="24px;" height="24px" style="cursor: hand" onclick="refreshApiKey();" />
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    function postForm(){
        var $form = $( '#clientForm');
        var clientUrl="service/authorize/client/"+ <?php echo $_SESSION["userid"];?>;
        $.post(clientUrl,$form.serialize(),function(data){
            var response;
            try{
                response = jQuery.parseJSON(data);
                $("#client_id","#registerForm").val(response.client_id);
                $("#client_secret","#registerForm").val(response.client_secret);
                $("#application_name","#registerForm").val(response.application_name);
                $("#redirect_uri","#registerForm").val(response.redirect_uri);
                $("#apikey","#registerForm").val(response.apikey);
            }
            catch(e){
                alert(e);
            }
            $("#loginForm").hide();
            $("#registerForm").show();
        });
    }
    $(document).ready(function(){
        <?php
            try{
                $conn = new Connection();
                $auth = new Authorize($conn->getDbSource());
                $client = $auth->getUserClient($_SESSION["userid"]);
            }
            catch(Exception $e){
                echo("alert('".$e."');");
            }
        ?>
        <?php if($client->client_id != ""){ ?>
        $("#loginForm").hide();
        $("#registerForm").show();
        $("#client_id","#registerForm").val('<?php echo $client->client_id;?>');
        $("#application_name","#registerForm").val('<?php echo $client->application_name;?>');
        $("#redirect_uri","#registerForm").val('<?php echo $client->redirect_uri;?>');
        $("#apikey","#registerForm").val('<?php echo $client->apikey;?>');
        <?php }?>
    });

    function refreshApiKey(){
        var clientUrl="service/authorize/client/apikey/"+ $("#client_id").val();
        $.ajax({
            url: clientUrl,
            type: 'PUT',
            success: function(data) {
                $("#apikey").val($.parseJSON(data).apikey);
            }
        });
    }

    function refreshClientSecret(){
        var clientUrl="service/authorize/client/"+ $("#client_id").val();
        $.ajax({
            url: clientUrl,
            type: 'PUT',
            success: function(data) {
                $("#client_secret").val($.parseJSON(data).client_secret);
            }
        });
    }
</script>