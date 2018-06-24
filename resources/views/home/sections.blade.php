@extends('app')

@section('title', '- Activités')

@section('content')

    <h1>Les activités</h1>

    @include('flash')

    @if(Auth::check() && Auth::user()->is_admin)
        <div><a href="{{ url('admin/section/add') }}" class="top-margin btn btn-primary">Ajouter une section</a></div>
        <hr/>
    @endif

    <div class="row">
        @foreach($sections as $section)
            <div class="col-lg-4 col-md-6">


                <div class="activite-section">
                    @if(Auth::check() && Auth::user()->is_admin)
                        <a href="{{ url('admin/section/'. $section->id) }}" class="btn btn-default">Modifier cette section</a>

                        {!! Form::open(['method' => 'DELETE', 'url' => ['admin/section', $section->id], 'style' => 'display:inline-block']) !!}
                        {!! Form::submit('Supprimer cette section', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    @endif
                    <div>
                        <h3>{{ $section->title }}
                            <small>{{ $section->created_at->diffForHumans() }}</small>
                        </h3>
                        <p>{!! $section->content !!}</p>
                    </div>
                    <div>
                        @if(! empty($section->image))
                            <div class="img-thumbnail">
                                <a href="{!! asset('images/activites/'.$section->image) !!}">
                                    <img class="img-responsive" src="{!! asset('images/activites/'.$section->image) !!}" alt="Activité"/>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination (10 items per page) -->
    {{ $sections->links() }}

@endsection
