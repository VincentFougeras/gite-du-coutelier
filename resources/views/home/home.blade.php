@extends('app')

@section('content')


    <div class="row">

        <div class="col-md-8">

            <div>
                <div id="carousel-gite" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-gite" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-gite" data-slide-to="1"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="{!! asset('images/carousel/chalet-interior.jpg') !!}" alt="L'intérieur">
                            <div class="carousel-caption">
                                L'intérieur
                            </div>
                        </div>
                        <div class="item">
                            <img src="{!! asset('images/carousel/chalet-exterior.jpg') !!}" alt="L'extérieur">
                            <div class="carousel-caption">
                                L'extérieur
                            </div>
                        </div>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-gite" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-gite" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

        </div>

        <div class="col-md-4 col-lg-4 ">
            <div class="sidebar">
                <div class="sidebar-module">
                    <a class="reservation-btn btn-lg btn-block btn btn-primary btn-reserver" href="{{ URL::to('/reservation/choice') }}">Réserver</a>
                </div>
                <hr/>
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
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-8">
            <div>
                <h2>Le gîte</h2>
                <p>Le gîte se situe à Fougaron (13 rue Mozart). Fougaron est placé à 1h20 de Foix, Toulouse et Tarbes. A 40min de Saint-Gaudens.</p>


                <p>Si vous avez des questions, vous pouvez me contacter par téléphone au <strong>{{ env("PHONE_FRANCOIS") }}</strong>.</p>

                <p><i>Infos basiques intérieur / extérieur</i></p>

                <p>Le gîte comporte 2 emplacements :</p>
                <ul>
                    <li>Le châlet, qui peut accueillir jusqu'à 4 personnes</li>
                    <li>L'extension, qui peut accueillir jusqu'à 6 personnes</li>
                </ul>
                <p>Localisation</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d39266.13349984475!2d0.9073955942547899!3d42.989377283787334!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a8c2e4bddf3d6d%3A0x406f69c2f4126c0!2s31160+Fougaron!5e0!3m2!1sfr!2sfr!4v1510583832019" width="100%" height="450" frameborder="0" style="border:0"></iframe>
            </div>

            <div>
                <h2>Les lieux et dates de réservation</h2>
                <p>Le gîte est en pleine saison entre mai et septembre. Vous pouvez réserver un emplacement pour une ou plusieurs semaines quelque soit la saison.
                    De plus, en hors saison, vous pouvez réserver un week-end au chalet.</p>
            </div>

            <hr>
            <div class="fb_embed">
                <iframe class="fb_embed_large" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook&tabs=timeline&width=500&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=390501848068246" width="500" data-width="500px" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                <iframe class="fb_embed_small" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=390501848068246" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
            </div>

        </div>
    </div><!-- /.row -->
    @include('home.script-date')

@endsection
