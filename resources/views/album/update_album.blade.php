@extends('layouts.master')
@section('content')
@if(!empty($album))
    <form action="{{route('album.update')}}" enctype="multipart/form-data" METHOD="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $album->id }}">
        <h4 class="text-center">Редактирование альбома "{{ $album->name }}"</h4>
        <div class="mb-3 mt-5">
            <label for="name" class="form-label"> Название альбома:</label>
            <input type="text" class="form-control"  autofocus name="name" value="{{ $album->name }}">
            @error('name')
            {{ $message }}
            @enderror
        </div>
        <div class="mb-3">
            <label for="artist" class="form-label">Исполнитель:</label>
            <select class="form-select" aria-label="Artist" name="artist">
                @forelse($artists as $artist)
                    @if($album->artist_id === $artist->id)
                        <option selected value="{{ $artist->id }}"> {{ $artist->name }} </option>
                    @else
                        <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                    @endif
                @empty
                @endforelse
            </select>
            @error('artist')
            {{ $message }}
            @enderror
        </div>
        <div class="mb-3">
            <label for="descr" class="form-label">Описание:</label>
            <input type="text" class="form-control" value="{{ $album->description }}" name="descr" >
            @error('descr')
            {{ $message }}
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Ссылка на обложку:</label>
            <input type="text" class="form-control" value="{{ $album->image }}" name="image">
            @error('image')
            {{ $message }}
            @enderror

            <label for="image" class="form-label">Загрузить с компьютера:</label>
            <input type="file" class="form-control"  name="new_image">
            @error('new_image')
            {{ $message }}
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-5">Подтвердить изменения</button>
    </form>
    </form>
@else
    <h4>Ошибка</h4>
@endif
@endsection
