<?php

require_once("../config.php");
header('Content-type:application/json');
$nbPerPage = 10;

$result = array();
$arg = array();

if(isset($_POST['functionname']))
{
    if(isset($_POST['arguments']))
    {
        foreach($_POST["arguments"] as $key => $value)
        {
            $arg[$key] = strip_tags(trim($value));
        }
    }
    switch($_POST['functionname']) {
        case "searchMovies":
            $result =  searchMovies($arg[0]);
        break;
        case "searchMovieByRelativeKeyWord":
            $result = searchMovieByRelativeKeyWord($arg[0]);
        break;
        case "searchCharactersMovie":
            $result = searchCharactersMovie($arg[0]);
        break;
        default:
           $result['error'] = 'Not found function '.$_POST['functionname'].'!';
    }
}


echo json_encode($result);


function callApi($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Codular Sample cURL Request');
    $request = curl_exec($curl);
    $request = json_decode($request);
    curl_close($curl);

    return $request;
}

function searchMovies($name)
{
    $newName = str_replace(' ', '%20', $name);
    $url = MOVIEDB_URL."search/movie?query=".$newName."&page=1&api_key=".API_KEY;
    $movieResults = callApi($url);
    $pages = $movieResults->total_pages;
    $pages_result = array();
    for($i = 1, $l = $pages; $i <= $l;$i++)
    {
        $page_result[$i] = callApi(MOVIEDB_URL."search/movie?query=".$newName."&page=".$i."&api_key=".API_KEY)->results;
    }
    $mergeResult = new stdClass;
    $mergeResult->results = call_user_func_array('array_merge', $page_result);
    $parsedMovies = new stdClass;
    $parsedMovies->results = startWith($mergeResult,$name);
    $parsedMovies->total_page = floor((count($parsedMovies->results)/$GLOBALS['nbPerPage']))+1;
    return $parsedMovies;
}

function searchMovieByRelativeKeyWord($word){

    $keywords = callApi(MOVIEDB_URL."search/keyword?query=".$word."&api_key=".API_KEY);
    $storeKeywords = $keywords->results;

    for($i= 1, $l = count($keywords->results); $i < $l ; $i++){
        $id = $storeKeywords[$i]->id;
        $movies[$i] = callApi(MOVIEDB_URL."keyword/".$id."/movies?api_key=".API_KEY);
    }

    for($i= 1, $l = count($movies); $i < $l ; $i++){
        if(isset($movies[$i]->results)){
            for($j= 0, $l = count($movies[$i]->results); $j < $l; $j++){
                $movieName[$i][$j] = new stdClass;
                $movieName[$i][$j]->id = $movies[$i]->results[$j]->id;
                $movieName[$i][$j]->title = $movies[$i]->results[$j]->title;
                $movieName[$i][$j]->popularity = $movies[$i]->results[$j]->popularity;
            }
        }
    }
    $storeMovies = call_user_func_array('array_merge', $movieName);

    return $storeMovies;
}


function searchCharactersMovie($requestID)
{
    $character = callApi(MOVIEDB_URL."movie/".$requestID."/credits?api_key=".API_KEY);
    if(isset($character->cast) && count($character->cast) >0)
    {
        for($i= 0 ; $i < count($character->cast) ; $i++)
        {
            if($character->cast[$i]->character != ''){
                $movieSearch[$i] = $character->cast[$i]->character;
            }
            else
            {
                $movieSearch[$i] = "The application does not have this character data";
            }
        }
    }
    else
    {
        $movieSearch[0] = "The application has no character data for this movie";
    }
  return $movieSearch;
}

//Data treatment fonctions
//Data treatment fonctions
//Data treatment fonctions
//Data treatment fonctions


function startWith($movies,$str)
{
    $parsedResults = array();
    $str = strtolower($str);
    for($i=0, $l=count($movies->results); $i < $l; $i++)
    {
        if(preg_match('/^'.$str.'/',strtolower($movies->results[$i]->title)))
        {
            array_push($parsedResults, $movies->results[$i]);
        }
    }
    return $parsedResults;
}
