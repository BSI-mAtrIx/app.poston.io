<script>
    $(document).ready(function ($) {
        $(document).on('click', '.webhook_data', function (event) {
            event.preventDefault();
            var base_url = '<?php echo site_url();?>';
            var webhook_id = $(this).attr('data-id');
            $("#webhook_data .modal-body").html('<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center" style="font-size: 50px"></i></div><br/>');
            $("#webhook_data").modal();
            var is_ajax = '1';

            $.ajax({
                context: this,
                type: 'POST',
                url: "<?php echo site_url();?>ecommerce/order",
                data: {webhook_id: webhook_id, is_ajax: is_ajax},
                success: function (response) {
                    $("#webhook_data .modal-body").html(response);
                }
            });
        });
    });
</script>