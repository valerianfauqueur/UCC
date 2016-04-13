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
