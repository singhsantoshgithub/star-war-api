<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Star War API</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Fonts -->
        <!-- css -->
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .people-result, .film-result{
                border: 5px solid #000;
                padding: 20px;
                text-align: left;
                height: 400px;
                overflow-y: scroll;
            }

            pre{
                margin: 0;
                height: 100%;
            }
        </style>
        <!-- css -->
    </head>
    <body>

        <!-- main body visible content -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Page-1</h1>
                </div>

                <div class="col-md-5 text-center">
                    <p>
                        https://swapi.co/api/people/
                        <input type="text" class="people-input" name="people" placeholder="1">
                        <button class="btn people">Pull People</button>
                    </p>

                    <div>
                        <h4>Response</h4>
                        <div class="people-result">
                            <pre></pre>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn save-people">Save Data</button>
                    </div>

                    <table id="peoples" class="text-left">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Name</th>
                                <th>URL</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>

                <div class="col-md-offset-2 col-md-5 text-center">
                    <p>
                        https://swapi.co/api/film/
                        <input type="text" class="film-input" name="film" placeholder="1">
                        <button class="btn film">Pull Film</button>
                    </p>

                    <div>
                        <h4>Response</h4>
                        <div class="film-result">
                            <pre></pre>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn save-film">Save Data</button>
                    </div>

                    <table id="films" class="text-left">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Name</th>
                                <th>URL</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>

            </div>
        </div>
        <!-- main body visible content -->


        <!-- page script -->
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
        <script src='//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'></script>

        <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>
        <script>

            $(document).ready(function(){

                // datatables

                $('#films').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("ajax-film-db") }}',
                    columns: [
                        {data: 'action'},
                        {data: 'name'},
                        {data : 'url'}
                    ]
                });

                $('#peoples').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("ajax-people-db") }}',
                    columns: [
                        {data: 'action'},
                        {data: 'name'},
                        {data : 'url'}
                    ]
                });

                // bring people information from api

                $('.people').on('click', function(){
                    var people = $('.people-input').val();
                    var api_url = 'https://swapi.co/api/people/' + people;

                    if( people != ''){
                        $.ajax({
                            url : '{{ route("get-people") }}',
                            method : 'POST',
                            data: {
                                '_token' : '{{ csrf_token() }}',
                                'api_url' : api_url
                            },
                            dataType: 'json',
                            success : function( result ){
                                console.log( result );
                                $('.people-result pre').html('');
                                $('.people-result pre').html(JSON.stringify(result, undefined, 2));
                            },
                            error: function( result ){
                                console.log( result );
                            }
                        });
                    }else{
                        alert('value is required to find character');
                    }

                });

                // bring film information from api

                $('.film').on('click', function(){
                    var film = $('.film-input').val();
                    var api_url = 'https://swapi.co/api/films/' + film;

                    if( film != ''){
                        $.ajax({
                            url : '{{ route("get-film") }}',
                            method : 'POST',
                            data: {
                                '_token' : '{{ csrf_token() }}',
                                'api_url' : api_url
                            },
                            dataType: 'json',
                            success : function( result ){
                                console.log( result );
                                $('.film-result pre').html('');
                                $('.film-result pre').html(JSON.stringify(result, undefined, 2));
                            },
                            error: function( result ){
                                console.log( result );
                            }
                        });
                    }else{
                        alert('value is required to find film');
                    }

                });

                // save people in database

                $('.save-people').on('click', function(){

                    var people = $('.people-input').val();
                    var api_url = 'https://swapi.co/api/people/' + people;

                    if( people != ''){
                        $.ajax({
                            url : '{{ route("save-people") }}',
                            method : 'POST',
                            data: {
                                '_token' : '{{ csrf_token() }}',
                                'api_url' : api_url
                            },
                            success : function( result ){

                                $("#peoples").DataTable().destroy();

                                $('#peoples').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    ajax: '{{ route("ajax-people-db") }}',
                                    columns: [
                                        {data: 'action'},
                                        {data: 'name'},
                                        {data : 'url'}
                                    ]
                                });

                                alert( result.message );
                            },
                            error: function( result ){
                                console.log( result );
                            }
                        });
                    }else{
                        alert('value is required to find people');
                    }

                });

                // save film in database

                $('.save-film').on('click', function(){

                    var film = $('.film-input').val();
                    var api_url = 'https://swapi.co/api/films/' + film;

                    if( film != ''){
                        $.ajax({
                            url : '{{ route("save-film") }}',
                            method : 'POST',
                            data: {
                                '_token' : '{{ csrf_token() }}',
                                'api_url' : api_url
                            },
                            success : function( result ){

                                $("#films").DataTable().destroy();

                                $('#films').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    ajax: '{{ route("ajax-film-db") }}',
                                    columns: [
                                        {data: 'action'},
                                        {data: 'name'},
                                        {data : 'url'}
                                    ]
                                });

                                alert( result.message );
                            },
                            error: function( result ){
                                console.log( result );
                            }
                        });
                    }else{
                        alert('value is required to find film');
                    }

                });

            });

        </script>
        <!-- page script -->
    </body>
</html>

