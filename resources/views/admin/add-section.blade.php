@extends('app')

@section('content')

    <h1>Ajout d'une section</h1>

    @include('flash')

    {!! Form::open(array('url' => '/admin/section', 'method' => 'post', 'files' => true)) !!}


    <div class="form-group">
        {!! Form::label('title', 'Titre :') !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('section_content', 'Contenu :') !!}
        <span id="btnedit-link" title="Insérer un lien"><i class="glyphicon glyphicon-link"></i></span>
        <span id="btninsert" title="Insérer un saut de ligne"><i class="glyphicon glyphicon-download-alt"></i></span>
        {!! Form::textarea('section_content', null, ['id' => 'section_content', 'class' => 'form-control', 'rows' => '4']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('content_preview', 'Aperçu :') !!}
        <div id="content_preview" class="form-control"></div>
    </div>

    <div class="form-group">
        <label for="id_scan">Image (optionnel)
            <span class="text-muted">(Formats acceptés : JPEG, PNG. Taille maximale : 5 Mo)</span></label>
        {!! Form::file('image', ['accept' => 'image/*']) !!}
    </div>

    <div>{!! Form::submit('Ajouter', ['class' => 'btn btn-primary']) !!}</div>

    {!! Form::close() !!}

    @include('admin.section-script')


@endsection