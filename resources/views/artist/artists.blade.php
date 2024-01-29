@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <form action="{{route('artist.index')}}" method="GET">
            @csrf
            <input type="text" class="form-control" name="artist_name" placeholder="Поиск по имени">
            <button class="btn btn-primary mt-2">Поиск</button>
            <a href="{{ route('artist.index') }}" class="btn btn-danger mt-2">Сбросить</a>
        </form>
        <div class="row mt-2">
            @forelse($artists as $artist)
                <div class="col-sm-4">
                    <div class="card" style="width: 18rem;">
                        <img src="{{asset('artist_image/'.$artist->image)}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{$artist->name}}</h5>
                        </div>
                        <div class="card-body">
                            @auth()
                                <a href="{{route('artist.edit',$artist->id)}}" class="card-link btn btn-primary">Редактировать</a>
                                <form action="{{route('artist.destroy',$artist->id)}}" METHOD="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mt-2">Удалить</button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <h4 class="text-center">В нашей базе данных нет добавленных исполнителей</h4>
            @endforelse
        </div>
        {{ $artists->links() }}
    </div>
@endsection

