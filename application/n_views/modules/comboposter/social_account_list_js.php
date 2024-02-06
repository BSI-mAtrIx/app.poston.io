<script>
    $(document).ready(function () {
        $(document).on('click', '.delete_account', function (event) {
            event.preventDefault();

            swal.fire({
                title: 'Are you sure?',
                text: 'Do you really want to delete this account? If you delete this account it will be deleted from your database.',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        let social_media = $(this).attr('social_media');
                        let table_id = $(this).attr('table_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            dataType: 'json',
                            url: "<?php echo base_url('comboposter/delete_social_account'); ?>",
                            data: {social_media: social_media, table_id: table_id},
                            success: function (response) {

                                if (response.status == 'success') {
                                    iziToast.success({title: '', message: response.message, position: 'bottomRight'});
                                } else if (response.status == 'error') {
                                    iziToast.error({title: '', message: response.message, position: 'bottomRight'});
                                }

                                window.location.href = "<?php echo base_url('comboposter/social_accounts'); ?>";
                            }
                        });
                    }
                });
        });

        $(document).on('click', '.show_hide_medium_token_field', function (event) {
            event.preventDefault();
            $(".medium_account_token_field").toggle(500);
        });

        $(document).on('click', '.api_error_info', function (event) {
            event.preventDefault();
            $("#api_error_info_modal").modal();
        });

        $(document).on('click', '.import_medium_account', function (event) {
            event.preventDefault();

            var integration_token = $("#medium_integration_token").val();

            if (integration_token == "" || integration_token == 'undefined') {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', '<?php echo $this->lang->line("Please provide your integration token"); ?>', 'error');
            }

            $(this).addClass('btn-progress');
            var redirect_url = '<?php echo base_url()?>' + 'comboposter/social_accounts';

            $.ajax({
                context: this,
                url: '<?php echo base_url()?>' + 'comboposter/login_callback/medium',
                type: 'POST',
                data: {integration_token: integration_token},
                dataType: 'json',
                success: function (response) {
                    $(this).removeClass('btn-progress');

                    if (response.status == '1') {
                        var span = document.createElement("span");
                        span.innerHTML = response.success_message;
                        swal.fire({
                            title: '<?php echo $this->lang->line("Success"); ?>',
                            html: span,
                            icon: 'success'
                        }).then((value) => {
                            window.location.href = redirect_url;
                        });
                    }

                    if (response.status == '0') {
                        var span = document.createElement("span");
                        span.innerHTML = response.error_message;
                        swal.fire({
                            title: '<?php echo $this->lang->line("Error"); ?>',
                            html: span,
                            icon: 'error'
                        }).then((value) => {
                            window.location.href = redirect_url;
                        });
                    }

                }
            })

        });

        // Attempts to delete wordpress site's settings
        $(document).on('click', '#delete-wssh-settings', function (e) {
            e.preventDefault()

            // Makes reference
            var that = this;

            // Grabs site ID
            var site_id = $(that).data('site-id');

            swal.fire({
                title: '<?php ('Are you sure?'); ?>',
                text: '<?php echo $this->lang->line('Once deleted, you will not be able to recover this wordpress site\'s settings!'); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            }).then((yes) => {
                if (yes) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('social_apps/delete_wordpress_settings_self_hosted') ?>',
                        dataType: 'JSON',
                        data: {site_id},
                        success: function (res) {
                            if (res) {
                                if ('ok' == res.status) {
                                    // Displays success message
                                    iziToast.success({title: '', message: res.message, position: 'bottomRight'});

                                    // Removes this element from the UI
                                    var media_el = $(that).parent().parent();
                                    media_el.remove();
                                } else if (true === res.error) {
                                    // Displays error message
                                    iziToast.error({title: '', message: res.message, position: 'bottomRight'});
                                }
                            }
                        },
                        error: function (xhr, status, error) {
                            // Displays error message
                            iziToast.error({title: '', message: error, position: 'bottomRight'});
                        }
                    })
                } else {
                    return
                }
            });
        });
    });
</script>