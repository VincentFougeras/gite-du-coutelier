<script type="text/javascript">
    $(function () {
        $('#date').datetimepicker({
            inline : true,
            format : 'DD/MM/YYYY',
            minDate : {!! '"' . Carbon\Carbon::now()->toDateString() . '"' !!},
            maxDate : {!! '"' . Carbon\Carbon::now()->addYears(2)->toDateString() . '"' !!}
        });


        // Initialiser les dates de réservation

        updateDates();

        /* Changements du lieu ou d'une date */
        $('#place').change(function(){
            updateDates();
        });

    });

    function updateDates(){
        // Modifier les dates de réservation
        var pathname = window.location.pathname;
        $.ajax({
            url: pathname + '/getDates',
            data: {'place' : $('#place').find('option:selected').prop('value')},
            type: "GET",
            success: function(data){
                console.log(data.msg);
                $('#date').data("DateTimePicker").disabledDates(data.msg);
            },
            complete: function(){
            }
        });
    }
</script>