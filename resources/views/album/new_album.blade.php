@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <form action="{{route('album.store')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <h4 class="text-center">Создание нового альбома</h4>
            <div class="mb-3 mt-5">
                <label for="name" class="form-label"> Название альбома:</label>
                <input type="text" class="form-control"  autofocus name="name" id="name_album">
                @error('name')
                {{ $message }}
                @enderror
            </div>
            <div class="mb-3">
                <label for="artist" class="form-label">Исполнитель:</label>
                <select class="form-select" aria-label="Default select example" name="artist">
                    @forelse($artists as $artist)
                        <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                    @empty

                    @endforelse
                </select>
                <span>В списке нет нужного исполнителя? Вы можете <a href="{{ route('artist.create') }}">добавить</a> его сами</span>
                @error('artist')
                {{ $message }}
                @enderror
            </div>
            <div class="mb-3">
                <label for="descr" class="form-label">Описание:</label>
                <input type="descr" class="form-control" id="descr" name="descr" >
                @error('descr')
                {{ $message }}
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Ссылка на обложку:</label>
                <input type="text" class="form-control" id="image" name="image">
                @error('image')
                {{ $message }}
                @enderror

                <label for="image" class="form-label">Или загрузите свою обложку:</label>
                <input type="file" class="form-control" id="image-upload" name="yourImage">
                @error('yourImage')
                {{ $message }}
                @enderror
                <img src="" class="mt-2" id="image-preview" style="width: 18rem;">
            </div>
            <button type="submit" class="btn btn-primary mt-2">Создать альбом</button>

        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('js/scripts/album_prefill.js')}}"></script>
@endsection
