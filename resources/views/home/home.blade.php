@extends('app')

@section('content')


    <div class="row">

        <div class="col-sm-3 col-sm-offset-1 col-sm-push-8">

            <div class="sidebar-module">
                <h4>Réservation</h4>
                <a class="btn btn-primary" href="{{ URL::to('/reservation/choice') }}">Réserver</a>
            </div>

            <div class="sidebar-module">
                <h4>Dates de disponibilité</h4>
                <div>
                    {!! Form::label('place', 'Choisissez un lieu :') !!}
                    {!! Form::select('place', array(1 => 'Chalet', 0 => 'Extension'), null, ['class' => 'form-control', 'id' => 'place']) !!}
                </div>
                <div>
                    <div id="date"></div>
                </div>
            </div>

        </div><!-- /.blog-sidebar -->

        <div class="col-sm-8 col-sm-pull-4">

            <div>
                <p>Caroussel photos du gite</p>
            </div>

            <div>
                <h2>Le gite</h2>
                <p>Coordonnées</p>


                <p>Infos basiques intérieur / extérieur</p>

                <p>Types de logement</p>

                <p>Localisation</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d39266.13349984475!2d0.9073955942547899!3d42.989377283787334!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a8c2e4bddf3d6d%3A0x406f69c2f4126c0!2s31160+Fougaron!5e0!3m2!1sfr!2sfr!4v1510583832019" width="100%" height="450" frameborder="0" style="border:0"></iframe>
            </div>

            <div>
                <h2>Les lieux et dates de réservation</h2>
                <p>Périodes de l'année</p>
                <p>Dates de disponibilité (semaine, weekend)</p>
            </div>

            <div class="fb_embed">
                <iframe class="fb_embed_large" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook&tabs=timeline&width=500&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=390501848068246" width="500" data-width="500px" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                <iframe class="fb_embed_small" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=390501848068246" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
            </div>


        </div><!-- /.blog-main -->



    </div><!-- /.row -->

    @include('home.script-date')

@endsection
