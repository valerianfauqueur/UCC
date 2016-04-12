$('#inputkeyword').on('keyup', function() {
    var inputText = this.value;
    console.log(inputText);
    if(inputText.length >= 4)
    {
        $.ajax({
            type: "POST",
            url: "http://localhost/uccapp/managers/api-manager.php",
            data: {
                functionname: 'searchMovies',
                arguments: [inputText]
            },
            success: function(data) {
                console.log(data);
                
                var movies = data.result.results;
                $("#inputkeyword").empty();
                for(var i = 0, l = movies.length; i < l; i++)
                {
                    $("#inputkeyword").append("<span>"+movies[i].title+"</span><br>");
                }
            },
            error: function(e){
                console.log(e.responseText);
            }
        });
    }
});