<script>
    var base_url = "<?php echo site_url(); ?>";

    function ecommerceGoBack() //used to go back to list as crud
    {
        var mes = '';
        mes = "<?php echo $this->lang->line('Your data may not be saved.');?>";
        swal.fire({
            title: "<?php echo $this->lang->line("Do you want to go back?");?>",
            text: mes,
            icon: "warning",
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    parent.location.reload();
                }
            });
    }

    $(document).ready(function ($) {
        $(document).on('click', '#variables', function (e) {
            e.preventDefault();

            var success_message = '{{last_name}}<br/>{{first_name}}';
            var span = document.createElement("span");
            span.innerHTML = success_message;
            swal.fire({title: '<?php echo $this->lang->line("Variables"); ?>', html: span, icon: 'info'});
        });

        $(document).on('change', 'input[type=color]', function (e) {
            var id = $(this).attr('id');
            var pickup_point_id = $("#selector").val();
            get_button("save_generate", pickup_point_id);
        });

        $(document).on('change', '#selector', function (e) {
            var pickup_point_id = $("#selector").val();
            get_button("save_generate", pickup_point_id);
        });

        $(document).on('click', '#get_button', get_button);

        function get_button(action, pickup_point_id) {
            if (typeof (action) === 'undefined') action = "save";
            if (typeof (pickup_point_id) === 'undefined') pickup_point_id = "";
            $('#get_button').addClass('btn-progress');
            var store_id = $("#store_id").val();
            var redirect_to = '<?php echo base_url("ecommerce/qr_code/")?>' + store_id;
            if (pickup_point_id != '') redirect_to = redirect_to + "/" + pickup_point_id;

            var queryString = new FormData($("#plugin_form")[0]);

            $.ajax({
                type: 'POST',
                url: base_url + "ecommerce/qr_code_action",
                data: queryString,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $("#get_button").removeClass('btn-progress');
                    if (response.status == '1') {
                        if (action == "save_generate") window.location.assign(redirect_to);
                        else swal.fire('<?php echo $this->lang->line("Settings Updated"); ?>', response.message, 'success').then((value) => {
                            parent.window.location.assign('<?php echo base_url("ecommerce/store_list") ?>');
                        });
                    } else swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                }

            });

        }

    });
</script>