<?php

require_once("../config.php");
header('Content-type:application/json');

$result = array();

if(isset($_POST['functionname']))
{
    $arg1 = strip_tags(trim($_POST["arguments"][0]));
    switch($_POST['functionname']) {
        case "searchMovies":
            $result['result'] = searchMovies($arg1);
        break;

        default:
           $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
    }
}

echo json_encode($result);


function callApi($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $apiResult = curl_exec($curl);
    curl_close($curl);

    return $apiResult;
}

function searchMovies($name)
{
    $newName = str_replace(' ', '%20', $name);
    $url = MOVIEDB_URL."search/movie?query=".$newName."&api_key=".API_KEY;
    $movieResults = json_decode(callApi($url));
    $parsedMovies = startWith($movieResults,$name);
    $organizedMovies = organizeByPopularity($parsedMovies);
    return $organizedMovies;
}

function startWith($movies,$str)
{
    $parsedResults = new stdClass;
    $parsedResults->results = array();
    $str = strtolower($str);
    for($i=0, $l=count($movies->results); $i < $l; $i++)
    {
        if(preg_match('/^'.$str.'/',strtolower($movies->results[$i]->title)))
        {
            array_push($parsedResults->results, $movies->results[$i]);
        }
    }
    return $parsedResults;
}

function organizeByPopularity($movies)
{
    usort($movies->results, "cmp");
    $organizedMovies = new stdClass;
    $organizedMovies->results = $movies->results;
    return $organizedMovies;
}

function cmp($a, $b)
{
    return ($a->popularity > $b->popularity) ? -1 : 1;
}

function searchBar($word){

    $keywords = setCurl('http://api.themoviedb.org/3/search/keyword?query='.$word.'&api_key=e7ba6516f7ea468fdedc6b919afbe1ad');
    $storeKeywords = $keywords->results;

    for($i= 1 ; $i < sizeof($keywords->results) ; $i++){
        $id = $storeKeywords[$i]->id;
        $movies[$i] = setCurl('http://api.themoviedb.org/3/keyword/'.$id.'/movies?api_key=e7ba6516f7ea468fdedc6b919afbe1ad');
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
        $character = setCurl('http://api.themoviedb.org/3/movie/'.$storeMovies[$i]->id.'/credits?api_key=e7ba6516f7ea468fdedc6b919afbe1ad');

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
