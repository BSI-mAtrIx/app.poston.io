<script>
    function generate_code(){
        gen_min_value_select = $('#gen_min_value_select').val();
        gen_price_1_per_unit = $('#gen_price_1_per_unit').val();
        gen_price_2_per_unit = $('#gen_price_2_per_unit').val();
        gen_is_unlimited = $('#gen_is_unlimited').is(':checked');

        if (
            gen_min_value_select=='' ||
            gen_price_1_per_unit=='' ||
            gen_price_2_per_unit==''
        ){
            $('#result_price_config_gen').html('All values required');
            return;
        }

        if(gen_is_unlimited==true){
            gen_is_unlimited_val = 1;
        }else{
            gen_is_unlimited_val = 0;
        }

        $('#result_price_config_gen').html(gen_min_value_select + ';' + gen_price_1_per_unit + ';' + gen_price_2_per_unit + ';' + gen_is_unlimited_val);
    }


    $(document).on('change', '#gen_min_value_select', function (event) {
        generate_code();
    });
    $(document).on('change', '#gen_price_1_per_unit', function (event) {
        generate_code();
    });
    $(document).on('change', '#gen_price_2_per_unit', function (event) {
        generate_code();
    });
    $(document).on('change', '#gen_is_unlimited', function (event) {
        generate_code();
    });

<?php
if(!empty($pck['payments_method'])){
    echo "$('#payment_methods').val(".$pck['payments_method'].").change();";
}

if(!empty($pck['country'])){
    echo "$('#country_restriction').val(".$pck['country'].").change();";
} ?>





</script>