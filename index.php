<?php
// require codebird
require_once("phplibraries/codebird/src/codebird.php");
//require abraham Oauth library
require_once("phplibraries/twitterOAuth/autoload.php");

require_once("config.php");

//log into bot account with codebird
\Codebird\Codebird::setConsumerKey(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);
$cb = \Codebird\Codebird::getInstance();
$cb->setToken(TWITTER_ACCESS_TOKEN, TWITTER_ACCESS_TOKEN_SECRET);

$css = false;
$js = false;
$q = empty($_GET["q"]) ? "" : $_GET["q"];

switch($q)
{
    case "":
        $page = "home";
        $css = true;
    break;
    case "archives":
        $page = "archives";
    break;
    case "results":
        $page = "results";
    break;
    case "secretucc":
        $page = "secretucc";
        $css = true;
        $js = true;
    break;
    case "sondage":
        $page = "sondage";
        $css = true;
        $js = true;
    break;
    case "logout":
        $page = "logout";
    break;
    case "login":
        $page = "login";
    break;
    default:
        $page = "404";
    break;
}

session_start();
$_SESSION['previousLocation'] = isset($_SESSION['location']) ?  $_SESSION['location'] : 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$_SESSION['location'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

include "controllers/".$page.".php";
include "views/partials/header.php";
include "views/pages/".$page.".php";
include "views/partials/footer.php";

