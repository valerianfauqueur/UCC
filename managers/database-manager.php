<?php
require_once("../config.php");
header('Content-type:application/json');
$nbCharacter = 4;

$result = array();
$arg = array();

$pdo = $pdo;

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
    $errors = array();
    $championShip = new stdClass;
    $nbCharacter = $GLOBALS['nbCharacter'];
    if(count($data["characterID"]) == $nbCharacter)
    {
        $usedCharacterID = array();
        $matchup = array();

        //assign random characters matchup
        $i = 1;
        while(count($usedCharacterID) !== $nbCharacter)
        {
            // generating random numbers until they are not equals and not already used
            do{
            $a = rand(1,$nbCharacter);
            $b = rand(1,$nbCharacter);
            }while($a === $b || in_array($a,$usedCharacterID) || in_array($b,$usedCharacterID));

            if(!empty($data["characterName"][$a-1]) && $data["characterName"][$b-1])
            {
                $matchup[$i] = new stdClass;
                $matchup[$i]->character1 = $data["characterName"][$a-1];
                $matchup[$i]->character2 = $data["characterName"][$b-1];
                $matchup[$i]->hexa = substr(md5(rand()), 0, 7);
            }
            else
            {
                $errors["characters"] = "There is empty input of characters";
            }
            array_push($usedCharacterID, $a);
            array_push($usedCharacterID, $b);
            $i++;
        }
    }
    else
    {
        $errors["notenough"] = "Not enough characters. You must have 16 characters to create your championship";
    }
    $championShip->matchup = $matchup;
    if(!empty($data["name"]))
    {
        if(strlen($data["name"]) <= 140)
        {
            $championShip->name = $data["name"];
        }
        else
        {
            $errors["name"] = "Your name for your championship is way too long";
        }
    }
    else
    {
        $errors["name"] = "Your didn't set any name for your championship";
    }

    $championShip->hexa = substr(md5(rand()), 0, 7);

    //insert into sum up of championship
    $championShipAdd = $GLOBALS['pdo']->prepare('INSERT INTO championship (hexa, name) VALUES(:hexa, :name)');
    $championShipAdd->bindValue("hexa", $championShip->hexa);
    $championShipAdd->bindValue("name", $championShip->name);
    $execChampionShip = $championShipAdd->execute();

    for($i = 1, $l = count($championShip->matchup); $i <= $l; $i++)
    {
        $matchupAdd = $GLOBALS['pdo']->prepare('INSERT INTO matchup (hexa, hexa_matchup,character_one,character_two) VALUES(:hexa, :hexa_matchup, :character_one, :character_two)');
        $matchupAdd->bindValue("hexa", $championShip->hexa);
        $matchupAdd->bindValue("hexa_matchup", $championShip->matchup[$i]->hexa);
        $matchupAdd->bindValue("character_one", $championShip->matchup[$i]->character1);
        $matchupAdd->bindValue("character_two", $championShip->matchup[$i]->character2);
        $execMatchup = $matchupAdd->execute();
    }
    if(empty($errors))
    {
        $errors = false;
    }
    return $errors;
}

