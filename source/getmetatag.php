<?php

require_once "OpenGraph.php";

function getMetaTag($url){
    $metaInfo = new MetaInfo();
    $page = verial($url);
    $titleStart=strpos(strtolower($page),'<title>')+7;
    if($titleStart == 7){
        $memo = parse_url($url);
        $metaInfo->title=$memo["host"];
    }
    else{
        $titleLength=strpos(strtolower($page),'</title>')-$titleStart;
        $title=substr($page,$titleStart,$titleLength);
        setlocale(LC_ALL, 'tr_TR');
        $title = iconv("ISO-8859-9","UTF-8//TRANSLIT",$title);
        $metaInfo->title=trim($title);
    }

    $doc = new DOMDocument();
    @$doc->loadHTML($page);
    $metas = $doc->getElementsByTagName('meta');

    for ($i = 0; $i < $metas->length; $i++)
    {
        $meta = $metas->item($i);
        if($meta->getAttribute('name') == 'description')
            $metaInfo->description = $meta->getAttribute('content');
        if($meta->getAttribute('name') == 'keywords')
            $metaInfo->keywords = $meta->getAttribute('content');
        if($meta->getAttribute('language') == 'language');
            $metaInfo->language = $meta->getAttribute('language');
    }


    return $metaInfo;
}

function verial($url)
{
    $str = array(
        'Accept-Language: tr,en-US;q=0.8,en;q=0.6',
        'Accept-Charset: ISO-8859-9,utf-8;q=0.7,*;q=0.3'
    );
    //if (!extension_loaded(curl)){die("Extension yuklu degil socket deneyebilirsin");}
    $ch = curl_init();
    if (!$ch) { die ("Curl oturumu baslatamadim.."); }
    curl_setopt($ch, CURLOPT_URL,str_replace("https","http",$url));
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$str);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/18.0.0.3");
    curl_setopt($ch, CURLOPT_REFERER, "http://nsl.is/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie");
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function getMetaTagAsJson($url){
    return json_encode(getMetaTag($url));
}

function fetchOpenGraphMeta($url){
    $graph = OpenGraph::fetch(str_replace("https","http",$url));
    return $graph;


    /**if(array_key_exists('title',$array)){
        $openGraphMetaInfo->title = $array->current();
    }
    if(array_key_exists('description',$array)){
        $openGraphMetaInfo->description = $array['description'];
    }
    if(array_key_exists('site_name',$array)){
        $openGraphMetaInfo->siteName = $array['site_name'];
    }
    if(array_key_exists('image',$array)){
        $openGraphMetaInfo->imageUrl = $array['image'];
    }
    if(array_key_exists('video',$array)){
        $openGraphMetaInfo->videoUrl = $array['video'];
    }
    if(array_key_exists('url',$array)){
        $openGraphMetaInfo->url = $array['url'];
    }
    if(array_key_exists('type',$array)){
        $openGraphMetaInfo->type = $array['type'];
    }
    return $openGraphMetaInfo;**/
}

class MetaInfo{
    var $title="";
    var $description="";
    var $keywords="";
    var $language="";
}

class OpenGraphMetaInfo{
    var $title="";
    var $description="";
    var $siteName="";
    var $imageUrl="";
    var $videoUrl="";
    var $url="";
    var $type="";
}
