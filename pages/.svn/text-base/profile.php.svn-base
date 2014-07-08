<?php include 'head.php' ?>
<div id="loginForm">
    <table>
        <tr>
            <td>
                <div  class="labelWidth">
                    <label for="username">User Name:</label>
                </div>
            </td>
            <td colspan="2">
                <input type="text" class="input" name="username" id="username" readonly="readonly" style="width: 280px;" />
            </td>
        </tr>
        <tr>
            <td>
                <div  class="labelWidth">
                    <label for="email">E-Mail:</label>
                </div>
            </td>
            <td colspan="2">
                <input type="text" class="input" name="email" id="email" style="width: 280px;" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
            &nbsp;
            </td>
            <td style="text-align: right">
               <a href="#registerForm" onclick="$('#registerForm').toggle();" style="color: #ffffff;text-decoration: none">Change Password</a>
            </td>
        </tr>
    </table>
</div>
<div id="registerForm" style="display:none">
    <form id="changePassword" onsubmit="updatePassword();return false;">
        <table>
            <tr>
                <td>
                    <div  class="labelWidth">
                        <label for="oldpass">Current Password:</label>
                    </div>
                </td>
                <td colspan="2">
                    <input type="password" class="input" name="old_password" id="oldpass" style="width: 280px;" />
                </td>
            </tr>
            <tr>
                <td>
                    <div  class="labelWidth">
                        <label for="newpass">New Password:</label>
                    </div>
                </td>
                <td colspan="2">
                    <input type="password" class="input" name="new_password" id="newpass" style="width: 280px;" />
                </td>
            </tr>
            <tr>
                <td>
                    <div  class="labelWidth">
                        <label for="newpass2">New Password Again:</label>
                    </div>
                </td>
                <td colspan="2">
                    <input type="password" class="input" name="newpass2" id="newpass2" style="width: 280px;"/>
                </td>
            </tr>
            <tr>
                <td>
                    <div  class="labelWidth">
                        &nbsp;
                    </div>
                </td>
                <td style="text-align: right">
                    <input type="submit" value="Change" class="submit" />
                </td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#email').val('<?php echo $_SESSION['email']; ?>');
        $('#username').val('<?php echo $_SESSION['username']; ?>');
    });

    function updatePassword(){
        var clientUrl="service/login/user/"+ $("#email").val();
        var newpass = $("#newpass").val();
        var newpass2 = $("#newpass2").val();
        if(newpass != newpass2){
            alert("You typed password is not match");
        }
        else{
            $.post(clientUrl,JSON.stringify($("#changePassword").serializeJSON()),function(data){
               if(data == "1"){
                   alert("Your password is changed as Successfully!");
               }
               else{
                   alert("Your password can not be changed!")
               }
            });
            $("input[type=password]","#changePassword").val("");
        }
    }
</script>

