<?php

$class = "logout";
$title = "logout";
// log out the user and redirect him to where he was;
session_destroy();
$url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$urlParams = parseURLParams($url);
$redirect = isset($urlParams->url) ? $urlParams->url[0] : URL;


header("Location:".$redirect);
die();

function parseURLParams($url) {
        $queryStart = strpos($url,"?") + 1;
        $queryEnd = strlen($url) + 1;

        $query = substr($url,$queryStart, $queryEnd - 1);
        $pairs = explode("&",$query);
        $parms = new stdClass;
    if ($query === $url || $query === "") {
        return;
    }

    for ($i = 0; $i < count($pairs); $i++) {
        $nv = explode("=",$pairs[$i]);
        $n = urldecode($nv[0]);
        $v = urldecode($nv[1]);

        if (!property_exists($parms,$n)) {
            $parms->$n = [];
        }

        array_push($parms->$n,count($nv) === 2 ? $v : null);
    }
    return $parms;
}
