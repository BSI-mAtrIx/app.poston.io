<script type="text/javascript">
    $(document).ready(function () {
        var user_type = '<?php echo $xdata["user_type"];?>';
        if (user_type == "Admin") $("#hidden").hide();
        else $("#validity").show();
        $(".user_type").click(function () {
            if ($(this).val() == "Admin") $("#hidden").hide();
            else $("#hidden").show();
        });
        var today = new Date();
        $('.datepicker').datetimepicker({
            theme: 'light',
            format: 'Y-m-d H:i:s',
            formatDate: 'Y-m-d H:i:s',
            minDate: today
        });
    });
</script>