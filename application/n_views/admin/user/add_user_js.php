<script type="text/javascript">
    $(document).ready(function () {
        // if($("#price_default").val()=="0") $("#hidden").hide();
        // else $("#validity").show();
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