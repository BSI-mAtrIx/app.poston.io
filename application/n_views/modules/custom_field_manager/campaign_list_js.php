<script>
    var base_url = "<?php echo site_url(); ?>";

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

        <?php if($page_id == 0 and $iframe == 0){ ?>
        window.location.href = base_url + 'custom_field_manager/campaign_list/' + $('#bot_list_select').val() + '/0/' + '<?php echo $media_type; ?>';
        <?php } ?>

        <?php if($page_id != 0 and $iframe == 0){ ?>
        $('#bot_list_select').val(<?php echo $page_id; ?>);
        <?php } ?>

        $(document).on('change', '#bot_list_select', function (event) {
            window.location.href = base_url + 'custom_field_manager/campaign_list/' + $('#bot_list_select').val() + '/0/' + '<?php echo $media_type; ?>';
        });

        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[2, "asc"]],
            pageLength: 10,
            ajax: {
                "url": base_url + 'custom_field_manager/campaign_list_data',
                "type": 'POST',
                data: function (d) {
                    d.media_type = $('#media_type').val();
                }
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1, 3],
                    visible: false
                },
                {
                    targets: [3, 4, 5],
                    className: 'text-center'
                },
                {
                    targets: [0, 5],
                    sortable: false
                },
                {
                    targets: [5],
                    "render": function (data, type, row) {
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


                        return data;
                    }
                },
            ],
            fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                if (areWeUsingScroll) {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                }
            },
            scrollX: 'auto',
            fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                if (areWeUsingScroll) {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
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


        $(document).on('click', '#search_submit', function (event) {
            event.preventDefault();
            table.draw();
        });
        // end of datatable


        // Displays flow details
        var table1 = '';
        var perscroll1;
        $(document).on('click', '.view_report', function (e) {
            e.preventDefault();

            // Grabs form ID
            var table_id = $(this).attr('table_id');
            $("#put_table_id").val(table_id);

            // var spinner = $('#detail-first-view');
            // $(spinner).show();

            $('#detail-flow-input').modal();

            setTimeout(function () {
                if (table1 == '') {
                    // $("#put_form_id").val(form_id);
                    var base_url = "<?php echo base_url(); ?>";
                    table1 = $("#mytable1").DataTable({
                        serverSide: true,
                        processing: true,
                        bFilter: false,
                        order: [[5, "desc"]],
                        pageLength: 10,
                        ajax: {
                            url: base_url + 'custom_field_manager/get_submitted_subscribers',
                            type: 'POST',
                            data: function (d) {
                                d.table_id = $("#put_table_id").val();
                                d.searching = $("#searching2").val();
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
                                    data = data.replaceAll('far fa-hand-point-right', 'bx bxs-hand-right');


                                    return data;
                                }
                            },
                            {
                                targets: [1],
                                "render": function (data, type, row) {
                                    data = data.replaceAll('<img ', '<img onerror="this.onerror=null;" ');
                                    data = data.replaceAll('null;', "null;this.src='<?php echo base_url('assets/img/avatar/avatar-1.png'); ?>'");
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
                        }
                    });
                } else table1.draw();
            }, 1000);

        });


        $(document).on('keyup', '#searching2', function (event) {
            event.preventDefault();
            table1.draw();
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


        // delete label
        $(document).on('click', '.delete_campaign', function (event) {
            event.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Delete Flow Campaign"); ?>',
                text: '<?php echo $this->lang->line("If you delete this campaign, all the questions and answers corresponding to this campaign will also be deleted. Are you sure about deleting this campaign?"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isDenied || willDelete.isDismissed) {
                        return;
                    }
                    if (willDelete.isConfirmed) {
                        var table_id = $(this).attr("table_id");
                        var media_type = $(this).attr("media_type");
                        var csrf_token = $("#csrf_token").val();

                        $(this).addClass('btn-danger btn-progress').removeClass('btn-outline-danger');
                        var that = $(this);

                        $.ajax({
                            url: '<?php echo base_url('custom_field_manager/ajax_delete_flow_campaign'); ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: {table_id: table_id, csrf_token: csrf_token, media_type: media_type},
                            success: function (response) {
                                if (response.status == 'successfull') {
                                    iziToast.success({title: '', message: response.message, position: 'bottomRight'});
                                } else {
                                    swal.fire("<?php echo $this->lang->line('Error') ?>", response.message, "error");
                                }

                                table.draw();
                                $(that).removeClass('btn-danger btn-progress').addClass('btn-outline-danger');
                            }
                        });
                    }
                });

        });

        $(document).on('click', '.export_data', function (e) {
            e.preventDefault();
            $(this).removeClass('btn-outline-success');
            $(this).addClass('btn-success btn-progress disabled');
            var table_id = $(this).attr('table_id');
            // Downloads file via ajax call
            $.ajax({
                context: this,
                type: 'POST',
                dataType: 'JSON',
                data: {table_id: table_id},
                url: '<?php echo base_url('custom_field_manager/export_flow_data'); ?>',
                success: function (res) {
                    // Stops spinner
                    $(this).removeClass('btn-success btn-progress disabled');
                    $(this).addClass('btn-outline-success');
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
                        window.location = '<?php echo base_url('custom_field_manager/export_flow_data'); ?>';
                    }
                },
                error: function (xhr, status, error) {
                    // Stops spinner
                    $(this).removeClass('btn-success disabled');
                    $(this).addClass('btn-outline-success');
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

    function get_subscriber_formdata(id, subscribe_id, page_id, form_id) {
        $("#waiting-div").show();
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>custom_field_manager/get_subscriber_formdata",
            data: {
                id: id,
                page_id: page_id,
                subscribe_id: subscribe_id,
                form_id: form_id
            },
            success: function (response) {
                $("#waiting-div").hide();
                $(".formdata_div").html(response);
            }
        });
    }

</script>
