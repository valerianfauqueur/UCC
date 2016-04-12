<?php

//define API KEY

define("API_KEY", "e7ba6516f7ea468fdedc6b919afbe1ad");
define("MOVIEDB_URL", "http://api.themoviedb.org/3/");


//Twitter api info
define('TWITTER_CONSUMER_KEY', 'bZ86rMgaBilsRpIf3BMxrdJgU');
define('TWITTER_CONSUMER_SECRET', '1JroLO2bYamPBB6TwhradXh7qT7N0QDimZULImuWfTkLKAFZiI');
define('TWITTER_ACCESS_TOKEN', '719524911493050370-7tMFCv5SXScQxqsKHg7xfcDlWnreJOp');
define('TWITTER_ACCESS_TOKEN_SECRET', 'JsyN6MEuWk2KgpQ8QGmuw45PH5gaNc3b4dDztzeTNgDdR');
define('TWITTER_OAUTH_CALLBACK', 'http://localhost/uccapp/login');


//database connection and info

define('DB_HOST','127.0.0.1');
define('DB_NAME','uccapp');
define('DB_USER','root');
define('DB_PASS',''); // default on windows

//default site url
define("URL", "http://localhost/uccapp/");

try
{
    // Try to connect to database
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS);

    // Set fetch mode to object
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
}
catch (Exception $e)
{
    // Failed to connect
    die('Could not connect');
}
