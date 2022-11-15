<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
   
    <style>
       
    </style>


    {{--  WELCOME PAGE STYLE  --}}
    @include('styles.welcomepage.style')
    {{--  LOGIN PAGE STYLE  --}}
    @include('styles.loginpages.style')

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
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div id="app">
        <App />
    </div>

    {{--  // WELCOME PAGE SCRIPT        --}}
    @include('styles.welcomepage.scripts')


</body>

</html>
