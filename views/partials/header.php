<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>
        <script src="src/js/libs/jquery-2.2.3.min.js"></script>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="src/css/style.css">
    </head>
    <body class="page-<?= $class ?>">
     
        <div class="container">                
            <div class="page-header">
                <div class="spaced-row">
                    <h1>Admin-Panel</h1> 
                </div>         
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="#">UCC</a>
                        </div>
                        <ul class="nav navbar-nav">
                            <li><a href="<?= URL?>">Home</a></li>
                            <li><a href="<?= URL?>secretucc">Manager</a></li>
                            <li><a href="<?= URL?>login<?php echo "?url=http://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>">Login</a></li>
                            <li><a href="<?= URL?>logout<?php echo "?url=http://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>">Log out</a></li>
                        </ul>
                    </div>
                </nav>             
            </div>                
        </div>

