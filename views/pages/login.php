<?php
if(empty($error)){ ?>
    <p>processing login</p>
<?php } else { ?>
<div class="alert alert-danger">
    <?php foreach($error as $key => $value): ?>
        <p><?=$value?></p>
    <?php endforeach; ?>
</div>
<?php } ?>


