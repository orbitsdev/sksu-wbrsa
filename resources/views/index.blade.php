



<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Laravel</title>

    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />



    @include('styles.welcomepage.style')
    @include('styles.loginpages.style')
    @include('styles.admin.style')

    <link rel="stylesheet" href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css">


    <style>
        .sksu-logo {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sksu-logo img {
            width: 40px;
            height: 40px;
            margin-right: 8px;
        }

        .form-dialog-header{

            background:#429460 !important;
            color:white !important;
            padding: 20px;
            }
{{--  
            .filepond--root {

                overflow-y: auto; 
            }
            .filepond--item {
                width: calc(50% - 0.5em);
            }         --}}
            
            .filepond--fullsize-overlay{
                z-index: 100000 !important;
            }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div id="app">
        <App />
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @include('styles.admin.scripts')
    @include('styles.welcomepage.scripts')
   


</body>

</html>
