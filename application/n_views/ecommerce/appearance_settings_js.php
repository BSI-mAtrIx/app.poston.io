<script type="text/javascript">
    $(document).ready(function ($) {

        $('.visual_editor').summernote({
            height: 180,
            minHeight: 180,
            toolbar: [
                ['font', ['bold', 'underline', 'italic', 'clear']],
                // ['fontname', ['fontname']],
                // ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['codeview']]
            ]
        });

        $(document).on('click', '[name="theme_front"]', function (e) {
            theme_front = $(this).val();
            $("#theme_color").val(theme_front);
        });


        $(document).on('change', 'input[name=whatsapp_send_order_button]', function (event) {
            event.preventDefault();
            var whatsapp_send_order_button = $("input[name=whatsapp_send_order_button]:checked").val();

            if (typeof (whatsapp_send_order_button) == "undefined") {
                $(".whatsapp_phone_number_div").css('display', 'none');
                $(".whatsapp_message_div").css('display', 'none');
            } else {
                $(".whatsapp_phone_number_div").css('display', 'block');
                $(".whatsapp_message_div").css('display', 'block');
            }
        });

        $(document).on('click', '#variables', function (e) {
            e.preventDefault();

            var success_message = '{{order_no}}<br/>{{customer_info}}<br/>{{product_info}}<br/>{{order_status}}<br/>{{order_url}}<br/>{{payment_method}}<br/>{{tax}}<br/>{{total_price}}<br/>{{delivery_address}}';
            var span = document.createElement("span");
            span.innerHTML = success_message;
            swal.fire({title: '<?php echo $this->lang->line("Variables"); ?>', html: span, icon: 'info'});
        });


    });
</script>