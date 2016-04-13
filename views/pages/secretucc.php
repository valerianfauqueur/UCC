

<?php if(isset($_SESSION["accessLevel"]) && $_SESSION["accessLevel"] == 1){ ?>
<div class="container-fluid">
    <form action = '#' method= 'POST' name ='inputkeyword'>
        <div class="form-group row">
            <div class="col-lg-4">             
                <select class="form-control" id="sel1">
                    <option>Search by Keyword</option>
                    <option>Search by Movie Name</option>
                </select>
                <input type="text" name ='inputkeyword' class="form-control" id="inputkeyword" placeholder="type here">
                <div id="test"></div>
            </div>
        </div>
    </form>               
        <div id="validate">ok</div>
        <div class="row">
            <div class="col-xs-4">   
                <div id="item">
                    

                </div>
            </div>
        </div>        
</div>
<?php } else { ?>
    <p>Unauthorized to access this page. <a href="<?= URL ?>">Return to home</a></p>
<?php } ?>

