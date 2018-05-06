<div class="row">
    <div class="col-md-8">
        @include('flash')
        <div class="form-group">
            {!! Form::label('place', 'Lieu de réservation :') !!}
            <select class="form-control" id="place" name="place">
                <option value="1">Chalet 1</option>
                <option value="0" disabled>Chalet 2 (pas encore disponible)</option>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        {!! Form::label('dates', 'Dates de réservation:') !!}
        <div class="row" id="dates">
            <div class='col-sm-6'>
                <div class="form-group">
                    <div class='input-group date' id='begin_group'>
                        <input type='text' class="form-control" placeholder="Début" required id="begin_date" name="beginning"/>
                        <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
            </div>
            <div class='col-sm-6'>
                <div class="form-group">
                    <div class='input-group date' id='end_group'>
                        <input type='text' class="form-control" placeholder="Fin" required id="end_date" name="end"/>
                        <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-info"><strong>Comment choisir ses dates</strong>
            <ul>
                <li>Toute l'année : <strong>du lundi au dimanche (6 nuits)</strong> renouvelable sur plusieurs semaines</li>
                <li>Week-end possible en hiver (semaines 37 à 24), hors vacances scolaires, au Chalet 1 uniquement : <strong>du vendredi au dimanche (2 nuits)</strong></li>
            </ul>
        </div>
    </div>
</div>