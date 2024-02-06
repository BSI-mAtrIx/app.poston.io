<script>
    $(document).ready(function () {
        var base_url = '<?php echo base_url(); ?>';

        var wssh_table = $('#wssh-datatable').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],
            pageLength: 10,
            ajax: {
                url: '<?= base_url('social_apps/wordpress_self_hosted_settings_data') ?>',
                type: 'POST',
                dataSrc: function (json) {
                    //$(".table-responsive").niceScroll();
                    return json.data;
                },
            },
            columns: [
                {data: 'id'},
                {data: 'domain_name'},
                {data: 'user_key'},
                {data: 'authentication_key'},
                {data: 'status'},
                {data: 'actions'}
            ],
            language: {
                url: "<?= base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
            },
            columnDefs: [
                {
                    'sortable': false,
                    'targets': [2, 3, 4, 5]
                },
                {
                    targets: [0, 1, 2, 3, 4, 5],
                    className: 'text-center'
                },
                {
                    targets: [5],
                    "render": function (data, type, row) {
                        data = data.replaceAll('fas fa-code', 'bx bx-code');
                        data = data.replaceAll('fas fa-edit', 'bx bx-edit');
                        data = data.replaceAll('fa fa-edit', 'bx bx-edit');
                        data = data.replaceAll('far fa-copy', 'bx bx-copy');
                        data = data.replaceAll('fa fa-trash', 'bx bx-trash');
                        data = data.replaceAll('fa fa-eye', 'bx bxs-show');
                        data = data.replaceAll('fas fa-eye', 'bx bxs-show');
                        data = data.replaceAll('fas fa-trash-alt', 'bx bx-trash');
                        data = data.replaceAll('fa fa-wordpress', 'bx bxl-wordpress');
                        data = data.replaceAll('fa fa-briefcase', 'bx bx-briefcase');
                        data = data.replaceAll('fab fa-wpforms', 'bx bx-news');
                        data = data.replaceAll('fas fa-file-export', 'bx bx-export');
                        data = data.replaceAll('fa fa-comment', 'bx bx-comment');
                        data = data.replaceAll('fa fa-user', 'bx bx-user');
                        data = data.replaceAll('fa fa-refresh', 'bx bx-refresh');
                        data = data.replaceAll('fa fa-plus-circle', 'bx bx-plus-circle');
                        data = data.replaceAll('fas fa-comments', 'bx bx-comment');
                        data = data.replaceAll('fa fa-hand-o-right', 'bx bx-link-external');
                        data = data.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
                        data = data.replaceAll('fas fa-exchange-alt', 'bx bx-repost');
                        data = data.replaceAll('fa fa-sync-alt', 'bx bx-sync');

                        return data;
                    }
                },
            ],
            dom: '<"top"f>rt<"bottom"lip><"clear">',
        });

        // Loads categories
        $(document).on('click', '.update-categories', function (e) {
            e.preventDefault();

            var that = this;
            var wp_app_id = $(that).data('wp-app-id');

            // Handles spinner
            $(that).removeClass('btn-outline-primary');
            $(that).addClass('btn-primary btn-progress');

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {wp_app_id},
                url: base_url + 'social_apps/wordpress_self_hosted_settings_load_categories',
                success: function (res) {

                    // Handles spinner
                    $(that).addClass('btn-outline-primary');
                    $(that).removeClass('btn-primary btn-progress');

                    if (false === res.status) {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', res.message, 'error');
                        return;
                    }

                    if (true === res.status) {
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', res.message, 'success');
                    }
                },
            });
        });

        // Attempts to delete wordpress site's settings
        $(document).on('click', '#delete-wssh-settings', function (e) {
            e.preventDefault()

            // Grabs site ID
            var site_id = $(this).data('site-id');
            var csrf_token = $(this).attr('csrf_token');

            swal.fire({
                title: '<?php ('Are you sure?'); ?>',
                text: '<?php echo $this->lang->line('Once deleted, you will not be able to recover this wordpress site settings!'); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            }).then((yes) => {
                if (yes) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('social_apps/delete_wordpress_self_hosted_settings') ?>',
                        dataType: 'JSON',
                        data: {site_id: site_id, csrf_token: csrf_token},
                        success: function (res) {

                            if ('ok' == res.status) {
                                swal.fire('<?php echo $this->lang->line("Success"); ?>', res.message, 'success').then((value) => {
                                    location.reload();
                                });
                            } else swal.fire('<?php echo $this->lang->line("Error"); ?>', res.error, 'error');


                        }
                    })
                } else {
                    return
                }
            });
        });
    });
</script>