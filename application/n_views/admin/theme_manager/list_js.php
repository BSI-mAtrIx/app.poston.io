<script>
    var base_url = "<?php echo base_url(); ?>";
    var is_demo = "<?php echo $is_demo; ?>";
    $("document").ready(function () {

        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });

        $(".activate_action").click(function (e) {
            e.preventDefault();
            var folder_name = $(this).attr('data-unique-name');
            swal.fire({
                title: '<?php echo $this->lang->line("Theme Activation"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to activate this Theme?"); ?>',
                icon: 'info',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: base_url + "themes/active_deactive_theme",
                            data: {folder_name: folder_name, active_or_deactive: 'active'},
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == '1') {
                                    swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                                        .then((value) => {
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

        $(".deactivate_action").click(function (e) {
            e.preventDefault();
            var folder_name = $(this).attr('data-unique-name');
            swal.fire({
                title: '<?php echo $this->lang->line("Theme Deactivation"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to deactivate this Theme? Your theme data will still remain"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: base_url + "themes/active_deactive_theme",
                            data: {folder_name: folder_name, active_or_deactive: 'deactive'},
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == '1') {
                                    swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                                        .then((value) => {
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

        $(".delete_action").click(function (e) {
            e.preventDefault();
            var folder_name = $(this).attr('data-unique-name');
            swal.fire({
                title: '<?php echo $this->lang->line("Delete!"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to delete this Theme? This process can not be undone."); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: base_url + "themes/delete_theme",
                            data: {folder_name: folder_name},
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == '1') {
                                    swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                                        .then((value) => {
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