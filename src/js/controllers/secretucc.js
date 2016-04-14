var cache = {},
nbResultPerPage = 10;
cache.keyWord = {};
cache.movie = {};
var resultPanel = $("#central-panel #right-panel #item");
var modificationPanel = $("#central-panel #form-modification #manual-entries");
var modificationPanelRegister = modificationPanel.find("#registerbtn");
var nbPagination = 2;

$('#validate').on('click', function() {
    var inputText = $('#inputkeyword').val();
    var typeValue = $(".panel-body .form .controls #type.form-control").val();
    var sortValue = $(".panel-body .form .controls #sort.form-control").val();
    if(inputText.length > 2)
    {
        if(typeValue === "keyword")
        {
            if(!cache.keyWord.hasOwnProperty(inputText))
            {
                getMoviesByRelativeKeyWord(inputText,sortValue);
                $('#loader').show();
            }
            else
            {
                var activePage = $("#central-panel #right-panel #item #pagination .active-page");
                renderMovies(cache.keyWord[inputText],activePage.attr("data-page"),sortValue);
            }
        }
        else if (typeValue === "movie")
        {
            if(!cache.movie.hasOwnProperty(inputText))
            {
                getMovies(inputText,sortValue);
                $('#loader').show();
            }
            else
            {
                var activePage = $("#central-panel #right-panel #item #pagination .active-page");
                renderMovies(cache.movie[inputText],activePage.attr("data-page"),sortValue);
            }
        }
    }
});

function getMoviesByRelativeKeyWord(inputText,sort)
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
            cache.keyWord[inputText].totalPage = Math.floor(data.length/nbResultPerPage)+1;
            renderMovies(data,1,sort);
            renderPages(inputText,"keyword");
        },
        error: function(e)
        {
            $('#loader').hide();
        }
    });
}


function getMovies(inputText,sort)
{
   sort = sort ? sort : "undefined";
   $.ajax({
           type: "POST",
           url: "http://localhost/uccapp/managers/api-manager.php",
           data: {
               functionname: 'searchMovies',
               arguments: [inputText]
           },
           success: function(data) {
               cache.movie[inputText] = data.results;
               cache.movie[inputText].totalPage = data.total_page;
               renderMovies(data.results,1,sort);
               renderPages(inputText, "movie");

           },
            error: function(e)
            {
                $('#loader').hide();
            }
    });
}

function renderMovies(movies,page,sort)
{
    $(".list-movies").empty();

    var sortBy = sort;
    if(sortBy === "alphabetical")
    {
        sortAlphabetically(movies);
    }
    else if (sortBy === "popularity")
    {
        sortByPopularity(movies);
    }
    movies = limit(movies, page);
    var content = "";
    for(var i = 0, l=movies.length; i < l; i++)
    {
         content += "<ul id='"+movies[i].id+"first' class='list-movies'>"+
                            "<li id='"+movies[i].id+"' class='list-group-item' data-target='#"+movies[i].id+"second' data-toggle='collapse'>"+
                                movies[i].title+
                                "<div id='"+movies[i].id+"second' class='panel-collapse collapse'></div>"+
                            "</li>"+
                        "</ul>";
    }
    resultPanel.prepend($(content));
}

$("#results").on('click', '.list-movies', function() {
    var context = $(this);
    var inputText = $(this).children(":first").attr('id');
    var target = $(this).children(":first");
    var actualTarget = $(target).children(":first");
    if(actualTarget.find(".list-group-item").length === 0)
    {
        getCharacters(inputText,actualTarget,context);
    }
});

function getCharacters(inputText,el,context)
{
    $.ajax({
            type: "POST",
            url: "http://localhost/uccapp/managers/api-manager.php",
            data: {
                functionname: 'searchCharactersMovie',
                arguments: [inputText]
            },
            success: function(data) {
                renderCharacters(data,el,context);
            },
            error: function(e)
            {
                $('#loader').hide();
            }
    });
}

