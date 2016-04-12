<?php
use Abraham\TwitterOAuth\TwitterOAuth;

$pdo = $pdo;
$class="login";
$title="login";
$url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$urlParams = parseURLParams($url);

//if the user isn't logged in and did not authorized the twitter app

if(!isset($_SESSION["oauth_token"]))
{
    $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);
    $requestToken = $connection->oauth("oauth/request_token", array("oauth_callback" => TWITTER_OAUTH_CALLBACK));
    $_SESSION["oauth_token"] = $token = $requestToken["oauth_token"];
    $_SESSION["oauth_token_secret"] = $requestToken["oauth_token_secret"];
    $_SESSION["previousLoginLocation"] = isset($urlParams->url) ? $urlParams->url[0] : URL;
    switch($connection->getLastHttpCode())
    {
        case 200:
             $urlTwitter = $connection->url("oauth/authorize", ["oauth_token" => $token]);
             header("Location: ".$urlTwitter);
             break;
        default:
            $error["reqToken"] = "Could not connect to Twitter. Refresh the page or try again later.";
    }
}
if(isset($_SESSION["oauth_token"]))
{

    echo '<pre>';
    print_r($urlParams);
    echo '</pre>';
    //if the user did not authorize the app
    if(isset($urlParams->denied) && $urlParams->denied[0] === $_SESSION["oauth_token"])
    {
        $error["unauthorizedApp"] = "You did not authorized the application, we can't setup your account retry and authorize if you want to vote";
        session_unset();
        session_destroy();
    }
    //if the user authorized the app
    else if(isset($urlParams->oauth_token) && $urlParams->oauth_token[0] === $_SESSION["oauth_token"] && isset($urlParams->oauth_verifier))
    {
            $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $_SESSION["oauth_token"], $_SESSION["oauth_token_secret"]);
            $accessToken = $connection->oauth("oauth/access_token", array("oauth_verifier" => $urlParams->oauth_verifier[0]));
            //reseting conncection with correct oauth token and secret token
            $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $accessToken["oauth_token"], $accessToken["oauth_token_secret"]);
            $_SESSION["accessToken"] = $accessToken;
            //get the user account info data
            $userInfo = $connection->get("account/verify_credentials");
            $user = array();
            echo '<pre>';
            print_r($userInfo);
            echo '</pre>';
            if(!empty($userInfo->id))
            {
                $user["name"] = $userInfo->name;
                $user["screenName"] = $userInfo->screen_name;
                $user["picture"] = $userInfo->profile_image_url;
                register($user);
                header("Location:".$_SESSION['previousLoginLocation']);
                die();
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

if(isset($error))
{
    echo '<pre>';
    print_r($error);
    echo '</pre>';
}

function register($user)
{
    $searchUser = $GLOBALS['pdo']->prepare("SELECT screen_name, access_level from accounts WHERE screen_name = :screenName");
    $searchUser->execute(array("screenName" => $user["screenName"]));
    $result = $searchUser->fetch();

    // If the user isn't in the database we add him
    if(empty($result)){
        $addUser = $GLOBALS['pdo']->prepare("INSERT INTO accounts (name, screen_name, picture, oauth_token, oauth_secret) VALUES(:name,:screenName,:picture,:oauth_token,:oauth_secret)");
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
        $updateUserTokens = $GLOBALS['pdo']->prepare("UPDATE accounts SET oauth_token = :oauth_token, oauth_secret = :oauth_secret WHERE screen_name = :screenName");
        $updateUserTokens->bindValue("screenName", $user["screenName"]);
        $updateUserTokens->bindValue("oauth_token", $_SESSION['accessToken']["oauth_token"]);
        $updateUserTokens->bindValue("oauth_secret", $_SESSION['accessToken']["oauth_token_secret"]);
        $execute2 = $updateUserTokens->execute();
    }
    $_SESSION['accessLevel'] = isset($result->access_level) ? $result->access_level : 0 ;
    $_SESSION['username'] = $user["name"];
    $_SESSION['screenName'] = $user["screenName"];
    $_SESSION['picture'] = $user["picture"];
    $_SESSION['oauth_token'] = $_SESSION['accessToken']["oauth_token"];
    $_SESSION['oauth_token_secret'] = $_SESSION['accessToken']["oauth_token_secret"];

}

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
