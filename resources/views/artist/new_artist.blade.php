@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <form action="{{route('artist.store')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <h4 class="text-center">Создание нового исполнителя</h4>
            <div class="mb-3 mt-5">
                <label for="name" class="form-label"> Название исполнителя:</label>
                <input type="text" class="form-control"  autofocus name="name" id="name_artist" value="{{ old('name') }}">
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Ссылка на обложку:</label>
                <input type="text" class="form-control" id="image" name="image">
                @error('image')
                <span class="text-danger">{{ $message }}</span>
                @enderror

                <label for="image" class="form-label">Или загрузите свою обложку:</label>
                <input type="file" class="form-control"  name="yourImage">
                @error('yourImage')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                <img src="" class="mt-2" id="image-preview" style="width: 18rem;">
            </div>
            <button type="submit" class="btn btn-primary mt-5">Создать исполнителя</button>
        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('js/scripts/artist_prefill.js')}}"></script>
@endsection

