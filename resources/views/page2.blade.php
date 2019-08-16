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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <style>
            html, body {
                background-color: #eee;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
        </style>
        <!-- css -->
    </head>
    <body>

        <!-- main body visible content -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Page-2</h1>
                </div>

                <div class="col-md-6">
                    <h3>Films</h3>

                    <table id="films">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Name</th>
                                <th>URL</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <div class="col-md-6">
                    <h3>Peoples</h3>
                    <table id="peoples">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Name</th>
                                <th>URL</th>
                            </tr>
                        </thead>
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
            $(document).ready( function () {

                $('#films').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("ajax-film-api") }}',
                    columns: [
                        { data: 'action'},
                        { data: 'name'},
                        { data : 'url' }
                    ]
                });

                $('#peoples').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("ajax-people-api") }}',
                    columns: [
                        { data: 'action'},
                        { data: 'name'},
                        { data : 'url' }
                    ]
                });
            });
        </script>
        <!-- page script -->
    </body>
</html>
