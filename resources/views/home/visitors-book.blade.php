@extends('app')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <h1>Avis des visiteurs</h1>

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
                <div class="book-section">
                    <h3>{{ $book->user->name }}
                        <small>{{ $book->created_at->diffForHumans() }}</small>
                    </h3>

                    <p class="book-content">{{ $book->content }}</p>

                    @if(Auth::check() && ($book->user->id === Auth::user()->id || Auth::user()->is_admin))
                        {!! Form::open(['method' => 'DELETE', 'url' => ['visitors-book', $book->id]]) !!}
                        {!! Form::submit('Supprimer l\'avis', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    @endif
                </div>
            @endforeach
            <!-- Pagination (10 items per page) -->
            {{ $books->links() }}

        </div>
    </div>
@endsection
