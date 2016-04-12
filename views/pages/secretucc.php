<?php if(isset($_SESSION["accessLevel"]) && $_SESSION["accessLevel"] == 1){ ?>

<form action = '#' method= 'POST' name ='inputkeyword'>
    <div class="form-group row">
        <div class="col-lg-4">             
            <select class="form-control" id="sel1">
                <option>Search by Keyword</option>
                <option>Search by Movie Name</option>
            </select>
            <input type="text" name ='inputkeyword' class="form-control" id="inputkeyword" placeholder="type here">
        </div>
    </div>
                
    <div class="form-group row">
        <div class="col-lg-4">
            <button type="submit" class="btn btn-secondary">ok</button>
        </div>
    </div>
</form>

<?php } else { ?>
    <p>Unauthorized to access this page. <a href="<?= URL ?>">Return to home</a></p>
<?php } ?>