<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <meta charset="UTF-8">

    <title>SearchPage</title>

    <style type="text/css">
    form{
    padding: 50px;
    text-align: left;
    margin: auto;
    display: table;
    }
    #entered_text{
        width: 800px;
        height: 50px;
        border-radius: 25px;
    }
    #button{
        width: 100px;
        height: 50px;
        border-radius: 25px;
    }
    textarea,#buttonNotes {

    display: block;
    margin-left: auto;
    margin-right: auto;
}
#retrieve{
    margin-left: 380px;
    width: 400px;
    border-radius: 25px;
    height: 50px;
}
#buttonRetrieve{
    border-radius: 25px;
    height: 50px;
}
    </style>
</head>
<body>
<br/>
<h1  align="center">Welcome to GUTINDEX database from 1996 to 2020</h1>
<form name="search">
    <input type="text" name="entered_text" id="entered_text"/> &nbsp;
    <input id="button" type="button" value="SEARCH">
</form>

<table id="listBooks" class="table">
    <thead>
        <tr>
          <th>Book Name</th>
          <th>Author Name</th>
        </tr>
      </thead>
      
</table>
<h2 id="Error" align="center">There are no matching records</h2>
<textarea rows="3" cols="100" id="enter_notes"></textarea><br/>
<input id="buttonNotes" type="button" value="Submit Note"><br/>

<input type="text" id="retrieve" name="retrieve" placeholder="  Enter the keywords to fetch a note"/>
<input type="button" id="buttonRetrieve" value = "Retrieve Notes">
<br/><br/>
<table id="notesList" class="table">
    <thead>
        <th width="auto">
          Note Number
        </th>
        <th width="auto">
          Content
        </th>
        </thead>
</table>

<script>

    
    var err = $('#Error');
    err.hide();
    var table=$('#listBooks');
    table.hide();

    $("#enter_notes").hide();
    $('#buttonNotes').hide();
    $('#retrieve').hide();
    $('#buttonRetrieve').hide();
    $('#notesList').hide();





        function viewTable(object= null){
            obj=JSON.parse(object);

            err.hide();
            var i,j,val;
            if(obj.length!=0){  

            $("#listBooks tr").empty();
            
            $('#listBooks tr:last').after('<tr><td>'+'Book Name'+'</td><td>'+'Author Name'+'</td></tr>');

            for(i = 0; i<obj.length;i++){
                val = obj[i];
                if(i%2==0)
                    $('#listBooks tr:last').after('<tr class="info"><td>'+val.book_name+'</td><td>'+val.author_name+'</td></tr>');
                else
                    $('#listBooks tr:last').after('<tr class="warning"><td>'+val.book_name+'</td><td>'+val.author_name+'</td></tr>');
            }
            table.show();
            $("#enter_notes").show();
            $('#buttonNotes').show();
            $('#retrieve').show();
            $('#buttonRetrieve').show();
        }

        else{
            $("#enter_notes").hide();
            $('#buttonNotes').hide();
            $('#retrieve').hide();
            $('#buttonRetrieve').hide();
            $('#notesList').hide();
            table.hide();
            err.show();
        }
    }

        $('#button').click( function(){
        var text=$('#entered_text').val();
        var resp = $.ajax({
                    url: 'http://54.152.253.247:5001/service',
                    data: {'entered_text':text,'task':'searching'},
                    dataType: 'json',
                    type: 'GET',
                    async: false,
                    beforeSend: function (x) {
                        if (x && x.overrideMimeType) {
                            x.overrideMimeType("application/j-son;charset=UTF-8");
                        }
                    },
                    success: function (response) {
                    },
                    error: function (error) {
                    }
                });            
                viewTable(resp.responseJSON);
            
    })


    $('#buttonNotes').click( function(){
        var text=$('#entered_text').val();
        var content=$('#enter_notes').val();
        var resp = $.ajax({
                    url: 'http://54.152.253.247:5001/service',
                    data: {'type':'Submission','added_notes':content,'keyword':text,'task':'addnotes'},
                    dataType: 'json',
                    type: 'GET',
                    async: false,
                    beforeSend: function (x) {
                        if (x && x.overrideMimeType) {
                            x.overrideMimeType("application/j-son;charset=UTF-8");
                        }
                    },
                    success: function (response) {
                    },
                    error: function (error) {
                    }
                });
                window.alert("Note added succesfully");
            
    })


    function viewNotes(object){
        $("#notesList tr").empty();
		$('#notesList tr:last').after('<tr class = "success"><td>'+'Note Number'+'</td><td>'+'Content'+'</td></tr>');

        for(i = 0; i<object.length;i++){
            $('#notesList tr:last').after('<tr><td>'+'Note '+i+'</td><td>'+object[i]+'</td></tr>');  
            }
            $('#notesList').show();
    }

    $('#buttonRetrieve').click( function(){
        var retrieve_text=$('#retrieve').val();
        var resp = $.ajax({
                    url: 'http://54.152.253.247:5001/service',
                    data: {'type':'Retrieval','retrieve_keyword':retrieve_text,'task':'addnotes'},
                    dataType: 'json',
                    type: 'GET',
                    async: false,
                    beforeSend: function (x) {
                        if (x && x.overrideMimeType) {
                            x.overrideMimeType("application/j-son;charset=UTF-8");
                        }
                    },
                    success: function (response) {
                    },
                    error: function (error) {
                    }
                });
                    viewNotes(resp.responseJSON);
    })

</script>
</body>
</html>