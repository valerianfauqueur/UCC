var cache = {},
classList = "list-group-item",
ulClass = "list-movies",
nbResultPerPage = 20;
cache.keyWord = {};
cache.movie = {};

$('#validate').on('click', function() {
    var inputText = $('#inputkeyword').val();
    var selectValue = $("form div div select").val();
    if(selectValue === "keyword")
    {
        if(!cache.keyWord.hasOwnProperty(inputText))
        {
            getMoviesByRelativeKeyWord(inputText);
        }
        else
        {
            renderMoviesByRelativeKeyWord(cache.keyWord[inputText]);
        }
    }
    else if (selectValue === "movie")
    {
        if(!cache.movie.hasOwnProperty(inputText).hasOwnProperty(1))
        {
            getMovies(inputText);
        }
        else
        {
            renderMovies((cache.movie[inputText][1]));
        }
    }
});

function getMoviesByRelativeKeyWord(inputText)
{
    if(inputText.length >= 4)
    {
        $.ajax({
            type: "POST",
            url: "http://localhost/uccapp/managers/api-manager.php",
            data: {
                functionname: 'searchMovieByRelativeKeyWord',
                arguments: [inputText]
            },
            success: function(data) {
                cache.keyWord[inputText] = data;
                cache.keyWord[inputText].totalPage = Math.floor(data.length/nbResultPerPage);
                renderMoviesByRelativeKeyWord(data);
            }
        });
    }
}

function renderMoviesByRelativeKeyWord(movies)
{
    $(".list-movies").empty();
    $("#test").empty();
    for(var i = 0, l=movies.length; i < l; i++)
    {
        $("#item").append("<ul id='"+movies[i].id+"first'"+"class='"+ulClass+"'></ul>");
        $("#"+movies[i].id+"first").append( "<li id="+movies[i].id+" class="+classList+" href= "+"#"+movies[i].id+"second"+">"+movies[i].title+"</li>")
        $("#"+movies[i].id).append("<div id="+movies[i].id+"second"+"></div> ");
        $(".list-group-item").attr("data-toggle","collapse");
        $("#"+movies[i].id+"second").addClass("panel-collapse collapse");
    }
}

function getMovies(inputText,page2)
{
   var page = page2 ? page2 : 1;
   $.ajax({
           type: "POST",
           url: "http://localhost/uccapp/managers/api-manager.php",
           data: {
               functionname: 'searchMovies',
               arguments: [inputText, page]
           },
           success: function(data) {
               cache.movie[inputText] = {};
               cache.movie[inputText][page] = data.results;
               cache.movie[inputText].totalPage = data.total_page;
               renderMovies(data.results);
           },
            error: function(e){
                console.log(e.responseText);
            }
    });
}

function renderMovies(movies)
{
    console.log(movies);
    $(".list-movies").empty();
    for(var i = 0, l = movies.length; i < l; i++)
    {
        $("#test").append("<span>"+movies[i].title+"</span><br>");
    }
}

$("#results").on('click', '.list-movies', function() {
    var context = $(this);
    var inputText = $(this).children(":first").attr('id');
    var target = $(this).children(":first");
    var actualTarget = $(target).children(":first");
    getCharacters(inputText,actualTarget,context);
});

function getCharacters(inputText,el,context)
{
    $.ajax({
            type: "POST",
            url: "http://localhost/uccapp/managers/api-manager.php",
            data: {
                functionname: 'searchCaracterMovie',
                arguments: [inputText]
            },
            success: function(data) {
                renderCharacters(data,el,context);
            },
            error: function(e){
            console.log(e);
            }
    });
}

function renderCharacters(characters,el,elparent)
{
    var content = "";
    console.log(characters);console.log(elparent);
    for(var i = 0; i < characters.length; i++)
    {
        content = content + "<li class='list-group-item'>"+ characters[i] +"</li>";
    }
    var previousHeight = elparent.parent().height();
    content = $(content);
    content.appendTo(el).hide();
    var newHeight = elparent.parent().height();

    elparent.animate({
        height:newHeight
    }, "fast", function(){
        elparent.height("auto");
    });
    content.slideDown();
    elparent.removeClass('list-movies');
}
