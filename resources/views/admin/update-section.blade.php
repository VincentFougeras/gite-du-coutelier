@extends('app')

@section('content')

    <h1>Mise à jour de la section "{{ $section->title }}"</h1>

    @include('flash')

    {!! Form::open(array('url' => ['/admin/section', $section->id], 'method' => 'put', 'files' => true)) !!}


    <div class="form-group">
        {!! Form::label('title', 'Titre :') !!}
        {!! Form::text('title', $section->title, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('section_content', 'Contenu :') !!}
        <span id="btnedit-link" title="Insérer un lien"><i class="glyphicon glyphicon-link"></i></span>
        <span id="btninsert" title="Insérer un saut de ligne"><i class="glyphicon glyphicon-download-alt"></i></span>
        {!! Form::textarea('section_content', $section->content, ['id' => 'section_content', 'class' => 'form-control', 'rows' => '4']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('content_preview', 'Aperçu :') !!}
        <div id="content_preview" class="form-control"></div>
    </div>

    @if($section->image)
        <div class="row">
            <div class="form-group col-md-6">
                <label for="id_scan">Image (optionnel)
                    <span class="text-muted">(Formats acceptés : JPEG, PNG. Taille maximale : 5 Mo)</span></label>
                {!! Form::file('image', ['accept' => 'image/*']) !!}
                <p>L'image actuelle sera remplacée si une nouvelle image est renseignée.</p>
            </div>
            <div class="col-md-6">
                <p class="img-thumbnail"><img class="img-responsive" src="{!! asset('images/activites/'.$section->image) !!}" alt="Activite"/>
            </div>
        </div>
    @else
        <div class="form-group">
            <label for="id_scan">Image (optionnel)
                <span class="text-muted">(Formats acceptés : JPEG, PNG. Taille maximale : 5 Mo)</span></label>
            {!! Form::file('image', ['accept' => 'image/*']) !!}
        </div>
    @endif


    <div>{!! Form::submit('Modifier', ['class' => 'btn btn-primary']) !!}</div>

    {!! Form::close() !!}

    @include('admin.section-script')

@endsection