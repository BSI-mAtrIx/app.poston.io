<script type="text/javascript">
    $(document).ready(function () {

        setTimeout(function () {
            $("#store_id").change();
        }, 500);

        var today = new Date();
        $('.datepicker_x').datetimepicker({
            theme: 'light',
            format: 'Y-m-d H:i:s',
            formatDate: 'Y-m-d H:i:s',
            minDate: today
        });

        $("#store_id").change(function () {
            var store_id = $("#store_id").val();
            if (store_id == '') store_id = '0';
            $.ajax({
                context: this,
                type: 'POST',
                url: "<?php echo base_url('ecommerce/get_product_list/')?>" + store_id + "/1/1",
                success: function (response) {
                    $("#product_con").html(response);
                    var product_ids = [<?php echo '"' . implode('","', $xproduct_ids) . '"' ?>];
                    $('#product_ids').val(product_ids).trigger('change');
                }
            });
        });
    });
</script>