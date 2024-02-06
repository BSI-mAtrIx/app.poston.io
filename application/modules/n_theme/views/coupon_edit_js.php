<script>
    $(document).ready(function () {
        var today = new Date();
        $('#date_active').datetimepicker({
            theme: 'light',
            format: 'Y-m-d H:i:s',
            formatDate: 'Y-m-d H:i:s',
            minDate: today
        });
        $('#date_expire').datetimepicker({
            theme: 'light',
            format: 'Y-m-d H:i:s',
            formatDate: 'Y-m-d H:i:s',
            minDate: today
        });
    });
</script>