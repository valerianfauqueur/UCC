<?php if(!empty($errors)): ?>
    <section class="alert alert-danger" id="errors">
        <ul>
            <?php foreach($errors as $key => $value): ?>
                <li><?= $value ?></li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>
<form action="#" method="post" id="form-index">
    <ul>
        <li>
            <input type="text" class="quizz" name="quizzName" placeholder="Enter a name for your survey">
        </li>
        <li>
            <input type="text" class="question" name="question1" placeholder="Question">
            <ul>
                <li>
                    <div class="option-icon"></div><input type="text" name="answer1To1" class="option" placeholder="Option 1">
                </li>
                <li>
                    <div class="option-icon"></div><input type="text" name="answer2To1" class="option" placeholder="Option 2">
                </li>
                <li>
                    <div class="option-icon"></div>
                    <button class="add-option btn btn-primary">Add an option</button>
                </li>
            </ul>
        </li>
        <li>
            <input class="btn btn-success" type="submit" value="Register">
        </li>
    </ul>
</form>
<?php if(!empty($success)): ?>
    <section class="alert alert-success" id="success">
        <p>Your survey is successfully registered</p>
    </section>
<?php endif; ?>
