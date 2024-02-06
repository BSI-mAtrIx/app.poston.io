<script>
    $(document).ready(function () {
        $('body').addClass('menu-collapsed');
        $('.brand-logo').removeClass('d-none');
    });
</script>
<script type="text/javascript">

    var base_url = "<?php echo base_url();?>";
    var user_id = "<?php echo $this->user_id;?>";

    var youhavenotselected = "<?php echo $youhavenotselected;?>";
    var leadsatatime = "<?php echo $leadsatatime;?>";
    var youcanselectupto = "<?php echo $youcanselectupto;?>";
    var leadsyouhaveselected = "<?php echo $leadsyouhaveselected;?>";
    var leads = "<?php echo $leads;?>";
    var youhavenotselectedanyleadtoassigngroup = "<?php echo $youhavenotselectedanyleadtoassigngroup; ?>";
    var youhavenotselectedanyleadgroup = "<?php echo $youhavenotselectedanyleadgroup; ?>";
    var groupshavebeenassignedsuccessfully = "<?php echo $groupshavebeenassignedsuccessfully; ?>";

    function get_page_details(switch_to_instagram, elem) {
        $('#middle_column .waiting').show();
        $('#middle_column_content').hide();

        var page_table_id = $(elem).attr('page_table_id');
        if (typeof (page_table_id) === 'undefined') {
            elem = $(".list-group li:first");
            page_table_id = $(elem).attr('page_table_id');
        }

        $('.page_list_item').removeClass('active');
        $(elem).addClass('active');

        $.ajax({
            type: 'POST',
            url: "<?php echo site_url();?>subscriber_manager/get_page_details",
            data: {page_table_id: page_table_id, switch_to_instagram: switch_to_instagram},
            dataType: 'JSON',
            success: function (response) {
                response.middle_column_content = response.middle_column_content.replaceAll('<span class="custom-switch-indicator"></span>', '');
                response.middle_column_content = response.middle_column_content.replaceAll('<span class="custom-switch-description">', '<label class="custom-control-label mr-1" for="switch_to_instagram"></label2><span class="font-medium-1 flex-wrap">');
                response.middle_column_content = response.middle_column_content.replaceAll('</a></span>', '</a></span>');
                response.middle_column_content = response.middle_column_content.replaceAll('custom-switch-input', 'custom-control-input');
                response.middle_column_content = response.middle_column_content.replaceAll('<label class="custom-switch float-right">', '<div class="custom-control custom-switch custom-control-inline mb-1 float-right">');
                response.middle_column_content = response.middle_column_content.replaceAll('</label>', '</a></div>');
                response.middle_column_content = response.middle_column_content.replaceAll('</label2>', '</label>');
                response.middle_column_content = response.middle_column_content.replaceAll('full_width', 'container');
                response.middle_column_content = response.middle_column_content.replaceAll('fab fa-instagram', 'bx bxl-instagram');
                response.middle_column_content = response.middle_column_content.replaceAll('fas fa-info-circle', 'bx bx-info-circle');
                response.middle_column_content = response.middle_column_content.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');


                $("#middle_column_content").html(response.middle_column_content).show();
                $("#put_page_label_list").html(response.dropdown);
                $('#middle_column .waiting').hide();
            }
        });
    }

    $("document").ready(function () {

        $(".page_list_item").click(function (e) {
            e.preventDefault();
            var switch_to_instagram = "0";
            if ($('#switch_to_instagram').is(':checked')) switch_to_instagram = "1";
            get_page_details(switch_to_instagram, this);
        });

        $(document).on('change', '#switch_to_instagram', function (e) {
            e.preventDefault();
            var switch_to_instagram = "0";
            if ($('#switch_to_instagram').is(':checked')) switch_to_instagram = "1";
            var elem = $(".page_list_item.active")
            get_page_details(switch_to_instagram, elem);
        });

        $(document).on('click', '.import_data', function (e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $("#start_scanning").attr("data-id", id);
            var switch_to_instagram = "0";
            if ($('#switch_to_instagram').is(':checked')) switch_to_instagram = "1";
            if (switch_to_instagram == "1") $("#folder_con").hide();
            else $("#folder_con").show();
            $("#import_lead_modal").modal();
        });

        $(document).on('click', '.subscriber_info_modal', function (e) {
            e.preventDefault();
            $("#subscriber_info_modal").modal();
        });


        $(document).on('click', '#start_scanning', function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var scan_limit = $("#scan_limit").val();
            var folder = $("#folder").val();
            $("#start_scanning").addClass('btn-progress');
            $(".auto_sync_lead_page").addClass('disabled');
            $(".user_details_modal").addClass('disabled');
            $("#scan_load").attr('class', '');
            var switch_to_instagram = "0";
            if ($('#switch_to_instagram').is(':checked')) switch_to_instagram = "1";
            $.ajax({
                context: this,
                type: 'POST',
                url: "<?php echo site_url();?>subscriber_manager/import_lead_action",
                data: {id: id, scan_limit: scan_limit, folder: folder, switch_to_instagram: switch_to_instagram},
                dataType: 'JSON',
                success: function (response) {
                    $("#start_scanning").removeClass('btn-progress');

                    if (response.status == '1') {
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success');
                    } else {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }
                }
            });

        });


        var table1 = '';
        $(document).on('click', '.user_details_modal', function (e) {

            e.preventDefault();
            var page_id = $(this).attr('id');
            var fb_page_id = $(this).attr('fb-page-id');
            $("#put_page_id").val(page_id);
            var switch_to_instagram = "0";
            if ($('#switch_to_instagram').is(':checked')) switch_to_instagram = "1";

            var download_url = base_url + "subscriber_manager/download_full/" + user_id + "-" + page_id + "-" + switch_to_instagram;
            var migrate_id = user_id + "-" + page_id;

            $("#download_list").attr("href", download_url);
            $("#migrate_list").attr("button_id", migrate_id);
            $("#assign_group").attr("button_id", page_id);

            $("#htm").modal();

            if (table1 == '') {
                var perscroll;
                table1 = $("#mytable").DataTable({
                    serverSide: true,
                    processing: true,
                    bFilter: false,
                    order: [[7, "desc"]],
                    pageLength: 10,
                    ajax: {
                        url: base_url + 'subscriber_manager/lead_list_data',
                        type: 'POST',
                        dataSrc: function (json) {
                            //$(".table-responsive").niceScroll();
                            return json.data;
                        },
                        data: function (d) {
                            d.page_id = $('#put_page_id').val();
                            d.search_value = $('#search_value').val();
                            d.label_id = $('#label_id').val();
                            if ($('#switch_to_instagram').is(':checked')) d.switch_to_instagram = "1";
                            else d.switch_to_instagram = "0";
                        }
                    },
                    language:
                        {
                            url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                        },
                    dom: '<"top"f>rt<"bottom"lip><"clear">',
                    columnDefs: [
                        {
                            targets: [5],
                            visible: false
                        },
                        {
                            targets: [0, 5, 6, 7],
                            className: 'text-center'
                        },
                        {
                            targets: [0, 1, 4, 5, 6],
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
                                data = data.replaceAll('fas fa-user-times', 'bx bx-user-minus');


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
                    }
                });
            } else table1.draw(false);
        });


        $(document).on('click', '#search_subscriber', function (e) {
            e.preventDefault();
            table1.draw(false);
        });

        $(document).on('change', '#label_id', function (e) {
            table1.draw(false);
        });


        $(document).on('click', '.auto_sync_lead_page', function (e) {
            e.preventDefault();
            var page_id = $(this).attr('auto_sync_lead_page_id');
            var operation = $(this).attr('enable_disable');
            var base_url = '<?php echo site_url();?>';

            var disabledsuccessfully = '<?php echo $disabledsuccessfully;?>';
            var enabledsuccessfully = '<?php echo $enabledsuccessfully;?>';

            $(".import_data").addClass('disabled');
            $(".auto_sync_lead_page").addClass('disabled');
            $(".user_details_modal").addClass('disabled');
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>subscriber_manager/enable_disable_auto_sync",
                data: {page_id: page_id, operation: operation},
                success: function (response) {
                    if (operation == "0") iziToast.success({
                        title: '',
                        message: disabledsuccessfully,
                        position: 'bottomRight'
                    });
                    else iziToast.success({title: '', message: enabledsuccessfully, position: 'bottomRight'});

                    $(".page_list_item.active").click();
                }
            });

        });

        $(document).on('click', '.client_thread_subscribe_unsubscribe', function (e) {
            e.preventDefault();
            $(this).addClass('btn-progress');
            var client_subscribe_unsubscribe_status = $(this).attr('id');

            $.ajax({
                context: this,
                type: 'POST',
                dataType: 'JSON',
                url: "<?php echo site_url();?>subscriber_manager/client_subscribe_unsubscribe_status_change",
                data: {client_subscribe_unsubscribe_status: client_subscribe_unsubscribe_status},
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    // $("#"+client_subscribe_unsubscribe_status).parent().parent().prev().html(response.label);
                    $("#" + client_subscribe_unsubscribe_status).parent().html(response.button);

                    if (response.status == '1') iziToast.success({
                        title: '',
                        message: response.message,
                        position: 'bottomRight'
                    });
                    else iziToast.error({title: '', message: response.message, position: 'bottomRight'});
                }
            });

        });

        $(document).on('click', '#migrate_list', function (e) {

            e.preventDefault();

            swal.fire({
                title: '<?php echo $this->lang->line("Migrate as Bot Subscriber"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to migrate this list as your bot subscribers?"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var base_url = '<?php echo site_url();?>';
                        $(this).parent().prev().addClass('btn-progress');

                        var user_page_id = $("#migrate_list").attr('button_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>subscriber_manager/migrate_lead_to_bot",
                            dataType: 'json',
                            data: {user_page_id: user_page_id},
                            success: function (response) {
                                $(this).parent().prev().removeClass('btn-progress');
                                if (response.status == '1') {
                                    swal.fire('<?php echo $this->lang->line("Migration Successful"); ?>', response.message, 'success');
                                } else {
                                    swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                }
                            }
                        });
                    }
                });
        });

        $(document).on('click', '#assign_group', function (e) {
            e.preventDefault();
            var upto = 500;
            var selected_page = $("#assign_group").attr('button_id');// database id
            var ids = [];
            $(".datatableCheckboxRow:checked").each(function () {
                ids.push(parseInt($(this).val()));
            });
            var selected = ids.length;

            if (ids == "") {
                swal.fire('<?php echo $this->lang->line("Warning") ?>', youhavenotselected + " " + upto + " " + leadsatatime, 'warning');
                return;
            }
            if (selected > upto) {
                swal.fire('<?php echo $this->lang->line("Warning") ?>', youcanselectupto + " " + upto + " " + leadsyouhaveselected + " " + selected + " " + leads, 'warning');
                return;
            }

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>subscriber_manager/get_label_dropdown_multiple",
                data: {selected_page: selected_page},
                success: function (response) {
                    $("#get_labels").html(response);
                }
            });

            $("#assign_group_modal").modal();
        });

        $(document).on('click', '#assign_group_submit', function (e) {
            e.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Assign Label"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to assign selected labels to your selected subscribers? Please be noted that bulk assigning labels will replace subscribers previous labels if any."); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var ids = [];
                        $(".datatableCheckboxRow:checked").each(function () {
                            ids.push(parseInt($(this).val()));
                        });
                        var selected = ids.length;


                        if (ids == "") {
                            swal.fire('<?php echo $this->lang->line("Warning") ?>', youhavenotselected + " " + upto + " " + leadsatatime, 'warning');
                            return;
                        }

                        var group_id = $("#label_ids").val();
                        var page_id = $("#assign_group").attr('button_id');
                        var count = group_id.length;

                        if (count == 0) {
                            swal.fire('<?php echo $this->lang->line("Error") ?>', youhavenotselectedanyleadgroup, 'error');
                            return;
                        }

                        $("#assign_group_submit").addClass("btn-progress");

                        $.ajax({
                            type: 'POST',
                            url: "<?php echo site_url(); ?>subscriber_manager/bulk_group_assign",
                            data: {ids: ids, group_id: group_id, page_id: page_id},
                            success: function (response) {
                                $("#assign_group_submit").removeClass("btn-progress");
                                swal.fire('<?php echo $this->lang->line("Label Assign") ?>', groupshavebeenassignedsuccessfully + " (" + selected + ")", 'success')
                                    .then((value) => {
                                        $("#assign_group_modal").modal('hide');
                                        table1.draw(false);
                                    });

                            }
                        });
                    }
                });
        });

        $('.modal').on("hidden.bs.modal", function (e) {
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
            }
        });

    });

    $("document").ready(function () {
        $('#import_lead_modal').on('hidden.bs.modal', function () {
            $(".page_list_item.active").click();
        });
    });

    $("document").ready(function () {
        $('#htm').on('hidden.bs.modal', function () {
            $(".page_list_item.active").click();
        });

    });

    $("document").ready(function () {
        setTimeout(function () {
            var default_switch_to_instagram = "<?php echo $switch_to_instagram ?? '0';?>";
            var session_value = "<?php echo $this->session->userdata('sync_subscribers_get_page_details_page_table_id'); ?>";
            var elem;
            // var switch_to_instagram = "0";
            // if ($('#switch_to_instagram').is(':checked')) switch_to_instagram = "1";
            if (session_value == '') elem = $(".list-group li:first");
            else elem = $("li[page_table_id='" + session_value + "']");
            get_page_details(default_switch_to_instagram, elem);
        }, 500);

        $(".img_fb_onerror").on("error", function () {
            $(this).attr('src', base_url + 'assets/img/avatar/avatar-1.png');
        });
    });


</script>