<script type="text/javascript"> /* TODO : empêcher de faire 3 semaines avec une semaine déjà réservée au milieu */

    var oldDays;

    $(function () {
        //console.log( {! $reservedDays !!} );
        // Link calendars together
        $('#begin_group').datetimepicker({
            format : 'DD/MM/YYYY',
            minDate : {!! '"' . Carbon\Carbon::now()->toDateString() . '"' !!},
            maxDate : {!! '"' . Carbon\Carbon::now()->addYears(2)->toDateString() . '"' !!}
        });
        $('#end_group').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format : 'DD/MM/YYYY',
            minDate : {!! '"' . Carbon\Carbon::now()->toDateString() . '"' !!},
            maxDate : {!! '"' . Carbon\Carbon::now()->addYears(2)->toDateString() . '"' !!}
        });

        // Initialiser les dates de réservation
        updateDaysOfWeekAndPeople();
        updateDates();

        // Contraindre la date de fin en fonction de la date de début choisie
        $("#begin_group").on("dp.change", function (e) {
            $('#end_group').data("DateTimePicker").minDate(e.date);
            $('#end_group > input').val("");
            var selectedDate = moment($("#begin_group > input").val(), "DD/MM/YYYY");
            if(selectedDate.day() === 5){
                var nextDay = moment($("#begin_group > input").val(), "DD/MM/YYYY").add(1, 'days');
                $('#end_group').data("DateTimePicker").daysOfWeekDisabled(oldDays);
                $('#end_group').data("DateTimePicker").enabledDates([ nextDay ]);
            }
            else if(selectedDate.day() === 1) {
                $('#end_group').data("DateTimePicker").enabledDates(false);
                $('#end_group').data("DateTimePicker").daysOfWeekDisabled([1,2,3,4,5,6]);
            }
            else {
                $('#end_group').data("DateTimePicker").daysOfWeekDisabled(oldDays);
            }


        });
        /*$("#end_group").on("dp.change", function (e) {
            $('#begin_group').data("DateTimePicker").maxDate(e.date);
        });*/

        /* Changements du lieu ou d'une date */
        $('#place').change(function(){
            updateDaysOfWeekAndPeople();
            updateDates();
        });

        $("#begin_group").on("dp.change", function (e) {
            updatePrice();
        });
        $("#end_group").on("dp.change", function () {
            updatePrice();
        });

    });

    // Mettre à jour le prix en fonction du lieu et des dates
    function updatePrice(){
        if(moment($("#begin_group > input").val(), "DD/MM/YYYY").isValid()
            && moment($("#end_group > input").val(), "DD/MM/YYYY").isValid()){

            var pathname = window.location.pathname;
            $.ajax({
                url: pathname + '/updatePrice',
                type: "POST",
                data: {'place' : $('#place').find('option:selected').prop('value'),
                    'begin_date' : $('#begin_date').val(),
                    'end_date' : $('#end_date').val(),
                    '_token': $('input[name=_token]').val(),
                },
                success: function(data){
                    $('#price').html(data.msg / 100);
                    if(data.msg == 0){
                        $('button').prop('disabled', true);
                    }
                    else {
                        $('button').prop('disabled', false);
                    }
                },
                complete: function(){
                }
            });
        }
        else {
            $('#price').html(0);
            $('button').prop('disabled', true);
        }
    }

    // Modifier le nombre de personnes et changer les jours de la semaine désactivés
    function updateDaysOfWeekAndPeople(){
        if($('#place').val() == 1){
            $('.nb_people_extension').hide();
            if($('#nb_people').val() > 4){
                $('#nb_people').val(4);
            }

            $('#begin_group').data("DateTimePicker").daysOfWeekDisabled([0,2,3,4,6]);
            $('#end_group').data("DateTimePicker").daysOfWeekDisabled([1,2,3,4,5]);
            $('#end_group').data("DateTimePicker").enabledDates(false);
            oldDays = [1,2,3,4,5];
        }
        else {
            $('.nb_people_extension').show();

            $('#begin_group').data("DateTimePicker").daysOfWeekDisabled([0,2,3,4,5,6]);
            $('#end_group').data("DateTimePicker").daysOfWeekDisabled([1,2,3,4,5,6]);
            $('#end_group').data("DateTimePicker").enabledDates(false);
            oldDays = [1,2,3,4,5,6];
        }
    }


    function updateDates(){
        // Modifier les dates de réservation
        var pathname = window.location.pathname;
        $.ajax({
            url: pathname + '/updateDates',
            type: "POST",
            data: {'place' : $('#place').find('option:selected').prop('value'),
                '_token': $('input[name=_token]').val(),
            },
            success: function(data){
                $('#begin_group').data("DateTimePicker").disabledDates(data.msg);
                $('#end_group').data("DateTimePicker").disabledDates(data.msg);

                updatePrice();
            },
            complete: function(){
            }
        });
    }
</script>