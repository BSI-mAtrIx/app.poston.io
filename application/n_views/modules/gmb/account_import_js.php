<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $("document").ready(function () {
        var base_url = "<?php echo base_url(); ?>";


        $(document).on('click', '.location_delete', function () {
            var location_delete_confirmation = "<?php echo $location_delete_confirmation; ?>";
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure"); ?>',
                text: location_delete_confirmation,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var location_table_id = $(this).attr('table_id');

                        $(this).removeClass('btn-outline-danger');
                        $(this).addClass('btn-danger');
                        $(this).addClass('btn-progress');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>social_accounts/location_delete_action",
                            dataType: 'json',
                            data: {location_table_id: location_table_id},
                            success: function (response) {
                                if (response.status == 1) {
                                    $(this).removeClass('btn-progress');
                                    $(this).removeClass('btn-danger');
                                    $(this).addClass('btn-outline-danger');

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


        $(document).on('click', '.delete_account', function () {
            var account_delete_confirmation = "<?php echo $account_delete_confirmation; ?>";
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure"); ?>',
                text: account_delete_confirmation,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var gmb_user_table_id = $(this).attr('table_id');
                        $(this).removeClass('btn-outline-danger');
                        $(this).addClass('btn-danger');
                        $(this).addClass('btn-progress');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>social_accounts/gmb_account_delete_action",
                            dataType: 'json',
                            data: {gmb_user_table_id: gmb_user_table_id},
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


        $(document).on('click', '.location_insight', function () {
            var redirect_url = $(this).attr('redirect_url');
            window.open(redirect_url, "_blank") || window.location.replace(redirect_url);
        });

    });
</script>