@extends('app')

@section('content')

    @include('flash')

    @if(Auth::check() && Auth::user()->is_admin)
        <div><a href="{{ url('admin/section/add') }}" class="btn btn-default">Ajouter une section</a></div>
    @endif

    <?php $cpt = 0; ?>
    @foreach($sections as $section)

        @if(Auth::check() && Auth::user()->is_admin)
            <a href="{{ url('admin/section/'. $section->id) }}" class="btn btn-default">Modifier cette section</a>

            {!! Form::open(['method' => 'DELETE', 'url' => ['admin/section', $section->id], 'style' => 'display:inline-block']) !!}
            {!! Form::submit('Supprimer cette section', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        @endif

        <div class="row">
            <div class="activite-section col-md-8 {{ $cpt % 2 == 1 ? 'col-md-push-4' : '' }}">
                <h3>{{ $section->title }}
                    <small>{{ $section->created_at->diffForHumans() }}</small>
                </h3>
                <p>{!! $section->content !!}</p>
            </div>
            <div class="col-md-4 {{ $cpt % 2 == 1 ? 'col-md-pull-8' : '' }}">
                @if(! empty($section->image))
                <div class="img-thumbnail">
                    <a href="{!! asset('images/activites/'.$section->image) !!}">
                        <img class="img-responsive" src="{!! asset('images/activites/'.$section->image) !!}" alt="Activité"/>
                    </a>
                </div>
                @endif
            </div>
        </div>

        <hr/>

        <?php $cpt++; ?>
    @endforeach
    <!-- Pagination (10 items per page) -->
    {{ $sections->links() }}

@endsection
