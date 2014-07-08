// Copyright (c) 2012 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.
chrome.tabs.getSelected(null, function(tab) {
	$.post("http://nsl.is/create.php", 
			"url="+tab.url.replace(/&/g,'%26'), 
			function( data ) {
				var response = $.parseJSON(data);
				$('#link').empty().append("<a id='output' target='_blank' class='shortLink' href='"+response.link+"'>"+response.link+"</a>");
			});
		});
$(document).ready(function() {
  // Handler for .ready() called.
	$(".button").each(function(){
		$(this).click(function(){
			fbs_click(this.id);
		});
	});
});

		
function fbs_click(buttoneName) {
	var linkHolder = document.getElementById("output");
	var u = $('#output').attr('href');
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
		window.open('http://www.stumbleupon.com/submit?url='+encodeURIComponent(u), '', 'toolbar=0,status=0,width=800,height=600');
	}
}

/**
img {
        margin:5px;
        border:2px solid black;
        vertical-align:middle;
        width:75px;
        height:75px;
      }
**/