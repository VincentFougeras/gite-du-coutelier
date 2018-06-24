@extends('app')

@section('title', '- Livre d\'or')

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

                    <blockquote>
                        <p class="book-content">{{ $book->content }}</p>
                    </blockquote>

                    @if(Auth::check() && ($book->user->id === Auth::user()->id || Auth::user()->is_admin))
                        {!! Form::open(['method' => 'DELETE', 'url' => ['visitors-book', $book->id], 'onsubmit' => 'return confirmDeletion()']) !!}
                        {!! Form::submit('Supprimer l\'avis', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    @endif
                </div>
            @endforeach
            <!-- Pagination (10 items per page) -->
            {{ $books->links() }}

        </div>
    </div>

    <script>
        function confirmDeletion(){
            return confirm("Etes-vous sûr de vouloir supprimer cet avis ?");
        }
    </script>
@endsection
