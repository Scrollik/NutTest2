@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <form action="{{route('register.post')}}" method="POST"  class="mx-auto" novalidate>
            @csrf
            <h4 class="text-center">Регистрация</h4>
            <div class="mb-3 mt-5">
                <label for="email" class="form-label"> Email:</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autofocus name="email">
                @error('email')
                <p class="mt-2 text-sm text-danger">{{$message}} </p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль:</label>
                <input type="password"  class="form-control" id="exampleInputPassword1" name="password">
                <p class="mt-2 text-sm text-secondary">Минимум 6 символов. </p>
                @error('password')
                <p class="mt-2 text-sm text-danger">{{$message}} </p>
                @enderror
                <div class="form-group">
                    <label for="password_confirmed " class="form-label">Повторите пароль:</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password_confirmation">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-5">Зарегистрироваться</button>
        </form>
    </div>
@endsection
