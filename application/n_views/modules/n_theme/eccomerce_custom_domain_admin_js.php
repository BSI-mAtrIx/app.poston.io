<script>
    $(document).on('click', '.confirm_app_n', function (e) {
        e.preventDefault();
        swal.fire({
            title: '<?php echo $this->lang->line("Are you sure?"); ?>',
            text: 'Activate custom domain: ' + $(this).attr('data-host'),
            icon: 'warning',
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    var app_table_id = $(this).attr('data-id');
                    var csrf_token = $(this).attr('csrf_token');
                    $.ajax({
                        context: this,
                        type: 'POST',
                        url: "<?php echo site_url();?>n_theme/custom_domain_admin_save",
                        dataType: 'json',
                        data: {id: app_table_id, csrf_token: csrf_token},
                        success: function (response) {
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

    $(document).on('click', '.delete_app_n', function (e) {
        e.preventDefault();
        swal.fire({
            title: '<?php echo $this->lang->line("Are you sure?"); ?>',
            text: 'Remove custom domain: ' + $(this).attr('data-host'),
            icon: 'warning',
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    var app_table_id = $(this).attr('data-id');
                    var csrf_token = $(this).attr('csrf_token');
                    $.ajax({
                        context: this,
                        type: 'POST',
                        url: "<?php echo site_url();?>n_theme/custom_domain_admin_delete",
                        dataType: 'json',
                        data: {id: app_table_id, csrf_token: csrf_token},
                        success: function (response) {
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
</script>