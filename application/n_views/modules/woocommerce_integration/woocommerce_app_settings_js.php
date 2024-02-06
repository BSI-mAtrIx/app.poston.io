<script>
    var base_url = "<?php echo site_url(); ?>";

    $(document).ready(function () {

        "use strict";

        $(document).on('click', '.show_product', function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            $("#show_products_modal").modal();
            $("#show_products_modal iframe").attr('src', base_url + 'woocommerce_integration/product_list/' + id);
        });

        $(document).on('click', '.copy_url', function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            $("#copy_url_modal").modal();
            $("#copy_url_modal iframe").attr('src', base_url + 'woocommerce_integration/copy_url/' + id);
        });


        $(document).on('click', '.delete_app', function (e) {
            e.preventDefault();
            var ifyoudeletethisaccount = "<?php echo $this->lang->line('Are you sure that you want to delete this API? Deleting API does not affect products exported to E-commerce.'); ?>";
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: ifyoudeletethisaccount,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var app_table_id = $(this).attr('table_id');
                        var csrf_token = $(this).attr('csrf_token');
                        $(this).removeClass('btn-outline-danger');
                        $(this).addClass('btn-danger');
                        $(this).addClass('btn-progress');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>woocommerce_integration/delete_action",
                            dataType: 'json',
                            data: {app_table_id: app_table_id, csrf_token: csrf_token},
                            success: function (response) {

                                $(this).removeClass('btn-progress');
                                $(this).removeClass('btn-danger');
                                $(this).addClass('btn-outline-danger');

                                if (response.status == 1) {
                                    swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
                                        location.reload();
                                    });
                                } else {
                                    swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                }
                            }
                        });
                    }
                });
        });


    });
</script>