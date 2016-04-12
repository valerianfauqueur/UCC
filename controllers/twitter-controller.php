<?php
require_once("../config.php");
use Abraham\TwitterOAuth\TwitterOAuth;

$pdo = $pdo;

//////////////////////TWITER LOGIN///////////////////////
//////////////////////TWITER LOGIN///////////////////////
//////////////////////TWITER LOGIN///////////////////////
//////////////////////TWITER LOGIN///////////////////////

session_start();
//if the user isn't logged in and did not authorized the twitter app
if(!isset($_SESSION["oauth_token"]))
{
    $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);
    $requestToken = $connection->oauth("oauth/request_token", array("oauth_callback" => TWITTER_OAUTH_CALLBACK));
    $_SESSION["oauth_token"] = $token = $requestToken["oauth_token"];
    $_SESSION["oauth_token_secret"] = $requestToken["oauth_token_secret"];
    switch($connection->getLastHttpCode())
    {
        case 200:
             $url = $connection->url("oauth/authorize", ["oauth_token" => $token]);
             header("Location: ".$url);
             break;
        default:
            $error["reqToken"] = "Could not connect to Twitter. Refresh the page or try again later.";
    }

}
if(isset($_SESSION["oauth_token"]))
{
    //if the user did not authorize the app
    if(isset($_GET["denied"]) && $_GET["denied"] == $_SESSION["oauth_token"])
    {
        $error["unauthorizedApp"] = "You did not authorized the application, we can't setup your account retry and authorize if you want to vote";
    }
    //if the user authorized the app
    if(isset($_GET["oauth_token"]) && $_GET["oauth_token"] === $_SESSION["oauth_token"] && isset($_GET["oauth_verifier"]))
    {
            $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $_SESSION["oauth_token"], $_SESSION["oauth_token_secret"]);
            $accessToken = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_GET["oauth_verifier"]));
            //reseting conncection with correct oauth token and secret token
            $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $accessToken["oauth_token"], $accessToken["oauth_token_secret"]);
            $_SESSION["accessToken"] = $accessToken;
            //get the user account info data
            $userInfo = $connection->get("account/verify_credentials");
            $user = array();
            if(!empty($userInfo->id))
            {
                $user["id"] = $userInfo->id;
                $user["name"] = $userInfo->name;
                $user["screenName"] = $userInfo->screen_name;
                $user["picture"] = $userInfo->profile_image_url;
                register($user);
            }
            else
            {
                $error["noAccountData"] = "Something went wrong when trying to retrieve your data";
            }
    }
    else
    {
         $error["unknown"] = "something went wrong please retry to connect";
    }
}

function register($user)
{
    $searchUser = $GLOBALS['pdo']->prepare("SELECT twitterID from accounts WHERE twitterID = :id");
    $searchUser->execute(array("id" => $user["id"]));
    $result = $searchUser->fetch();

    // If the user isn't in the database we add him
    if(empty($result)){
        $addUser = $GLOBALS['pdo']->prepare("INSERT INTO accounts (twitterID, name, screen_name, picture, oauth_token, oauth_secret) VALUES(:id,:name,:screenName,:picture,:oauth_token,:oauth_secret)");
        $addUser->bindValue("id", $user["id"]);
        $addUser->bindValue("name", $user["name"]);
        $addUser->bindValue("screenName", $user["screenName"]);
        $addUser->bindValue("picture", $user["picture"]);
        $addUser->bindValue("oauth_token", $_SESSION['accessToken']["oauth_token"]);
        $addUser->bindValue("oauth_secret", $_SESSION['accessToken']["oauth_token_secret"]);
        $execute = $addUser->execute();
    }
    else
    {
        // Update the tokens
        $updateUserTokens = $GLOBALS['pdo']->prepare("UPDATE accounts SET oauth_token = :oauth_token, oauth_secret = :oauth_secret WHERE twitterID = :id");
        $updateUserTokens->bindValue("id", $user["id"]);
        $updateUserTokens->bindValue("oauth_token", $_SESSION['accessToken']["oauth_token"]);
        $updateUserTokens->bindValue("oauth_secret", $_SESSION['accessToken']["oauth_token_secret"]);
        $execute2 = $updateUserTokens->execute();
    }

    $_SESSION['id'] = $user["id"];
    $_SESSION['username'] = $user["name"];
    $_SESSION['screenName'] = $user["screenName"];
    $_SESSION['picture'] = $user["picture"];
    $_SESSION['oauth_token'] = $_SESSION['accessToken']["oauth_token"];
    $_SESSION['oauth_token_secret'] = $_SESSION['accessToken']["oauth_token_secret"];

}


//////////////////////END LOGIN///////////////////////
//////////////////////END LOGIN///////////////////////
//////////////////////END LOGIN///////////////////////
//////////////////////END LOGIN///////////////////////
