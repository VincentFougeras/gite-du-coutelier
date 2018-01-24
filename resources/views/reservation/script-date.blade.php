<script type="text/javascript"> /* TODO : empêcher de faire 3 semaines avec une semaine déjà réservée au milieu */

    var oldDays;

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
            $('#end_group').data("DateTimePicker").minDate(e.date);
            $('#end_group > input').val("");
        });

        /* Changements du lieu ou d'une date */
        $('#place').change(function(){
            updateDaysOfWeekAndPeople();
            updateDates();
        });

        $("#begin_group").on("dp.change", function (e) {
            correctDates();
            updatePrice();
        });
        $("#end_group").on("dp.change", function () {
            correctDates();
            updatePrice();
        });

    });

    // Modifier les dates sélectionnées pour qu'elles soient les plus proches de ce que l'utilisateur a sélectionné
    function correctDates(){
        var beginDate = $("#begin_group").data("DateTimePicker").date();
        var endDate = $("#end_group").data("DateTimePicker").date();


        // Week end autorisé dans le chalet hors saison
        if(beginDate !== null){
            if((beginDate.week() < 18 || beginDate.week() > 39) && $("#place").val() == 1){
                if(beginDate.day() >= 5 || beginDate.day() === 0){
                    if(beginDate.day() === 0){         // Dimanche == premier jour de la semaine suivante
                        $("#begin_group").data("DateTimePicker").date(beginDate.subtract(7, 'days'));
                    }
                    $("#begin_group").data("DateTimePicker").date(beginDate.day(5));
                }
                else {
                    $("#begin_group").data("DateTimePicker").date(beginDate.day(1));
                }
            }
            else {
                // Semaine normale
                if(beginDate.day() === 0){         // Dimanche == premier jour de la semaine suivante
                    $("#begin_group").data("DateTimePicker").date(beginDate.subtract(5, 'days'));
                }
                else {
                    $("#begin_group").data("DateTimePicker").date(beginDate.day(1));
                }

            }
        }

        if(endDate !== null){
            if(endDate.day() !== 0){
                $("#end_group").data("DateTimePicker").date(endDate.add(7, 'days').day(0));
            }
        }


    }

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