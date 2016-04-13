<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>
        <?php include "libs.php"; ?>
        <link rel="stylesheet" href="src/css/bootstrap/bootstrap.min.css">
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="src/css/<?= $page ?>.css">
    </head>
    <body class="page-<?= $class ?>">
    <?php
        if($adminPannel === true)
        {
            include "views/partials/header-admin.php"
        }
        else
        {
            include "views/partials/header-basic.php"
        }
    ?>






