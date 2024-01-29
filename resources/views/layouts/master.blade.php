<!doctype html>
<html lang="ru" xmlns="http://www.w3.org/1999/html">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>NutTest</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-lg-flex justify-content-center" id="navbarNav">
            <ul class="navbar-nav text-center">
                <li class="nav-item text-center">
                    <a class="nav-link active" aria-current="page" href="{{route('album.index')}}">Список пластинок</a>
                    <a class="nav-link active" aria-current="page" href="{{route('artist.index')}}">Список исполнителей</a>
                </li>
                @auth()
                    <li class="nav-item ">
                        <a class="nav-link active" aria-current="page" href="{{route('album.create')}}">Создать альбом</a>
                        <a class="nav-link active" aria-current="page" href="{{route('artist.create')}}">Создать исполнителя</a>
                    </li>
                @endauth
                 @guest()
                <li class="nav-item ">
                    <a class="nav-link active" aria-current="page" href="{{route('login')}}">Войти</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link active" aria-current="page" href="{{route('register')}}">Регистрация</a>
                </li>
                @endguest
            </ul>
        </div>
        @auth()
        <form class="d-flex" action="{{route('logout')}}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Выйти из аккаунта</button>
        </form>
        @endauth
    </div>
</nav>

<div class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            @yield('content')
        </div>
    </div>
</div>
</div>
<script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
@yield('script')
</body>
</html>
