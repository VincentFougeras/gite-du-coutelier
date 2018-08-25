<script type="text/javascript">
    $(function () {
        $('#date').datetimepicker({
            inline : true,
            format : 'DD/MM/YYYY',
            minDate : {!! '"' . Carbon\Carbon::now()->toDateString() . '"' !!},
            maxDate : {!! '"' . Carbon\Carbon::now()->addYears(2)->toDateString() . '"' !!}
        });


        $('.carousel').carousel({
            interval: false
        });


        // Initialiser les dates de réservation

        updateDates();

        /* Changements du lieu ou d'une date */
        $('#place').change(function(){
            updateDates();

            /*if($('#place').find('option:selected').prop('value') === '1'){
                // Switch to chalet
                $('.carousel').carousel(0);
            }
            else {
                // Switch to extension
                $('.carousel').carousel(1);
            }*/
        });

    });

    function updateDates(){
        // Modifier les dates de réservation
        var pathname = window.location.pathname;
        $.ajax({
            url: '{{ url('/getDates') }}',
            data: {'place' : $('#place').find('option:selected').prop('value')},
            type: "GET",
            success: function(data){
                //console.log(data.msg);
                $('#date').data("DateTimePicker").disabledDates(data.msg);
            },
            complete: function(){
            }
        });
    }
</script>