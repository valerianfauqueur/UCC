<?php

$class = "sondage";
$title = "Sondage";

$errors = array();
$question = array();

if(!empty($_POST))
{
    //verify name and description
    $quizzName = strip_tags(trim($_POST["quizzName"]));
    if(!empty($quizzName))
    {
        if(strlen($quizzName) > 50)
        {
            $errors["quizzName"] = "Your quizz name is too long max 50 characters";
        }
    }
    else
    {
         $errors["quizzName"] = "Your quizz name is empty";
    }
    unset($_POST["quizzName"]);

    foreach($_POST as $key => $value)
    {
//      prevent code injection
        strip_tags(trim($key));
        strip_tags(trim($value));

        //get the type of value
        $type = substr($key,0,6);
        if(!empty($value))
        {
            if($type === "questi")
            {
                $number = preg_split('(question)', $key);
                if(strlen($value)>0 && strlen($value) <= 140)
                {
                    $question[$number[1]] = new stdClass;
                    $question[$number[1]]->question = $value;
                }
                else
                {
                    $errors["question".$number[1].""] = "The question ".$number[1]." is too long max 140 characters !";
                }
            }
            elseif($type === "answer")
            {
                $tmpsplit2 = preg_split('(answer)', $key);
                $tmpsplit = preg_split('(To)', $tmpsplit2[1]);

                if((isset($question[$tmpsplit[1]])))
                {
                    if(strlen($value)>0 && strlen($value) <= 140)
                    {
                        $question[$tmpsplit[1]]->answer[$tmpsplit[0]] = new stdClass;
                        $question[$tmpsplit[1]]->answer[$tmpsplit[0]]->answer = $value;
                    }
                    else
                    {
                        $errors["option".$tmpsplit[0]."question".$tmpsplit[1].""] = "The option ".$tmpsplit[0]." of the question is too long max 140 characters!";
                    }
                }
                else
                {
                    $errors["question".$tmpsplit[1].""] = "A question ".$tmpsplit[1]." doesn't exist can't set any options!";
                }
            }
            else
            {
                $errors["random"] = "Can't determine the type of input don't mess with the code! :'(";
            }
        }
        else
        {
            if($type === "questi")
            {
                $number = preg_split('(question)', $key);
                $errors["question".$number[1]."empty"] = "The question ".$number[1]." is empty !";
            }
            elseif($type === "answer")
            {
                $answer2 = preg_split('(answer)', $key);
                $answer = preg_split('(To)', $answer2[1]);
                $errors["answer".$answer[0]."question".$answer[1]."empty"] = "The option ".$answer[0]." of the question is empty !";
            }
            else
            {
                $errors["random"] = "Can't determine the type of input don't mess with the code! :'(";
            }
        }
    }

// verify implicit rules 2 options min
    if(!empty($question))
    {
        foreach($question as $key => $value)
        {
            if(isset($question[$key]->answer))
            {
                $numberOfOptions = count($question[$key]->answer);
                if($numberOfOptions < 2)
                {
                    $errors["notEnoughOptionsQuestion".$key] = "There is not enough options for the question ";
                }
            }
        }
    }


    if(empty($errors))
    {
        $hexagen = substr(md5(rand()), 0, 7);
        foreach($question as $key => $value)
        {
            // insert questions into bdd
            //set up values for a question
            $content = $question[$key]->question;
            // insert values into question table
            $prepare = $pdo->prepare('INSERT INTO questions (hexa, content) VALUES (:hexa, :content)');
            $prepare->bindValue('hexa', $hexagen);
            $prepare->bindValue('content', $content);
            $execute = $prepare->execute();

            //insert options into bdd
            $c = 1;
            foreach($question[$key]->answer as $key2 => $value2)
            {
                //setup value
                $answer = $value2->answer;
                //insert values into answers table
                $prepare2 = $pdo->prepare('INSERT INTO answers (hexa, content,answer_number) VALUES (:hexa, :content, :answerNb)');
                $prepare2->bindValue('hexa', $hexagen);
                $prepare2->bindValue('content', $answer);
                $prepare2->bindValue('answerNb', $c);
                $execute2 = $prepare2->execute();
                $c++;
            }
        }

        //insert quizz resume into bdd
        $prepare2 = $pdo->prepare('INSERT INTO survey (hexa, name) VALUES (:hexa, :name)');
        $prepare2->bindValue('hexa', $hexagen);
        $prepare2->bindValue('name', $quizzName);
        $execute2 = $prepare2->execute();

        $success = "true";
    }
}