function renderCharacters(characters,el,elparent)
{
    var content = "";
    for(var i = 0; i < characters.length; i++)
    {
        content = content + "<li class='list-group-item character' data-name='"+characters[i]+"'><button class='btn btn-primary characterbtn pull-left'>Add</button>"+ characters[i] +"</li>";
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
}

function renderPages(word,type,next)
{
    $('#loader').hide();
    deletePagination();
    next = next ? next : false;
    var content = "";
    if(type === "keyword")
    {
        var nbPageTotal = cache.keyWord[word].totalPage;
    }
    else if(type === "movie")
    {
        var nbPageTotal = cache.movie[word].totalPage;
    }
    if(next == false)
    {
        if(nbPageTotal <= nbPagination)
        {
            for(var i = 1, l=nbPageTotal; i <= l;i++)
            {
                content += "<button data-page='"+i+"' class='btn btn-link' onclick='setPage("+i+")'>"+i+"</button>";
            }
            $("<div id='pagination' data-type='"+type+"' data-word='"+word+"'>"+content+"</div>").appendTo(resultPanel);
        }
        else
        {
            for(var i = 1, l=nbPagination; i <= l;i++)
            {
                content += "<button data-page='"+i+"' class='btn btn-link' onclick='setPage("+i+")'>"+i+"</button>";
            }
            content += "<button class='btn btn-link' onclick='renderPages(`"+word+"`,`"+type+"`,"+i+")'>...</button>";
            $("<div id='pagination' data-type='"+type+"' data-word='"+word+"'>"+content+"</div>").appendTo(resultPanel);
        }
    }
    else
    {
        var previousnext = next-nbPagination;
        if(next+nbPagination < nbPageTotal)
        {
            if(previousnext >= 1)
            {
                content += "<button class='btn btn-link' onclick='renderPages(`"+word+"`,`"+type+"`,"+previousnext+")'>...</button>";
            }
            for(var i = next, l=next+nbPagination; i < l;i++)
            {
                content += "<button data-page='"+i+"' class='btn btn-link' onclick='setPage("+i+")'>"+i+"</button>";
            }
            content += "<button class='btn btn-link' onclick='renderPages(`"+word+"`,`"+type+"`,"+i+")'>...</button>";
            $("<div id='pagination' data-type='"+type+"' data-word='"+word+"'>"+content+"</div>").appendTo(resultPanel);
        }
        else
        {
            content += "<button class='btn btn-link' onclick='renderPages(`"+word+"`,`"+type+"`,"+previousnext+")'>...</button>";
            for(var i = next, l=nbPageTotal; i <= l;i++)
            {
                content += "<button data-page='"+i+"' class='btn btn-link' onclick='setPage("+i+")'>"+i+"</button>";
            }
           $("<div id='pagination' data-type='"+type+"' data-word='"+word+"'>"+content+"</div>").appendTo(resultPanel);
        }
    }
}

function deletePagination()
{
    var pagination = $("#central-panel #right-panel #item #pagination");
    if(pagination.length >0)
    {
        pagination.remove();
    }
}

function setPage(number)
{
    var sortValue = $(".panel-body .form .controls #sort.form-control").val();
    var pagination = $("#central-panel #right-panel #item #pagination");
    var previousActive = $("#central-panel #right-panel #item #pagination .active-page");
    var btn = $("#central-panel #right-panel #item #pagination .btn-link[data-page="+number+"]");
    if(previousActive.length >0)
    {
        previousActive.removeClass("active-page");
    }
    btn.addClass("active-page");
    type = pagination.attr("data-type");
    word = pagination.attr("data-word");
    if(type === "keyword")
    {
        var movies = cache.keyWord[word];
        renderMovies(movies,number,undefined);
    }
    else if(type === "movie")
    {
        var movies = cache.movie[word];
        renderMovies(movies,number,undefined);
    }

}

function addToCharacterPoll(character,filmid)
{
    var nbinput = modificationPanel.find(".modif-input").length;
    var input = "<div class='control-group modify-group'><input class='modif-input' type=text name='"+(nbinput+1)+":"+filmid+"' value='"+character+"'><div style='display:inline-block'>"+(nbinput+1)+"/16</div><hr>";
    modificationPanel.find("#register").before(input);
}


resultPanel.on("click", ".characterbtn", function(){
    console.log($(this).parent().attr("data-name"));
    console.log($(this).parent().parent().parent().attr("id"));
    addToCharacterPoll($(this).parent().attr("data-name"),$(this).parent().parent().parent().attr("id"));
});

modificationPanelRegister.on("click",function() {

    var getInputs = modificationPanel.find(".modif-input");
    var inputsDatas = {};
    inputsDatas.characterID = [];
    inputsDatas.characterName = [];
    inputsDatas.filmID = [];
    for(var i=0,l=getInputs.length; i<l;i++)
    {
        var splitInputName = $(getInputs[i]).attr("name").split(":");
        inputsDatas.characterID.push(splitInputName[0]);
        inputsDatas.characterName.push(getInputs.val());
        inputsDatas.filmID.push(splitInputName[1]);
    }
    console.log(inputsDatas);
    $.ajax({
            type: "POST",
            url: "http://localhost/uccapp/managers/database-manager.php",
            data: {
                functionname: 'registerChampionship',
                arguments: inputsDatas
            },
            success: function(data) {
                console.log(data);
            },
            error: function(e)
            {
                $('#loader').hide();
                console.log(e.responseText);
            }
    });
});

function sortAlphabetically(movies)
{
    movies.sort(function(a, b){ return a.title.replace(/\s/g, '').toLowerCase().localeCompare(b.title.replace(/\s/g, '').toLowerCase())});
}

function sortByPopularity(movies)
{
    movies.sort(function(a, b){ return b.popularity-a.popularity });
}

function limit(movies,page)
{
    return movies.slice((page*nbResultPerPage)-nbResultPerPage,(nbResultPerPage*page));
}
