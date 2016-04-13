 
    var classList = "list-group-item";
    var ulClass = "list-movies";
    
    $('#validate').on('click', function() {
        var inputText = $('#inputkeyword').val();
        console.log('launch');
        if(inputText.length >= 4)
        {
        console.log(inputText);
        
        var request=  $.ajax({
                type: "POST",
                url: "http://localhost/uccapp/managers/api-manager.php",
                data: {
                    functionname: 'searchMovieByRelativeKeyWord',
                    arguments: [inputText]
                },
                success: function(data) {
                    $(".list-movies").empty();
                    var movies = data;
                    console.log(movies);
                    console.log("sucess");
                    
                    $("#test").empty();
                    for(var i = 0; i < 8; i++)
                    {
                       $("#item").append("<ul id='"+movies[i].id+"first' class='list-movies'></ul>");   
                       $("#"+movies[i].id+"first").append( "<li id='"+movies[i].id+"' class='list-group-item' data-target='#"+movies[i].id+"second'>"+movies[i].title+"</li>"); 
                       $("#"+movies[i].id).append("<div id='"+movies[i].id+"second' ></div>");   
                        
                       $(".list-group-item").attr("data-toggle","collapse");
                       $("#"+movies[i].id+"second").addClass("panel-collapse collapse");            
                    }                                                        
                },
                error: function(e){
                    console.log(e);              
                }
            });       
        }
    });

    $("#results").on('click', '.list-movies', function() {
        var context = $(this);
        var inputText = $(this).children(":first").attr('id');
        var target = $(this).children(":first");
        var actualTarget = $(target).children(":first");   
        var request=  $.ajax({
                type: "POST",
                url: "http://localhost/uccapp/managers/api-manager.php",
                data: {
                    functionname: 'searchCaracterMovie',
                    arguments: [inputText]
                },
                success: function(data) {           
                    var caracter = data;
                    console.log(caracter);
                    var classLi = "list-group-item";
                    for(var i = 0; i < caracter.length; i++)
                    {               
                        actualTarget.append("<li class="+classLi+">"+ caracter[i] +"</li>");
                            
                    }
                    context.removeClass('list-movies');
                    
                        
                },
                error: function(e){
                console.log(e);        
                }
        });        
    });


                        
                        
  /*      $("#item").append("<ul id="+movies[i].id+"first"+" class='list-movies'></ul>");            */     


/*
$('#inputkeyword').on('click', function() {
    var inputText = this.value;
    if(inputText.length >= 4)
    {
    var request=  $.ajax({
            type: "POST",
            url: "http://localhost/uccapp/managers/api-manager.php",
            data: {
                functionTwo: 'searchMovieByRelativeKeyWord',
                arguments: [inputText]
            },
            success: function(data) {
                var movies = data[0];
                console.log(movies);
                $("#test").empty();
                for(var i = 0, l = movies.length; i < l; i++)
                {
                    $("#test").append("<span>"+movies[i].title+"</span><br>");
                }
            },
            error: function(e){
               
            }
        });       
    }
});
//auto complete


  

});

*/
