<?php
if(!isset($_SESSION))
{
    session_start();
}
?>
<style>
    .labelWidth{
        width: 180px;
        font-size: medium;
        color: #ffffff;
        font-weight: bold;
    }
</style>
<input type="checkbox" id="login_toggle" checked=""/>
<section id="login-form">
    <label id='toggle' for='login_toggle'>
    <?php
    date_default_timezone_set('Europe/Istanbul');
    if(!isset($_SESSION["login"])){
        echo "Login";
    }
    else{
        echo "Welcome ".$_SESSION["username"]."&nbsp";
        echo '<a style="float: right;" href="logout.php" type="submit">Logout</a>';
    }
    ?>
    </label>
    <?php if(!isset($_SESSION["login"])){ ?>
    <div style="width:405px; margin: 5px auto">
        <table>
            <tr>
                <td valign="bottom">
                    <form id="registerForm" method="POST" action="signUp.php" style="margin-right: 20px;">
                        <div id="input">
                            <input id="remail" class="input username" type="email" placeholder="E-mail" name="email" required />
                        </div>

                        <div id="input">
                            <input id="rpassword" class="input password" type="password" placeholder="Password" name="password" required />
                        </div>

                        <div id="input">
                            <input id="rusername" class="input username" type="text" placeholder="Username" name="username" required />
                        </div>

                        <div id="input" style="margin-bottom: 0px">
                            <input  class="submit" type="button" value="Register" onclick="validateEmail()">
                        </div>
                    </form>
                </td>
                <td width="1" bgcolor="#FFFFF" />
                <td valign="bottom">
                    <form id="loginForm" action="signIn.php" method="post" style="margin-left: 20px;">
                        <div id="input">
                            <input id="lemail" class="input username" type="email" placeholder="E-mail" name="email" required />
                        </div>

                        <div id="input">
                            <input id="lpassword" class="input password" type="password" placeholder="Password" name="password" required />
                        </div>

                        <div id="input" style="margin-bottom: 0px">
                            <input  class="submit" type="button" value="Login" onclick="validateLogin()">
                        </div>
                    </form>
                </td>
            </tr>
        </table>
    </div>
    <?php } else{?>
    <div style="width:680px; margin: 5px auto">
        <table>
            <tr>
                <td valign="top">
                    <div class="profilemenu" style="width:125px;height: 160px;">
                        <ul>
                            <li>
                                <a href="#" onclick='go(profile);mouseclick(this);' onmouseover="mouseonfunc(this)" onmouseout="mouseoutfunc(this);" >Profile</a>
                            </li>
                            <li>
                            <a href="#" onclick='go(createAppPage);mouseclick(this);'  onmouseover="mouseonfunc(this)" onmouseout="mouseoutfunc(this);" >Application</a>
                            </li>
                        </ul>
                    </div>
                </td>
                <td width="1" bgcolor="#FFFFF" />
                <td valign="top">
                    <div id="pageContainer" style="height: 160px; width: 525px; overflow: auto"/>
                </td>
             </tr>
         </table>
    </div>
    <?php } ?>
