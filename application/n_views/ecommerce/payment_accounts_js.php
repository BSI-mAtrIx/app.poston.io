<script type="text/javascript">
    $(document).ready(function ($) {

        $('.visual_editor').summernote({
            height: 180,
            minHeight: 180,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'italic', 'clear']],
                // ['fontname', ['fontname']],
                // ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['codeview']]
            ]
        });

        $(document).on('click', '[name="is_preparation_time"]', function (e) {
            if ($(this).is(':checked')) {
                $('[name="preparation_time"]').removeAttr('disabled');
                $('[name="preparation_time_unit"]').removeAttr('disabled');
            } else {
                $('[name="preparation_time"]').attr('disabled', '');
                $('[name="preparation_time_unit"]').attr('disabled', '');
            }
        });

        $(document).on('click', '[name="is_order_schedule"]', function (e) {
            if ($(this).is(':checked')) {
                $('[name="order_schedule"]').removeAttr('disabled');
            } else {
                $('[name="order_schedule"]').attr('disabled', '');
            }
        });

        $(document).on('click', '#enable_paymongo_webhook', function (e) {
            $.ajax({
                type: 'POST',
                url: base_url + "n_paymongo/enable_webhook_ecommerce/<?php echo $xvalue['store_id']; ?>",
                dataType: 'JSON',
                success: function (response) {
                    if (response.status == '1') {
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                    } else {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }
                }
            });
        });

    });
</script>