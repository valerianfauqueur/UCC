<?php

<<<<<<< Updated upstream
$title = "Admin pannel";
$class = "admin-pannel";

=======

$class = "secretucc";
$title ="secretucc";



if(isset($_POST['inputkeyword'])){
  $myword = $_POST['inputkeyword'];
  $result = searchMovieByRelativeKeyWord($myword);
}
>>>>>>> Stashed changes

