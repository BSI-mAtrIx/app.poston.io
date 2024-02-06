<script>
    $("document").ready(function () {

        function calc_tokens(){
            var sim_tokens = $('#sim_tokens').val();
            var sim_cp = $('#sim_cp').val();

            var openai_price_new = $('#sim_calc_oi_new').val();

            var sim_calc = 0;

            sim_calc = sim_tokens * sim_cp / 100;

            $('#sim_calc').val(sim_calc);
            $('#sim_calc_oi').val(sim_tokens * openai_price_new / 1000);
        }

        $(document).on('change', '#sim_tokens', function (e) {
            calc_tokens();
        });

        $(document).on('change', '#sim_cp', function (e) {
            calc_tokens();
        });

        $(document).on('change', '#sim_calc_oi_new', function (e) {
            calc_tokens();
        });


    })
</script>