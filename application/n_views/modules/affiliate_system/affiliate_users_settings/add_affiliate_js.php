<script>
    $(document).ready(function () {

        $(document).on('change', '#is_overwritten', function (event) {
            event.preventDefault();

            if ($(this).prop('checked') == true) {
                $("#commission_section").show(500);
            } else {
                $("#commission_section").hide(500);
            }
        });


        $(document).on('change', '#by_signup', function (event) {
            event.preventDefault();

            if ($(this).prop('checked') == true) {
                $("#signup_sec_div").show(500);
            } else {
                $("#signup_sec_div").hide(500);
            }
        });

        $(document).on('change', '#by_payment', function (event) {
            event.preventDefault();

            if ($(this).prop('checked') == true) {
                $("#payment_sec_div").show(500);

            } else {
                $("#payment_sec_div").hide(500);
            }
        });

        $(document).on('change', '#payment_type', function (event) {
            event.preventDefault();

            if ($(this).val() == 'fixed') {
                $("#fixed_amount_div").show(500);
                $("#percentage_div").hide(500);
            } else {
                $("#fixed_amount_div").hide(500);
            }

            if ($(this).val() == 'percentage') {
                $("#percentage_div").show(500);
            } else {
                $("#percentage_div").hide(500);

            }
        });
    });
</script>