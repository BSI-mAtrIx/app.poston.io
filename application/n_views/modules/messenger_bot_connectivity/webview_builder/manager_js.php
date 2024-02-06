<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/forms/select/select2.full.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/moment.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
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
        //todo: areWeUsingScroll
        $(document).ready(function () {
            'use strict';

            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%',

            });
        });


        <?php if(!empty($page_info) and $page_id == 0 and $iframe == 0){ ?>
        window.location.href = base_url + 'messenger_bot_connectivity/webview_builder_manager/' + $('#bot_list_select').val();
        <?php } ?>

        <?php if(!empty($page_info) and $page_id != 0 and $iframe == 0){ ?>
        $('#bot_list_select').val(<?php echo $page_id; ?>);
        <?php } ?>

        $(document).on('change', '#bot_list_select', function (event) {
            window.location.href = base_url + 'messenger_bot_connectivity/webview_builder_manager/' + $('#bot_list_select').val();
        });

        var data_table = $('#webview-datatable').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],
            pageLength: 10,
            ajax: {
                url: '<?= base_url('messenger_bot_connectivity/webview_manager_data') ?>',
                type: 'POST',
                data: function (d) {
                    d.page_id = $('#page_id').val();
                },
                dataSrc: function (json) {
                    //$(".table-responsive").niceScroll();
                    //todo: nicescroll
                    return json.data;
                },
            },
            columns: [
                {data: 'id'},
                {data: 'form_name'},
                {data: 'page_name'},
                {data: 'form_created_time'},
                {data: 'total_form_submit'},
                {data: 'last_form_submitted_at'},
                {data: 'actions'}
            ],
            language: {
                url: "<?= base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
            },
            columnDefs: [
                {"sortable": false, "targets": [0, 6]},
                {
                    targets: [0, 2],
                    visible: false
                },
                {
                    targets: [6],
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
                        data = data.replaceAll('255px', '340px');
                        return data;
                    },
                },
            ],
            dom: '<"top"f>rt<"bottom"lip><"clear">',
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
        })

        // Displays form details
        var table1 = '';
        var perscroll1;
        $(document).on('click', '#detail-webview-form', function (e) {
            e.preventDefault();

            // Grabs form ID
            var form_id = $(this).data('form-id');
            $("#put_form_id").val(form_id);

            var spinner = $('#detail-first-view');

            $(spinner).show();
            $('#detail-webview-form-modal').modal();

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: '<?= base_url('messenger_bot_connectivity/handle_form_details_data') ?>',
                data: {form_id},
                success: function (data) {

                    if (true === data.error) {
                        swal.fire({
                            title: '<?php echo $this->lang->line('Error!'); ?>',
                            text: data.message,
                            icon: 'error'
                        })
                        $('#detail-webview-form-modal').modal('toggle')
                        return
                    }

                    if (data) {
                        $(spinner).hide();
                    }

                    if (data.form_title) {
                        $('#detail-title').html(data.form_title)
                    }

                    if (data.page_name) {
                        $('#detail-page-name').html(data.page_name)
                    }

                    if (data.postback_id) {
                        $('#detail-postback-id').html(data.postback_id)
                    }

                    if (data.group_name) {
                        if (Array.isArray(data.group_name)) {

                            var str = '';
                            data.group_name.forEach(group => {
                                str += '<span class="badge badge-light">' + group + '</span>';
                            })

                            $('#detail-assign-label').html(str)
                        }
                    }

                    if (data.inserted_at) {
                        $('#detail-created-at').html(data.inserted_at)
                    }

                    if (data.canonical_id) {
                        $('#detail-form-id').html(data.canonical_id)
                    }
                }
            });

            setTimeout(function () {
                if (table1 == '') {
                    // $("#put_form_id").val(form_id);
                    var base_url = "<?php echo base_url(); ?>";
                    table1 = $("#mytable1").DataTable({
                        serverSide: true,
                        processing: true,
                        bFilter: false,
                        order: [[2, "asc"]],
                        pageLength: 10,
                        ajax: {
                            url: base_url + 'messenger_bot_connectivity/get_submitted_subscribers',
                            type: 'POST',
                            data: function (d) {
                                d.form_id = $("#put_form_id").val();
                                d.searching = $("#searching").val();
                            }
                        },
                        language:
                            {
                                url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                            },
                        dom: '<"top"f>rt<"bottom"lip><"clear">',
                        columnDefs: [
                            {
                                targets: '',
                                className: 'text-center'
                            },
                            {
                                targets: [0, 1, 6],
                                sortable: false
                            },
                            {
                                targets: [1],
                                "render": function (data, type, row) {
                                    data = data.replaceAll('<img ', '<img onerror="this.onerror=null;" ');
                                    data = data.replaceAll('null;', "null;this.src='<?php echo base_url('assets/img/avatar/avatar-1.png'); ?>'");
                                    return data;
                                }
                            },
                            {
                                targets: [6],
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
                        fnInitComplete: function () { // when initialization is completed then apply scroll plugin
                            if (areWeUsingScroll) {
                                if (perscroll1) perscroll1.destroy();
                                perscroll1 = new PerfectScrollbar('#mytable1_wrapper .dataTables_scrollBody');
                            }
                        },
                        scrollX: 'auto',
                        fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                            if (areWeUsingScroll) {
                                if (perscroll1) perscroll1.destroy();
                                perscroll1 = new PerfectScrollbar('#mytable1_wrapper .dataTables_scrollBody');
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
                } else table1.draw();
            }, 1000);

        });

        $(document).on('keyup', '#searching', function (event) {
            event.preventDefault();
            table1.draw();
        });


        // Attempts to delete form
        $(document).on('click', '#delete-webview-form', function (e) {
            e.preventDefault()

            // Grabs form ID
            var form_id = $(this).data('form-id')

            swal.fire({
                title: '<?php echo $this->lang->line('Are you sure?'); ?>',
                text: '<?php echo $this->lang->line('Once deleted, you will not be able to recover this form!'); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            }).then((yes) => {
                if (yes) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('messenger_bot_connectivity/delete_form_data') ?>',
                        dataType: 'JSON',
                        data: {form_id},
                        success: function (response) {
                            if (response) {
                                if (response.success === true) {
                                    // Reloads datatable
                                    data_table.ajax.reload()

                                    // Displays success message
                                    iziToast.success({title: '', message: response.message, position: 'bottomRight'});
                                } else if (response.error === true) {
                                    // Displays error message
                                    iziToast.error({title: '', message: response.message, position: 'bottomRight'});
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
            })
        });

        $(document).on('click', '.get_subscriber_formdata', function (e) {
            e.preventDefault();
            var subscriber_table_id = $(this).attr('data-id');
            var form_id = $(this).attr('data-form-id');
            var page_table_id = $(this).attr('page_table_id');
            var subscribe_id = $(this).attr('subscribe_id');
            $("#get_subscriber_formdata").modal();
            get_subscriber_formdata(subscriber_table_id, subscribe_id, page_table_id, form_id);
        });

        $('.modal').on("hidden.bs.modal", function (e) {
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
            }
        });

    })

    function get_subscriber_formdata(id, subscribe_id, page_id, form_id) {
        $("#waiting-div").show();
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>messenger_bot_connectivity/get_subscriber_formdata",
            data: {id: id, page_id: page_id, subscribe_id: subscribe_id, form_id: form_id},
            success: function (response) {
                $("#waiting-div").hide();
                $(".formdata_div").html(response);
            }
        });
    }
</script>
<script>
    $(document).ready(function () {
        // Exports form data
        $(document).on('click', '#webview-export-form-data', function (e) {
            e.preventDefault();
            // Makes reference
            var that = this,
                // Gets class of this elment
                prev_el = $(that).parent().prev(),
                prev_el_classes = prev_el ? prev_el[0].className : '',
                new_el_classes = prev_el_classes.replace('-outline', ''),
                // Grabs form ID
                form_id = $(this).data('form-id');
            // Shows spinner
            $(prev_el).removeClass();
            $(prev_el).addClass(new_el_classes.concat(' btn-progress disabled'));
            // Downloads file via ajax call
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {form_id},
                url: '<?php echo base_url('messenger_bot_connectivity/export_form_data'); ?>',
                success: function (res) {
                    // Stops spinner
                    $(prev_el).removeClass();
                    $(prev_el).addClass(prev_el_classes);
                    // Shows error if something goes wrong
                    if (res.error) {
                        swal.fire({
                            icon: 'error',
                            text: res.error,
                            title: '<?php echo $this->lang->line('Error!'); ?>',
                        });
                        return;
                    }
                    if (res.info) {
                        swal.fire({
                            icon: 'info',
                            text: res.info,
                            title: '<?php echo $this->lang->line('Info!'); ?>',
                        });
                        return;
                    }
                    // If everything goes well, requests for downloading the file
                    if (res.status && 'ok' === res.status) {
                        window.location = '<?php echo base_url('messenger_bot_connectivity/export_form_data'); ?>';
                    }
                },
                error: function (xhr, status, error) {
                    // Stops spinner
                    $(prev_el).removeClass();
                    $(prev_el).addClass(prev_el_classes);
                    // Shows error message
                    swal.fire({
                        icon: 'error',
                        text: error,
                        title: '<?php echo $this->lang->line('Error!'); ?>',
                    });
                },
            });
        });
    });
</script>