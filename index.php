<?php

require_once("config.php");

$q = empty($_GET["q"]) ? "" : $_GET["q"];

switch($q)
{
    case "":
        $page = "home";
    break;
    case "secretucc":
        $page = "secretucc";
    break;
    default:
        $page = "404";
    break;
}



include "controllers/".$page.".php";
include "views/partials/header.php";
include "views/pages/".$page.".php";
include "views/partials/footer.php";
