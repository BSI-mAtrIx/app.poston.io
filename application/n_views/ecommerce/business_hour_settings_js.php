<script type="text/javascript">
    var always_open = "<?php echo $always_open;?>";
    $(document).ready(function ($) {
        if (always_open == '1') $("#schedule").hide();
        else $("#schedule").show();
        $(document).on('change', '.start_time', function (e) {
            if ($(this).val() == "") $(this).next().next().val('');
            else $(this).next().next().val('18:00');
        });
        $(document).on('click', '[name="always_open"]', function (e) {
            if ($(this).is(':checked')) {
                $("#schedule").hide();
            } else {
                $("#schedule").show();
            }
        });
    });
</script>