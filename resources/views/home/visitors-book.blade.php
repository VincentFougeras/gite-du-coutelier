@extends('app')

@section('content')

    <h1>Tous les avis</h1>

    @include('flash')

    @if(Auth::check())

        {!! Form::open(array('url' => '/visitors-book', 'method' => 'post')) !!}

        <div class="form-group">
            {!! Form::label('book_content', 'Ajouter un avis :') !!}
            {!! Form::textarea('book_content', null, ['class' => 'form-control', 'rows' => '4']) !!}
        </div>
        <div>{!! Form::submit('Ajouter', ['class' => 'btn btn-primary']) !!}</div>

        {!! Form::close() !!}
    @endif()

    @foreach($books as $book)
        <h3>{{ $book->user->name }}</h3>
        <p>{{ $book->content }}</p>
        <p>{{ $book->created_at->diffForHumans() }}</p>

        @if(Auth::check() && ($book->user->id === Auth::user()->id || Auth::user()->is_admin))
            {!! Form::open(['method' => 'DELETE', 'url' => ['visitors-book', $book->id]]) !!}
            {!! Form::submit('Supprimer l\'avis', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        @endif
    @endforeach
    <!-- Pagination (10 items per page) -->
    {{ $books->links() }}

@endsection
