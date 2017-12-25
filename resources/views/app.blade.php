<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Le gîte du Coutelier</title>

    <!-- Bootstrap -->
    {{Html::style("bootstrap/css/bootstrap.min.css")}}
    {{Html::style("bootstrap/css/bootstrap-theme.min.css")}}

    {{Html::style("bootstrap/css/bootstrap-flat.min.css")}}



<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    {!! Html::script('bootstrap/js/bootstrap.min.js') !!}

    <!-- Moments.js -->
    {!! Html::script('js/moment.js') !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/locale/fr.js"></script>

    <!-- transition and collapse -->
    {!! Html::script('js/transition.js') !!}
    {!! Html::script('js/collapse.js') !!}

    <!-- Datetime picker -->
    {!! Html::script('js/bootstrap-datetimepicker.js') !!}
    {!! Html::style('css/bootstrap-datetimepicker.min.css') !!}

    <!-- Custom style for this template -->
    {!! Html::style('css/sticky-footer.css') !!}
    {!! Html::style('css/styles.css') !!}


    <!-- Stripe -->
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>


<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::to('/') }}">Le Gîte du Coutelier</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php $curr_path = Request::path(); ?>
                <li class="{{ Request::path() == '/' ? 'active' : '' }}"><a href="{{ URL::to('/') }}">Accueil</a></li>
                <li class="{{ Request::path() == 'reservation/choice' ? 'active' : '' }}"><a href="{{ URL::to('/reservation/choice') }}">Réservation</a></li>
                <li class="{{ Request::path() == 'visitors-book' ? 'active' : '' }}"><a href="{{ URL::to('/visitors-book') }}">Livre d'or</a></li>
                <li class="{{ Request::path() == 'activites' ? 'active' : '' }}"><a href="{{ URL::to('/activites') }}">Les activités</a></li>
                <li id="contact-li" class="{{ Request::path() == 'contact' ? 'active' : '' }}" data-toggle="popover" data-container="body"
                    data-content="<span class='glyphicon glyphicon-earphone' aria-hidden='true'></span> {{ env('PHONE_FRANCOIS') }}">
                    <a href="{{ URL::to('/contact') }}">Contact</a>
                </li>

            </ul>
            <ul class="nav navbar-nav navbar-right">

                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li class="{{ Request::path() == 'login' ? 'active' : '' }}"><a href="{{ route('login') }}">Connexion</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a class="dropdown-item" href="{{ URL::to('my/reservations') }}">Mes réservations</a>
                                    <a class="dropdown-item" href="{{ URL::to('my/informations') }}">Mon compte</a>


                                    @if(Auth::user()->is_admin)
                                        <li role="separator" class="divider"></li>
                                        <li class="dropdown-header admin-item">Partie administrateur</li>
                                        <li><a class="dropdown-item admin-item" href="{{ URL::to('admin/reservations') }}">Réservations</a></li>
                                        <li role="separator" class="divider"></li>
                                    @endif

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Déconnexion
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>


<div class="container content">
    @yield('content')
</div>


<footer class="footer">
    <div class="container">
        <div class="text-muted credit">
            <p>Copyright © 2017-{{ Carbon\Carbon::now()->year }} François Virga</p>
            <p>Icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>
            </p>
        </div>
    </div>
</footer>

<script>
    $(function () {
        $('#contact-li').popover({
            html : true,
            placement : "bottom",
            trigger : 'hover'
        });
    })
</script>

</body>
</html>
