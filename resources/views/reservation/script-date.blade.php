<script type="text/javascript"> /* TODO : empêcher de faire 3 semaines avec une semaine déjà réservée au milieu */

    $(function () {
        // Link calendars together
        $('#begin_group').datetimepicker({
            calendarWeeks : true,
            format : 'DD/MM/YYYY',
            minDate : {!! '"' . Carbon\Carbon::now()->toDateString() . '"' !!},
            maxDate : {!! '"' . Carbon\Carbon::now()->addYears(2)->toDateString() . '"' !!}
        });
        $('#end_group').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            calendarWeeks : true,
            format : 'DD/MM/YYYY',
            minDate : {!! '"' . Carbon\Carbon::now()->toDateString() . '"' !!},
            maxDate : {!! '"' . Carbon\Carbon::now()->addYears(2)->toDateString() . '"' !!}
        });

        // Initialiser les dates de réservation
        updateDaysOfWeekAndPeople();
        updateDates();

        // Contraindre la date de fin en fonction de la date de début choisie
        $("#begin_group").on("dp.change", function (e) {
            $('#end_group').data("DateTimePicker").minDate(e.date.add(2, 'days'));
            $('#end_group > input').val("");
        });

        /* Changements du lieu ou d'une date */
        $('#place').change(function(){
            updateDaysOfWeekAndPeople();
            updateDates();
        });

        $("#begin_group").on("dp.change", function () {
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

            $.ajax({
                url: '{{ url('/reservation/choice/updatePrice') }}',
                type: "POST",
                data: {'place' : $('#place').find('option:selected').prop('value'),
                    'begin_date' : $('#begin_date').val(),
                    'end_date' : $('#end_date').val(),
                    '_token': $('input[name=_token]').val(),
                },
                success: function(data){
                    $('#price').html(data.msg / 100);
                    if(data.msg == 0){
                        $('form button').prop('disabled', true);
                    }
                    else {
                        $('form button').prop('disabled', false);
                    }
                },
                complete: function(){
                }
            });
        }
        else {
            $('#price').html(0);
            $('form button').prop('disabled', true);
        }
    }

    // Modifier le nombre de personnes et changer les jours de la semaine désactivés
    function updateDaysOfWeekAndPeople(){
        if($('#place').val() == 1){ // Chalet
            $('.nb_people_extension').hide();
            if($('#nb_people').val() > 4){
                $('#nb_people').val(4);
            }
        }
        else { // Extension
            $('.nb_people_extension').show();
        }
    }


    function updateDates(){
        // Modifier les dates de réservation
        $.ajax({
            url: '{{ url('/reservation/choice/updateDates') }}',
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