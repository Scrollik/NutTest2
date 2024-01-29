@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <label for="artist" class="form-label">Поиск по исполнителям:</label>
            <form action="{{route('album.index')}}" method="GET">
                @csrf
                <select class="form-select" name="artist">
                    @forelse($artists as $artist)
                        <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                    @empty
                    @endforelse
                </select>
                <button class="btn btn-primary mt-2">Поиск</button>
                <a href="{{ route('album.index') }}" class="btn btn-danger mt-2">Сбросить</a>
            </form>
        @forelse($albums as $album)
            <div class="col-sm-4 mt-2">
            <div class="card" style="width: 18rem;">
                <img src="{{asset('album_image/'.$album->image)}}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{$album->name}}</h5>
                    <p class="card-text">Исполнитель: {{$album->artist->name}}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Описание: альбом исполнителя {{$album->description}}</li>
                </ul>
                <div class="card-body">
                    @auth()
                    <a href="{{route('album.edit',$album->id)}}" class="card-link btn btn-primary">Редактировать</a>
                    <form action="{{route('album.destroy',$album->id)}}" METHOD="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mt-2">Удалить</button>
                    </form>
                    @endauth
                </div>
            </div>
            </div>
        @empty
            <h4 class="text-center">В нашей базе данных нет добавленных пластинок</h4>
        @endforelse
        </div>
        {{ $albums->links() }}
    </div>
@endsection
