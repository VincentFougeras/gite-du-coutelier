@extends('app')

@section('content')


    <div class="row">

        <div class="col-md-8">

            <div>
                <div id="carousel-gite" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @for ($i = 0; $i < 6; $i++)
                            <li data-target="#carousel-gite" data-slide-to="{{ $i }}" {!! $i == 0 ? 'class="active"' : '' !!}></li>
                        @endfor
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        @for ($i = 1; $i <= 6; $i++)
                            <div class="item {{ $i == 1 ? 'active' : '' }}">
                                <img src="{!! asset('images/carousel/chalet1' . $i . '.jpg') !!}" alt="">
                                <div class="carousel-caption">
                                </div>
                            </div>
                        @endfor
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
                        <select class="form-control" id="place" name="place">
                            <option value="1">Chalet 1</option>
                            <option value="0" disabled>Chalet 2 (pas encore disponible)</option>
                        </select>
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
                <h2>Le gîte du Coutelier à Fougaron</h2>
                <p>Situé à <strong>Fougaron</strong>, dans la <strong>vallée de l’Arbas</strong>, à 100 km de Toulouse, 30 km de Saint Gaudens,
                    et limitrophe au département de l’Ariège,
                    le gîte du Coutelier vous attend dans un <strong>paysage champêtre</strong> de moyenne montagne, surplombé par son massif culminant à plus de 1500m d’altitude.</p>
                <p>Au <strong>bord du ruisseau</strong> de la Bouchot, c’est un ancien chalet  rénové. Jardin en partie clos, terrasse privative, aire de stationnement.</p>
                <p>Au cœur du pays de l’Ours, dans une <strong>nature préservée</strong>, vous pourrez faire de <strong>nombreuses activités</strong> :</p>
                    <ul>
                        <li>Randonnées pédestres et équestres</li>
                        <li>Spéléologie</li>
                        <li>Parapente</li>
                        <li>Escalade</li>
                        <li>VTT sur des sentiers balisés</li>
                        <li>Trottinette tout terrain</li>
                        <li>Pêche</li>
                        <li>Raquettes à neige, ski (37km de la station du Mourtis)</li>
                    </ul>
                <p>Les <strong>gourmands</strong> pourront se restaurer à l’Auberge de Fougaron.</p>
                <p>Pour ceux qui recherchent la <strong>détente</strong>, le Salinea Spa de Salies du Salat vous accueillera, ou encore l’établissement de cure thermale.
                    Vous pourrez terminer votre soirée au <strong>casino</strong> de Salies du Salat (17 km).</p>

                <p class="bg-primary"><span class="glyphicon glyphicon-bell"></span><span class="text">Ouverture du second chalet en juillet</span></p>
                <p class="bg-primary"><span class="glyphicon glyphicon-bell"></span><span class="text">Ouverture d'un spa en septembre</span></p>
            </div>

            <div>
                <h2>Infos pratiques</h2>
                <p><span class="glyphicon glyphicon-euro"></span>400€ la semaine en pleine saison (été), 300€ la semaine hors saison (hiver)</p>
                <p class="text-info">Hors saison, vous pouvez réserver pour un week-end (200€).</p>
                <p><span class="glyphicon glyphicon-user"></span>Capacité : 4 personnes</p>
                <p><span class="glyphicon glyphicon-home"></span>Séjour avec coin cuisine équipée, lave-linge, TV, internet, WIFI, plancha</p>
                <ul>
                    <li>1ère chambre à coucher 1 lit double</li>
                    <li>2nd chambre à coucher 1 lit double</li>
                    <li>WC indépendant</li>
                    <li>Salle de bain avec douche</li>
                    <li>Surface : 40 m²</li>
                </ul>
                <p>Pour plus d’informations : <strong>06 64 46 95 18</strong> ou <strong>06 17 68 68 32</strong>, ou bien <a href="{{ URL::to('/contact') }}">contactez-nous par mail</a></p>
                <p>Disponibilité : toute l’année, voir le tableau des réservations.</p>
            </div>

            <div>
                @for ($i = 1; $i <= 9; $i++)
                    <div class="img-thumbnail">
                        <a href="#" class="pop">
                            <img width="120" src="{!! asset('images/home_pictures/home'.$i.'.jpg') !!}"/>
                        </a>
                    </div>
                @endfor
            </div>

            <div>
                <h2>Comment s’y rendre</h2>

                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d729.6334793682765!2d0.9326417292566132!3d42.98809079869685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a8c2ef9672e0ef%3A0x25f0bccdaa071128!2s101-67+Matay%2C+31160+Fougaron!5e0!3m2!1sfr!2sfr!4v1524906825786" width="100%" height="450" frameborder="0" style="border:0"></iframe>

                <p>En venant de TARBES ou de TOULOUSE :</p>
                <ul>
                    <li>A64, sortie 20 ST GIRONS</li>
                    <li>D117, suivre la direction ST GIRONS, traversez SALIES DU SALAT</li>
                    <li>D117, à la sortie de MANE prendre la direction CASTELBIAGUE (D13)</li>
                    <li>D13, dans CASTELBIAGUE, après l'église, continuer tout droit sur la D13, direction RIBEREUILLE, BARAT, ARBAS</li>
                    <li>Traverser RIBEREUILLE, BARAT, ARBAS</li>
                    <li>Dans ARBAS, prendre la route à gauche de la Mairie (D13), direction FOUGARON</li>
                    <li>Continuer sur la D13, et à l’entrée de FOUGARON, prendre la troisième à gauche, juste après le petit pont en pierre et le banc</li>
                    <li>Monter sur 50 mètres jusqu’aux boîtes aux lettres, tourner à gauche</li>
                    <li>Monter encore sur 50 mètres et vous serez arrivés à destination</li>
                </ul>
            </div>
            <hr>
            <div class="reseaux-sociaux">
                <h2>Les réseaux sociaux</h2>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist" id="mytabs">
                    <li role="presentation" class="active"><a href="#youtube-tab" aria-controls="youtube-tab" role="tab" data-toggle="tab">Youtube</a></li>
                    <li role="presentation"><a href="#twitter-tab" aria-controls="twitter-tab" role="tab" data-toggle="tab">Twitter</a></li>
                    <li role="presentation"><a href="#facebook-tab" aria-controls="facebook-tab" role="tab" data-toggle="tab">Facebook</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="youtube-tab">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/zJa4m3c8wYM?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="twitter-tab">
                        <div>
                            <a class="twitter-timeline" data-lang="fr" href="https://twitter.com/GiteduCoutelier?ref_src=twsrc%5Etfw">Tweets by GiteduCoutelier</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="facebook-tab">
                        <div class="fb_embed">
                            <iframe class="fb_embed_large" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fgiteducoutelier0%2F&tabs=timeline&width=500&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=182882132123587" width="500" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                            <iframe class="fb_embed_small" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fgiteducoutelier0%2F&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=182882132123587" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.row -->
    @include('home.script-date')

    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <img src="" class="imagepreview" style="width: 100%;" >
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('.pop').on('click', function(e) {
                e.preventDefault();
                $('.imagepreview').attr('src', $(this).find('img').attr('src'));
                $('#imagemodal').modal('show');
            });
        });
    </script>
@endsection
