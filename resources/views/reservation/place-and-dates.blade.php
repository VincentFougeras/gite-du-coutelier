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
        <div class="alert alert-info">
            Vous pouvez réserver au minimum <strong>3 jours (2 nuits)</strong>, n'importe quand dans l'année. Les prix sont plus faibles en hiver (semaines 37 à 24).
        </div>
    </div>
</div>