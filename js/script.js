$(document).ready(function(){
   $('img.button').each(function(){
       $(this).click(function(){
           fbs_click($(this).attr('id'));
       });
    });
    $("#copyDiv").hide();
    getHistory();
});


function fbs_click(buttoneName) {
    var u = $("#urlBox").val();
    t=document.title;
    if(buttoneName=='facebook'){
        window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');
    }else if(buttoneName=='twitter'){
        window.open('https://twitter.com/intent/tweet?original_referer='+document.title+'&url='+encodeURIComponent(u),'','toolbar=0,status=0,width=626,height=436');
    }else if (buttoneName == 'linkedin') {
        window.open('http://www.linkedin.com/shareArticle?mini=true&url='+ encodeURIComponent(u) +'&title='+u+'&source='+ t, '', 'toolbar=0,status=0,width=626,height=436');
    }else if(buttoneName=='pinterest'){
        window.open('http://pinterest.com/pin/create/button/?url='+encodeURIComponent(u)+'&media=&description='+u, '', 'toolbar=0,status=0,width=626,height=436');
    }else if(buttoneName=='xing'){
        window.open('https://www.xing-share.com/social_plugins/share?url='+encodeURIComponent(u)+'&amp;wtmc='+u+';&amp;sc_p=xing-share', '', 'toolbar=0,status=0,width=626,height=436');
    }else if(buttoneName=='stumbleupon'){
        window.open('http://www.stumbleupon.com/submit?url='+encodeURIComponent(u), '', 'toolbar=0,status=0,width=800,height=600')
    }
}



function submitForm(){
    var sourceUrl=$('#urlBox').val();

    if(!ValidateWebAddress(sourceUrl)){
        $('#urlBox').val("");
        $('#urlBox').attr("placeholder","It's not a valid Url. Please try again.");
        return false;
    }
    var $form = $( '#shorten_form'),
        createUrl = $form.attr( 'action' );
    $.post('getMetaTag.php', $form.serialize().replace(/&/g,'%26'),
        function(data){
            var response;
            try{
                response = jQuery.parseJSON(data);
            }
            catch(e){
                alert(e);
            }

            if(!(response.title == "" && response.description == "")){
                $('.gbox').slideDown('fast');
                $('.gboxtop').show();
            }
            $('#title','.gbox').html("<h2><a href='"+sourceUrl+"'>"+response.title+"</a></h2>");
            $('#description','.gbox').html("<h3>"+response.description+"</h3>");
            $('#url','.gbox').html("<h3>"+sourceUrl+"</h3>");
            $('h2',$('#title','.gbox')).expander({
                slicePoint:       50,  // default is 100
                expandPrefix:     ' ', // default is '... '
                expandText:       '[...]', // default is 'read more'
                collapseTimer:    5000, // re-collapses after 5 seconds; default is 0, so no re-collapsing
                userCollapseText: '[^]'  // default is 'read less'
            });
            $('h3','.gbox').expander({
                slicePoint:       50,  // default is 100
                expandPrefix:     ' ', // default is '... '
                expandText:       '[...]', // default is 'read more'
                collapseTimer:    5000, // re-collapses after 5 seconds; default is 0, so no re-collapsing
                userCollapseText: '[^]'  // default is 'read less'
            });
        }
    );
    $.post( "create.php", $form.serialize().replace(/&/g,'%26'),
        function( data ) {
            var response = null;
            try{
                response = jQuery.parseJSON(data);
            }
            catch (e){
                alert(e);
            }
            $("#inputForm").slideDown('slow');
            $('#share').fadeIn('slow');
            $('#urlBox').fadeIn('slow').val(response.link).select();
            $('#clearShortLink').fadeIn('slow');
            $('#submitButton').hide();
            $('#copyDiv').show();
            $("#copyButton").zclip({
                path: "ZeroClipboard.swf",
                copy: function(){return $("#urlBox").val();}
            });
            $('#qrcode').qrcode({
                render  : 'table',
                text	: response.link
            });
            $.fx.speeds._default = 1000;
            $("#qrcode").dialog({
                autoOpen: false,
                show: "blind",
                hide: "explode",
                resizable: false,
                draggable: false,
                modal:true,
                title: response.link,
                width: 281
            });
            if(response != null && (response.clickCount != '0' && response.clickCount != '')){
                $('#clickCount','.gbox').text("Clicked " + response.clickCount + " times");
            }
            else{
                $('#clickCount','.gbox').text("Clicked 0 times");
            }
            getHistory();
        }
    );
    $('#urlBox').bind({
        'keyup':function(e){
            if($('#urlBox').val() != copiedUrl){
                copiedUrl = $('#urlBox').val();
                createNewLinkFuncWithCopy();
            }
        },
        'focus':function(){
            copiedUrl = $('#urlBox').val();
            $('#urlBox').select();
        }
    });
}
var copiedUrl = "";
function createNewLinkFunc(){
    $('#share').fadeOut('slow');
    $('#urlBox').fadeIn('slow').val("");
    $('#clearShortLink').fadeOut('slow');
    $('#submitButton').show();
    $('#qrcode').empty();
    $("#inputForm").slideDown('slow');
    $('.gbox').slideUp('fast');
    $('.gboxtop').hide();
    $('#copyDiv').hide();
    $("#urlBox").unbind();
}
function createNewLinkFuncWithCopy(){
    createNewLinkFunc();
    $('#urlBox').val(copiedUrl);
    copiedUrl="";
}

function getHistory(){

    $.get('history.php',function(data){
        $('#history').empty();
        var result = jQuery.parseJSON(data);

        $(result).each(function(i){

            var clone = $('.template','#template').clone();
            $('#urlLink',clone).attr('href',this.url);
            $('#urlLink',clone).html(truncateText(this.title,i,"taggy"));
            $('#urlText',clone).html(truncateText(this.url,i,"more"));
            $('#urlLink',clone).text(this.title);
            $('#shortLink',clone).attr('href',this.link);
            $('#shortLink',clone).text(this.link);
            $('#favicon',clone).attr('src',this.faviconUrl);
            $('#historyClickCount',clone).html("<a target='_blank' style='display: block' href='"+this.chartUrl+"'>"+this.clickCount+" clicks</a>");
            $("#historyCopyLink",clone).attr("id","historyCopyLink_"+i);
            $(clone).appendTo('#history');
        });
        if(result.length != 0){
            $('#up_to_10').show();
            $('#history').slideDown('slow');
            $("li","#history").each(function(i){
                var clip = new ZeroClipboard.Client();
                clip.setText($('#shortLink',this).text());
                clip.glue($('div[id^="historyCopyLink"]',this).attr("id"));
            });
        }
    });
}
function truncateText(text,i,tag){
    tag = tag+"_"+i;
    if(text.length>100){
        var end = text.substring(100);
        var start = text;
        start = start.replace(end,'');
        var html = "<span>"+ start +"</span><span id='"+tag+"' style='display:none'>"+end+"</span>";
        html = html + "<a style='cursor: hand' onclick='$(\"#"+tag+"\").fadeToggle();'>...</a>";
        return html;
    }
    else{
        return text;
    }
}
function openQRCode(){

    $("#qrcode").dialog("open");
}

function openSite(id,url,title){

    $("#qrcode").load(url).dialog({modal:true});
    $('#qrcode').dialog( "option" , "title" ,title);
}

function ValidateWebAddress(url) {
    var webSiteUrlExp = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/;
    if (webSiteUrlExp.test(url)) {
        return true;
    }
    else {
        return false;
    }
}