<?php
// log out the user and redirect him to where he was;
session_unset();
session_destroy();

$class = "logout";
$title = "logout";

echo '<pre>';
print_r(URL);
echo '</pre>';

if(isset($_GET["url"]))
{
    header("Location:".$_GET["url"]);
    die();
}
else
{
    header("Location:".URL);
    die();
}
