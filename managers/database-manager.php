<?php
require_once("../config.php");
header('Content-type:application/json');
$nbCharacter = 4;

$result = array();
$arg = array();

if(isset($_POST['functionname']))
{
    $arg0 = $_POST["arguments"];
    switch($_POST['functionname'])
    {
        case "registerChampionship":
        $result = registerChampionship($arg0);

        break;
        default:
           $result['error'] = 'Not found function '.$_POST['functionname'].'!';
    }
}

echo json_encode($result);

function registerChampionship($data)
{

    $nbCharacter = $GLOBALS['nbCharacter'];
    if(count($data["characterID"]) == $nbCharacter)
    {
        $usedCharacterID = array();
        $matchup = new stdClass;

            //assign random characters matchup
        $i = 1;
        while(count($usedCharacterID) !== $nbCharacter)
        {

            do{
            $a = rand(1,$nbCharacter);
            $b = rand(1,$nbCharacter);
            }while($a === $b || in_array($a,$usedCharacterID) || in_array($b,$usedCharacterID));

            $matchup->$i = new stdClass;
            $matchup->$i->character1 = $a;
            $matchup->$i->character2 = $b;

            array_push($usedCharacterID, $a);
            array_push($usedCharacterID, $b);
            $i++;
        }
        return $matchup;
    }
    else
    {
        $result["notenough"] = "Not enough characters. You must have 16 characters to create your championship";
    }
}

