<?php if(isset($_SESSION["accessLevel"]) && $_SESSION["accessLevel"] == 1){ ?>
<!-- Page content -->
<div class="container-fluid">
    <div class="row">
         <!-- Col gauche-->
        <div class="col-sm-3">
            <a href="#"><strong><i class="glyphicon glyphicon-wrench"></i> Administrator Panel</strong></a>
            <hr>
            <ul class="nav nav-stacked">
                <li class="nav-header"> <a href="#" data-toggle="collapse" data-target="#userMenu">Navigation <i class="glyphicon glyphicon-chevron-down"></i></a>
                    <ul class="nav nav-stacked collapse in" id="userMenu">
                        <li class="active"><a href="<?= URL?>"><i class="glyphicon glyphicon-cog"></i> Home</a></li>
                        <li><a href="<?= URL?>secretucc"><i class="glyphicon glyphicon-cog"></i> Manager</a></li>
                        <li><a href="<?= URL?>login<?php echo "?url=http://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>"><i class="glyphicon glyphicon-cog"></i> Login</a></li>
                        <li><a href="<?= URL?>logout<?php echo "?url=http://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>"><i class="glyphicon glyphicon-cog"></i> Log Out</a></li>
                    </ul>
                </li>
            </ul>
            <hr>
            <a href="#"><strong><i class="glyphicon glyphicon-cog"></i> Social Medias</strong></a>
            <hr>
            <ul class="nav nav-pills nav-stacked">
                <li class="nav-header"></li>
                <li><a href="https://twitter.com/" target="_blank"><i class="glyphicon glyphicon-cog"></i> Twitter</a></li>
                <li><a href="https://fr-fr.facebook.com/" target="_blank"><i class="glyphicon glyphicon-cog"></i> Facebook</a></li>
                <li><a href="https://plus.google.com/collections/featured" target="_blank"><i class="glyphicon glyphicon-cog"></i> Google+</a></li>
                <li><a href="https://www.instagram.com/" target="_blank"><i class="glyphicon glyphicon-cog"></i> Instagram</a></li>
            </ul>
             <hr>
            <a href="#"><strong><i class="glyphicon glyphicon-cog"></i> Resources</strong></a>
            <hr>
            <ul class="nav nav-pills nav-stacked">
                <li class="nav-header"></li>
                <li><a href="https://www.themoviedb.org/?language=fr" target="_blank"><i class="glyphicon glyphicon-cog"></i> Movie Database</a></li>
                <li><a href="http://docs.themoviedb.apiary.io/" target="_blank"><i class="glyphicon glyphicon-cog"></i> API Docs</a></li>
                <li><a href="https://apps.twitter.com/" target="_blank"><i class="glyphicon glyphicon-cog"></i> Apps.Twitter</a></li>
            </ul>
            <hr>
        </div>
        <!-- Col central-->
        <div id="central-panel" class="col-sm-9">
            <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i> My Manager</strong></a>
            <hr>
            <div class="row">
                <!--Message pannel-->
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                             Create Your UCC Tournament
                        </div>
                    </div>
                     <!--Message pannel End-->
                    <hr>
                     <!-- Search Bar-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4>Suggestion search</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form form-vertical">
                                <div class="control-group">
                                    <label>Research by</label>
                                    <div class="controls">
                                        <select id="type" class="form-control">
                                            <option value="keyword">Keywords</option>
                                            <option value="movie">Movie name</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label>Sort</label>
                                    <div class="controls">
                                        <select id="sort" class="form-control">
                                            <option value="popularity">Popularity</option>
                                            <option value="alphabetical">Alphabetically</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="control-group">
                                    <label>Search Bar</label>
                                    <div class="controls">
                                        <input type="text" name ='inputkeyword'  class="form-control" id="inputkeyword" placeholder="Type Here">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label></label>
                                    <div class="controls">
                                       <input type="button" id="validate" value="validate" class="btn btn-primary">
                                       <div id="loader" style="display:none" class="pull-right">
                                            <img src="src/img/loader.gif" alt="This will display an animated GIF">
                                       </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /SearchBar-->
                    </div>
                    <hr>
                    <div class="panel panel-default" id="form-modification">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4>Manual change</h4>
                            </div>
                        </div>
                        <div class="panel-body" id="manual-entries">
                            <form class="form form-vertical">
                                <div id="register" class="control-group">
                                   <input type="button" id="registerbtn" value="register" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--Search results-->
                 <!-- Col droite-->
                <div id="right-panel" class="col-md-6">
                     <div class="panel panel-default" id ="fieldResult">
                        <div class="panel-heading">
                            <h4>Suggestion Results</h4></div>
                        <div class="panel-body" id ="resultBox">
                            <div class="list-group">
                                <div class="row"  id="results">
                                    <div id="item">
                                     <!--Search results ajax call->Php-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } else { ?>
    <p>Unauthorized to access this page. <a href="<?= URL ?>">Return to home</a></p>
<?php } ?>

