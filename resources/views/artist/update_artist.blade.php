@extends('layouts.master')
@section('content')
    @if(!empty($artist))
        <form action="{{route('artist.update')}}" enctype="multipart/form-data" METHOD="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $artist->id }}">
            <h4 class="text-center">Редактирование исполнителя: "{{ $artist->name }}"</h4>
            <div class="mb-3 mt-5">
                <label for="name" class="form-label">Имя исполнителя:</label>
                <input type="text" class="form-control"  autofocus name="name" value="{{ $artist->name }}">
                @error('name')
                {{ $message }}
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Изменить обложку используя внешний источник:</label>
                <input type="text" class="form-control"  name="image">
                @error('image')
                {{ $message }}
                @enderror

                <label for="image" class="form-label">Загрузить с компьютера:</label>
                <input type="file" class="form-control"  name="new_image" id="image-upload">
                @error('new_image')
                {{ $message }}
                @enderror
                <img src="{{asset('artist_image/'.$artist->image)}}" class="mt-2" id="image-preview" style="width: 18rem;">
            </div>
            <button type="submit" class="btn btn-primary mt-5">Подтвердить изменения</button>
        </form>
        </form>
    @else
        <h4>Ошибка</h4>
    @endif
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('js/scripts/image_preview.js')}}"></script>
@endsection