</section>
    <script type="text/javascript">

        function validateEmail(){

            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if( !emailReg.test( $('#remail').val()) || $('#remail').val()=='' ) {
                $('#remail').css("background-color","#F87431");
                $('#remail').qtip({
                    position: {
                        corner: {
                            target: 'left',
                            tooltip: 'right'
                        }
                    },
                    content: {
                        text: "Not a valid e-mail." // Use each elements title attribute
                    },
                    style: {  border: { radius: 5 }  , color: 'black' } // Give it some style
                });
                return false;
            }else{
                $('#remail').css("background-color","#FFF");
            }
            if($('#rpassword').val()=='' ||$('#rusername').val()==''){
                $('#rpassword').css("background-color","#F87431");
                $('#rusername').css("background-color","#F87431");
                $('#rpassword').qtip({
                    position: {
                        corner: {
                            target: 'left',
                            tooltip: 'right'
                        }
                    },
                    content: {
                        text: "You must specify a valid username and password." // Use each elements title attribute
                    },
                    style: {  border: { radius: 5 }  , color: 'black' } // Give it some style
                });
                $('#rusername').qtip({
                    position: {
                        corner: {
                            target: 'left',
                            tooltip: 'right'
                        }
                    },
                    content: {
                        text: "You must specify a valid username and password." // Use each elements title attribute
                    },
                    style: {  border: { radius: 5 }  , color: 'black' } // Give it some style
                });
            }

            $.post("service/signup/validate",JSON.stringify($('#registerForm').serializeJSON()),function(data){
                if(data != "1"){
                    $('#registerForm').submit();
                }
                else{
                    $('#remail').css("background-color","#F87431");
                    $('#remail').qtip({
                        position: {
                            corner: {
                                target: 'left',
                                tooltip: 'right'
                            }
                        },
                        content: {
                            text: "This e-mail has been taken. Please use an another e-mail." // Use each elements title attribute
                        },
                        style: {  border: { radius: 5 }  , color: 'black' } // Give it some style
                    });
                    $('#rusername').css("background-color","#FFF");
                    $('#rpassword').css("background-color","#FFF");
                }
            });
        }
        function validateLogin(){
            var fail = false;
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if( !emailReg.test( $('#lemail').val()) || $('#lemail').val()=='' ) {
                $('#lemail').css("background-color","#F87431");
                $('#lemail').qtip({
                    position: {
                        corner: {
                            target: 'right',
                            tooltip: 'left'
                        }
                    },
                    content: {
                        text: "Not a valid e-mail." // Use each elements title attribute
                    },
                    style: {  border: { radius: 5 }  , color: 'black' } // Give it some style
                });
                fail = true;
            }else{
                $('#lemail').css("background-color","#FFF");
            }

            if($('#lpassword').val()==''){
                $('#lpassword').css("background-color","#F87431");
                $('#lpassword').qtip({
                    position: {
                        corner: {
                            target: 'right',
                            tooltip: 'left'
                        }
                    },
                    content: {
                        text: "You must specify a valid password." // Use each elements title attribute
                    },
                    style: {  border: { radius: 5 }  , color: 'black' }
                });
                fail = true;
            }else{
                $('#lpassword').css("background-color","#FFF");
            }
            if(fail){
                return false;
            }

            $.post("service/login/validate",JSON.stringify($('#loginForm').serializeJSON()),function(data){
                if(data ==  '0'){
                    $('#lemail').css("background-color","#F87431");
                    $('#lpassword').css("background-color","#F87431");
                    $('#lemail').qtip({
                        position: {
                            corner: {
                                target: 'right',
                                tooltip: 'left'
                            }
                        },
                        content: {
                            text: "Wrong e-mail or password." // Use each elements title attribute
                        },
                        style: {  border: { radius: 5 }  , color: 'black' }
                    });
                    $('#lpassword').qtip({
                        position: {
                            corner: {
                                target: 'right',
                                tooltip: 'left'
                            }
                        },
                        content: {
                            text: "Wrong e-mail or password." // Use each elements title attribute
                        },
                        style: {  border: { radius: 5 }  , color: 'black' }
                    });
                }else{
                    $('#lemail').css("background-color","#FFF");
                    $('#lpassword').css("background-color","#FFF");
                    var json = $.parseJSON(data);
                    $('<input />').attr('type', 'hidden')
                            .attr('name', "mydata1")
                            .attr('value', json[0])
                            .appendTo('#loginForm');
                    $('<input />').attr('type', 'hidden')
                            .attr('name', "mydata2")
                            .attr('value', json[1])
                            .appendTo('#loginForm');
                    $('<input />').attr('type', 'hidden')
                            .attr('name', "mydata3")
                            .attr('value', json[2])
                            .appendTo('#loginForm');

                    $('#loginForm').submit();
                }
            });

        }
    </script>