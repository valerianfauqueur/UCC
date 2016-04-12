<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>
        <link rel="stylesheet" href="src/css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="src/css/style.css">
    </head>
    <body class="page-<?= $class ?>">
        <header>
            <h1>Mon Site</h1>

            <nav>
                <a href="<?= URL?>logout<?php echo "?url=http://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>">Log out</a>
                <a href="<?= URL?>login<?php echo "?url=http://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>">Login</a>
                <a href="<?= URL?>">Home</a>
                <a href="<?= URL?>secretucc">Manager</a>
            </nav>
        </header>
