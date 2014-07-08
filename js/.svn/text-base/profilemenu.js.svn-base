/**
 * Created with JetBrains PhpStorm.
 * User: User
 * Date: 31.01.2013
 * Time: 21:40
 * To change this template use File | Settings | File Templates.
 */
var createAppPage = 'pages/addClient.php';
var profile = 'pages/profile.php';
function go(page){
    $("#pageContainer").load("pages/progress.php");
    $("#pageContainer").load(page);
}

function mouseonfunc(item){
    if($(item).css('backgroundColor') != 'rgb(0, 0, 0)')
        $(item).css('backgroundColor','navy');
}

function mouseoutfunc(item){
    if($(item).css('backgroundColor') != 'rgb(0, 0, 0)')
        $(item).css('backgroundColor','transparent');
}

function mouseclear(){
    $('a','.profilemenu').css('backgroundColor','transparent');
}

function mouseclick(item){
    mouseclear();
    $(item).css('backgroundColor','black');
}