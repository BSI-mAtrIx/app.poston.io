<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/forms/select/select2.full.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/moment.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script type="text/javascript"
        src="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.print.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/pdfmake.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/vfs_fonts.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script>
    $(document).ready(function () {
        var areWeUsingScroll = false;
        //TODO: areWeUsingScroll

        var perscroll1;
        var data_table = $('#acelle-datatable').DataTable({
            processing: true,
            serverSide: true,
            bFilter: true,
            order: [[0, "desc"]],
            pageLength: 10,
            ajax: {
                url: '<?= base_url('email_auto_responder_integration/acelle_grid_data') ?>',
                type: 'POST'
            },
            columns: [
                {data: 'id'},
                {data: 'tracking_name'},
                {data: 'api_url'},
                {data: 'api_key'},
                {data: 'inserted_at'},
                {data: 'actions'}
            ],
            language: {
                url: "<?= base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
            },
            columnDefs: [
                {"sortable": false, "targets": [0, 1, 2, 3, 5]},
                {
                    targets: [0],
                    visible: false
                },
                {
                    targets: [4, 5],
                    className: 'text-center'
                },
                {
                    targets: [5],
                    "render": function (data, type, row) {
                        data = data.replaceAll('fas fa-user-slash', 'bx bxs-user-x');
                        data = data.replaceAll('fas fa-comment-slash', 'bx bx-comment-x');
                        data = data.replaceAll('fas fa-map', 'bx bx-map');
                        data = data.replaceAll('fas fa-birthday-cake', 'bx bx-cake');
                        data = data.replaceAll('fas fa-headset', 'bx bx-headphone');
                        data = data.replaceAll('fas fa-phone', 'bx bx-phone');
                        data = data.replaceAll('fas fa-robot', 'bx bx-bot');
                        data = data.replaceAll('fas fa-envelope', 'bx bx-envelope');
                        data = data.replaceAll('fas fa-code', 'bx bx-code');
                        data = data.replaceAll('fas fa-edit', 'bx bx-edit');
                        data = data.replaceAll('fa fa-edit', 'bx bx-edit');
                        data = data.replaceAll('fa  fa-edit', 'bx bx-edit');
                        data = data.replaceAll('far fa-copy', 'bx bx-copy');
                        data = data.replaceAll('fa fa-trash', 'bx bx-trash');
                        data = data.replaceAll('fas fa-trash', 'bx bx-trash');
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
                        data = data.replaceAll('fas fa-key', 'bx bx-key');
                        data = data.replaceAll('fas fa-bolt', 'bx bxs-bolt');
                        data = data.replaceAll('fas fa-clone', 'bx bxs-copy-alt');
                        data = data.replaceAll('fas fa-receipt', 'bx bx-receipt');
                        data = data.replaceAll('fa fa-paper-plane', 'bx bx-paper-plane');
                        data = data.replaceAll('fa fa-send', 'bx bx-send');
                        data = data.replaceAll('fas fa-hand-point-right', 'bx bx-news');
                        data = data.replaceAll('fa fa-code', 'bx bx-code');
                        data = data.replaceAll('fa fa-clone', 'bx bx-duplicate');
                        data = data.replaceAll('fas fa-pause', 'bx bx-pause');
                        data = data.replaceAll('fas fa-play', 'bx bx-play');
                        data = data.replaceAll('fa fa-cog', 'bx bx-cog');
                        data = data.replaceAll('fa fa-check-circle', 'bx bx-check-circle');
                        data = data.replaceAll('fas fa-comment', 'bx bx-comment');
                        data = data.replaceAll('swal(', 'swal.fire(');
                        data = data.replaceAll('rounded-circle', 'rounded-circle');
                        data = data.replaceAll('fas fa-check-circle', 'bx bx-check-circle');
                        data = data.replaceAll('fas fa-plug', 'bx bx-plug');
                        data = data.replaceAll('fas fa-times-circle', 'bx bx-time');
                        data = data.replaceAll('fas fa-chart-bar', 'bx bx-chart');
                        data = data.replaceAll('fas fa-cloud-download-alt', 'bx bxs-cloud-download');
                        data = data.replaceAll('padding-10', 'p-10');
                        data = data.replaceAll('padding-left-10', 'pl-10');
                        data = data.replaceAll('h4', 'h5 class="card-title font-medium-1"');
                        data = data.replaceAll('fas fa-heart', 'bx bx-heart');
                        data = data.replaceAll('fas fa-road', 'bx bx-location-plus');
                        data = data.replaceAll('fas fa-city', 'bx bxs-city');
                        data = data.replaceAll('fas fa-globe-americas', 'bx bx-globe');
                        data = data.replaceAll('fas fa-at', 'bx bx-at');
                        data = data.replaceAll('fas fa-mobile-alt', 'bx bx-mobile-alt');
                        data = data.replaceAll('<div class="dropdown-title"><?php echo $this->lang->line('Options'); ?></div>', '<h6 class="dropdown-header"><?php echo $this->lang->line('Options'); ?></h6>');
                        data = data.replaceAll('fas fa-file-signature', 'bx bxs-user-badge');
                        data = data.replaceAll('fas fa-user-circle', 'bx bxs-user');
                        data = data.replaceAll('fas fa-toggle-on', 'bx bx-toggle-right');
                        data = data.replaceAll('fas fa-toggle-off', 'bx bx-toggle-left');
                        data = data.replaceAll('fas fa-info-circle', 'bx bx-info-circle');
                        data = data.replaceAll('fa fa-info-circle', 'bx bx-info-circle');
                        data = data.replaceAll('fas fa-id-card', 'bx bxs-id-card');
                        data = data.replaceAll('fas fa-mars', 'bx bx-male-sign');
                        data = data.replaceAll('fas fa-language', 'bx bx-flag');
                        data = data.replaceAll('fas fa-globe', 'bx bx-globe');
                        data = data.replaceAll('far fa-clock', 'bx bx-time');
                        data = data.replaceAll('fas fa-ellipsis-v', 'bx bx-dots-vertical-rounded');
                        data = data.replaceAll('far fa-hand-point-right', 'bx bxs-hand-right');
                        data = data.replaceAll('fas fa-cogs', 'bx bx-cog');
                        data = data.replaceAll('far fa-pause-circle', 'bx bx-pause-circle');
                        data = data.replaceAll('fas fa-retweet', 'bx bxs-share');
                        data = data.replaceAll('fas fa-sync-alt', 'bx bx-sync');
                        data = data.replaceAll('fas fa-sync', 'bx bx-sync');
                        data = data.replaceAll('fas fa-briefcase', 'bx bx-briefcase');
                        data = data.replaceAll('far fa-stop-circle', 'bx bx-stop-circle');
                        data = data.replaceAll('far fa-play-circle', 'bx bx-play-circle');

                        return data;
                    }
                },
            ],
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                if (areWeUsingScroll) {
                    if (perscroll1) perscroll1.destroy();
                    perscroll1 = new PerfectScrollbar('#acelle-datatable_wrapper .dataTables_scrollBody');
                }
            },
            scrollX: 'auto',
            fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                if (areWeUsingScroll) {
                    if (perscroll1) perscroll1.destroy();
                    perscroll1 = new PerfectScrollbar('#acelle-datatable_wrapper .dataTables_scrollBody');
                }
            },
            "drawCallback": function (settings) {
                $('table [data-toggle="tooltip"]').tooltip('dispose');
                $('table [data-toggle="tooltip"]').tooltip(
                    {
                        placement: 'left',
                        container: 'body',
                        html: true,
                        template: '<div class="tooltip tooltip_pd" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                    }
                );
            }
        });

        $(document).on('submit', '#acelle-integration-form', function (event) {
            event.preventDefault();

            var submit_button = $('#acelle-submit-button');

            // Enables spinner
            submit_button[0].classList.remove('disabled', 'btn-progress');
            submit_button[0].classList.add('disabled', 'btn-progress');

            var form_data = {
                api_url: $('#api-url').val(),
                api_key: $('#api-key').val(),
                tracking_name: $('#tracking-name').val()
            };

            $.ajax({
                method: 'POST',
                dataType: 'JSON',
                data: form_data,
                url: '<?= base_url('email_auto_responder_integration/acelle_add') ?>',
                success: function (response) {

                    if (true === response.error) {
                        swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error'
                        });

                        // Enables spinner
                        submit_button[0].classList.remove('disabled', 'btn-progress');
                    }

                    if (true === response.success) {
                        swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success'
                        });

                        // Resets form and toggle modal
                        $('#acelle-integration-form')[0].reset();
                        $('#acelle-integration-modal').modal('toggle');

                        // Enables spinner
                        submit_button[0].classList.remove('disabled', 'btn-progress');

                        // Reloads datatable
                        data_table.ajax.reload();
                    }
                },
                error: function (xhr, status, error) {
                    swal.fire({
                        title: 'Error!',
                        text: error,
                        icon: 'error'
                    });
                }
            });
        });

        $(document).on('click', '#acelle-details-button', function (event) {
            event.preventDefault();

            var block_ele = $('#acelle-details-modal .modal-body');
            $(block_ele).block({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 1,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });

            var tracking_id = $(this).data('tracking-id'),
                modal = $('#acelle-details-modal'),
                spinner = $('#detail-first-view');

            // Opens up modal
            modal.modal();

            $.ajax({
                method: 'POST',
                dataType: 'JSON',
                data: {tracking_id},
                url: '<?= base_url('email_auto_responder_integration/acelle_details') ?>',
                success: function (response) {

                    if (true === response.error) {

                        // Hides spinner
                        spinner.hide();

                        swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error'
                        });
                        return;
                    }

                    if (Array.isArray(response)) {
                        var str = '',
                            tracking_name = '';
                        response.forEach(item => {

                            str += '<div class="tickets-list"><a href="#" class="ticket-item list-group-item-action"><div class="ticket-title mb-1"><h5 class="text-primary"><small class="float-right text-muted" style="font-size:12px;">' + item.inserted_at + '</small>' + item.list_name + '</h5></div><div class="row"><div class="col-12"><div class="ticket-info d-flex"><div><?php echo $this->lang->line("ID"); ?></div><div class="bullet"></div><div class="text-primary">' + item.list_id + '</div></div></div></div></div></a></div>';

                            tracking_name = item.tracking_name;
                        });

                        // Hides spinner
                        block_ele.unblock();
                        $('#display-tracking-name').text(tracking_name);
                        $('#acelle-list-group').html(str);
                    }
                },
                error: function (xhr, status, error) {

                    // Hides spinner
                    block_ele.unblock();

                    swal.fire({
                        title: 'Error!',
                        text: error,
                        icon: 'error'
                    });
                }
            });
        });

        $(document).on('click', '#acelle-delete-button', function (event) {
            event.preventDefault();

            var tracking_id = $(this).data('tracking-id');

            swal.fire({
                title: 'Warning!',
                text: '<?= $this->lang->line('Are you sure you want to delete this account?') ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            }).then(yes => {
                if (yes) {
                    $.ajax({
                        method: 'POST',
                        dataType: 'JSON',
                        data: {tracking_id},
                        url: '<?= base_url('email_auto_responder_integration/acelle_delete') ?>',
                        success: function (response) {
                            if (true === response.error) {
                                iziToast.error({
                                    title: '<?php echo $this->lang->line("Error"); ?>',
                                    message: response.message,
                                    position: 'bottomRight'
                                });
                            }

                            if (true === response.success) {
                                iziToast.success({
                                    title: '<?php echo $this->lang->line("Success"); ?>',
                                    message: response.message,
                                    position: 'bottomRight'
                                });

                                // Reloads datatable
                                data_table.ajax.reload();
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(error);
                            swal.fire({
                                title: 'Error!',
                                text: error,
                                icon: 'error'
                            });
                        }
                    });
                } else {
                    return;
                }
            });
        });

        $(document).on('click', '#acelle-refresh-button', function (event) {
            event.preventDefault();

            var user_id = $(this).data('user-id');
            var tracking_id = $(this).data('tracking-id');

            swal.fire({
                title: 'Warning!',
                text: '<?= $this->lang->line('Are you sure you want to refresh this account?') ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            }).then(yes => {
                if (yes) {
                    // Adds spinner
                    $(this).removeClass('btn-outline-primary disabled btn-progress');
                    $(this).addClass('disabled btn-progress bg-primary');

                    $.ajax({
                        method: 'POST',
                        dataType: 'JSON',
                        data: {tracking_id, user_id},
                        url: '<?= base_url('email_auto_responder_integration/acelle_refresh') ?>',
                        success: function (response) {
                            if (true === response.error) {
                                // Removes spinner
                                $(this).addClass('btn-outline-primary');
                                $(this).removeClass('disabled btn-progress bg-primary');

                                iziToast.error({
                                    title: '<?php echo $this->lang->line("Error"); ?>',
                                    message: response.message,
                                    position: 'bottomRight'
                                });
                            }

                            if (true === response.success) {
                                // Removdes spinner
                                $(this).addClass('btn-outline-primary');
                                $(this).removeClass('disabled btn-progress bg-primary');

                                iziToast.success({
                                    title: '<?php echo $this->lang->line("Success"); ?>',
                                    message: response.message,
                                    position: 'bottomRight'
                                });

                                // Reloads datatable
                                data_table.ajax.reload();
                            }
                        },
                        error: function (xhr, status, error) {
                            // Removes spinner
                            $(this).addClass('btn-outline-primary');
                            $(this).removeClass('disabled btn-progress bg-primary');

                            swal.fire({
                                title: 'Error!',
                                text: error,
                                icon: 'error'
                            });
                        }
                    });
                } else {
                    return;
                }
            });
        });
    });
</script>