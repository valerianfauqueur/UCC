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

$q = empty($_GET["q"]) ? "" : $_GET["q"];

switch($q)
{
    case "":
        $page = "home";
    break;
    case "secretucc":
        $page = "secretucc";
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
//echo"<script src='src/js/libs/jquery-2.2.3.min.js'></script>";
//echo"<script src='src/js/libs/jquery-ui.min.js'></script>";
echo "<script src='src/js/controllers/".$page.".js'></script>";
include "views/partials/footer.php";

