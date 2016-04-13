<?php

require_once("../config.php");
header('Content-type:application/json');

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
            $result = isset($arg[1]) ? searchMovies($arg[0],$arg[1]) : searchMovies($arg[0]);
        break;
        case "searchMovieByRelativeKeyWord":
            $result = searchMovieByRelativeKeyWord($arg[0]);
        break;
        case "searchCaracterMovie":
            $result = searchCaracterMovie($arg[0]);
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

function searchMovies($name,$page = 1)
{
    $newName = str_replace(' ', '%20', $name);
    $url = MOVIEDB_URL."search/movie?query=".$newName."&page=".$page."&api_key=".API_KEY;
    $movieResults = callApi($url);
    $organizedMovies = new stdClass;
    $organizedMovies->total_page = $movieResults->total_pages;
    $parsedMovies = startWith($movieResults,$name);
    $organizedMovies->results = organizeByPopularity($parsedMovies);
    return $organizedMovies;
}


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

function organizeByPopularity($movies)
{
    usort($movies, "cmp");
    $organizedMovies = new stdClass;
    $organizedMovies = $movies;
    return $organizedMovies;
}

function cmp($a, $b)
{
    return ($a->popularity > $b->popularity) ? -1 : 1;
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
                $movieName[$i][$j]->title = $movies[$i]->results[$j]->original_title;
            }
        }
    }
    $storeMovies = call_user_func_array('array_merge', $movieName);
    return $storeMovies;
}


function searchCaracterMovie($requestID)
{
    $character = callApi(MOVIEDB_URL."movie/".$requestID."/credits?api_key=".API_KEY);
    if(isset($character->cast))
    {
        for($i= 0 ; $i < sizeof($character->cast) ; $i++)
        {
            if($character->cast[$i]->character != ''){
                $movieSearch[$i] = $character->cast[$i]->character;
            }
        }
    }
  return $movieSearch;
}

function limit($array,$start,$end)
{
    // substract one so you can query 1 to 20 and not 0 to 19
    $start = $start - 1;
    return array_splice($array,$start,$end);
}

/*
function searchAllMoviesAndCharacter($word){

    $keywords = callApi('http://api.themoviedb.org/3/search/keyword?query='.$word.'&api_key=e7ba6516f7ea468fdedc6b919afbe1ad');
    $storeKeywords = $keywords->results;

    for($i= 1 ; $i < sizeof($keywords->results) ; $i++){
        $id = $storeKeywords[$i]->id;
        $movies[$i] = callApi('http://api.themoviedb.org/3/keyword/'.$id.'/movies?api_key=e7ba6516f7ea468fdedc6b919afbe1ad');
    }

    for($i= 1 ; $i < sizeof($movies) ; $i++){
        if(isset($movies[$i]->results)){
            for($j= 0 ; $j < sizeof($movies[$i]->results); $j++){
                $movieName[$i][$j] = new stdClass ;
                $movieName[$i][$j]->id = $movies[$i]->results[$j]->id;
                $movieName[$i][$j]->title = $movies[$i]->results[$j]->original_title;
            }
        }
    }
    $storeMovies = call_user_func_array('array_merge', $movieName);

    for($i= 0 ; $i < sizeof($storeMovies) ; $i++){
        $character = callApi('http://api.themoviedb.org/3/movie/'.$storeMovies[$i]->id.'/credits?api_key=e7ba6516f7ea468fdedc6b919afbe1ad');

        if(isset($character->cast)){
            for($j= 0 ; $j <  sizeof($character->cast) ; $j++){
                if($character->cast[$j]->character != ''){
                    $storeMovies[$i]->character[$j]= $character->cast[$j]->character;
                }
            }
        }
    }
    return $storeMovies;
 }
*/
