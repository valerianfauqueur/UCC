$(document).ready(function () {

    // Jquery function closest but searching in descendent
    (function ($) {
        $.fn.closest_descendent = function (filter) {
            var $found = $(),
                $currentSet = this; // Current place
            while ($currentSet.length) {
                $found = $currentSet.filter(filter);
                if ($found.length) break; // At least one match: break loop
                // Get all children of the current set
                $currentSet = $currentSet.children();
            }
            return $found.first(); // Return first match of the collection
        }
    })(jQuery);


    var formList = $("form ul");

    // delete an option or a question

    formList.on("click", "li button.delete", function (e) {
        e.preventDefault();
        var form = $("form");
        // get the type of el
        var input = $(this).parent().closest_descendent("input[type='text']");
        var type = input.attr("class");
        if (type === "question") {
            var questionNumber = parseInt(input.attr("name").charAt((input.attr("name").length - 1)));
            var question = input.parent();


            //reorganize name attribute for question after the deleted question

            var nextQuestions = question.nextAll();

            // remove the 2 last li tags because they are buttons to validate and add question
            nextQuestions.splice((nextQuestions.length - 2), nextQuestions.length);
            if (nextQuestions.length > 0) {
                for (var i = 0, l = nextQuestions.length; i < l; i++) {
                    // find the question input and replace the name attribute
                    var nextQuestionInput = nextQuestions[i].firstElementChild;
                    $(nextQuestionInput).attr("name", "question" + (questionNumber + i));
                    $(nextQuestionInput).attr("placeholder", "Question " + (questionNumber + i));

                    // find the options to that questions and replace their name attribute
                    var questionOptions = $(nextQuestions[i]).find("ul li input.option");
                    if (questionOptions.length > 0) {
                        for (var b = 0, d = 1, c = questionOptions.length; b < c; b++, d++) {
                            $(questionOptions[b]).attr("name", "answer" + d + "To" + (questionNumber + i));
                            $(questionOptions[b]).next().next().attr("name", "status" + d + "To" + (questionNumber + i));
                        }
                    }
                }
            }

            //animate the deletion of the question and form reduction

            //get the question container height
            var questionHeight = question.height();
            // get the form previous height in order to animate
            var previousFormHeight = form.height();
            // calculate the new form height to animate
            var padding = 20;
            var newFormHeight = previousFormHeight - (questionHeight + padding);
            form.animate({
                height: newFormHeight
            }, "fast", function () {
                form.height("auto");
            });
            question.slideUp(400, function () {
                question.remove();
            });
        } else if (type === "option") {
            var optionNumber = parseInt(input.attr("name").charAt(6)),
                optionContainer = $(this).parent(),
                questionInput = optionContainer.parent().closest_descendent("input[type='text']"),
                questionInputNumber = parseInt(questionInput.attr("name").charAt((questionInput.attr("name").length - 1))),
                nextOptions = optionContainer.nextAll("li");

            // remove the last element because it is the button to add

            nextOptions.splice((nextOptions.length - 1), nextOptions.length);

            //reorganize option name attribute
            if (nextOptions.length > 0) {
                for (var u = 0, v = nextOptions.length; u < v; u++) {
                    // find the question input and replace the name attribute
                    var nextOptionInput = $(nextOptions[u]).closest_descendent("input[type='text']"),
                        nextStatusInput = $(nextOptions[u]).closest_descendent("input[type='hidden']");
                    $(nextOptionInput).attr("name", "answer" + (optionNumber + u) + "To" + questionInputNumber);
                    $(nextOptionInput).attr("placeholder", "Option " + (optionNumber + u));
                    $(nextStatusInput).attr("name", "status" + (optionNumber + u) + "To" + questionInputNumber);
                }
            }

            //animate the deletion of the option

            //get the question option height
            var optionHeight = optionContainer.height();
            // get the form previous height in order to animate
            var previousFormHeight = form.height();
            // calculate the new form height to animate
            var padding = 20;
            var newFormHeight = previousFormHeight - (optionHeight + padding);
            form.animate({
                height: newFormHeight
            }, "fast", function () {
                form.height("auto");
            });
            optionContainer.slideUp(400, function () {
                optionContainer.remove();
            });
        }
    });

    //add on option button

    formList.on("click", "li ul li button.add-option", function (e) {
        e.preventDefault();
        var previousLi = $(this).parent().prev(),
            optionList = previousLi.parent(),
            question = optionList.parent().find("input.question"),
            questionNumber = question.attr("name").charAt((question.attr("name").length - 1)),
            numberOfOptions = optionList.find("li input.option").length;

        if (numberOfOptions >= 10) {
            alert("There is too many options... i can't decide anymore");
        } else {
            var content = $("<li>" +
                "<div class='option-icon'></div>" +
                "<input type='text' name='answer" + (numberOfOptions + 1) + "To" + questionNumber + "' class='option' placeholder='Option " + (numberOfOptions + 1) + "'>" +
                "<button class='btn btn-danger btn-sm delete'>X</button>" +
                "</li>");
            var form = $("form");

            // animate the form expansion and the addition of the option

            // get the form previous height in order to animate
            var previousFormHeight = form.height();

            previousLi.after(content.hide());

            // calculate the new form height to animate
            var padding = 20;
            var newFormHeight = previousFormHeight + previousLi.next().height() + padding;

            form.animate({
                height: newFormHeight
            }, "fast", function () {
                form.height("auto");
            });
            content.slideDown();
        }
    });

});
