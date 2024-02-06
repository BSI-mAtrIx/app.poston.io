<script>
    var base_url = "<?php echo site_url(); ?>";
    var table_id = "<?php echo $table_id; ?>";


    $(document).ready(function () {

        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: false,
            order: [[2, "desc"]],
            pageLength: 10,
            ajax: {
                url: base_url + 'comment_reply_enhancers/page_response_report_data/' + table_id,
                type: 'POST',
                dataSrc: function (json) {
                    //$(".table-responsive").niceScroll();
                    return json.data;
                },
                data: function (d) {
                    d.post_id = $('#post_id').val();
                }
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1, 2, 5, 6, 7, 8],
                    visible: false
                },
                {
                    targets: '',
                    className: 'text-center'
                },
                {
                    targets: [0, 4, 9, 11],
                    sortable: false
                },
                {
                    targets: [9],
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
                        data = data.replaceAll('<div class="dropdown-title">Options</div>', '<h6 class="dropdown-header">Options</h6>');
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
                        data = data.replaceAll('fa fa-bug', 'bx bx-bug');

                        return data;
                    }
                },
            ]
        });


        $(document).on('click', '#search_submit', function (event) {
            event.preventDefault();
            table.draw();
        });


        // report table started
        var table1 = '';
        var perscroll1;
        $(document).on('click', '.view_report', function (e) {
            e.preventDefault();
            var table_id = $(this).attr('table_id');

            if (table_id != '') {
                $("#put_row_id").val(table_id);
                $("#download").attr("href", base_url + "comment_reply_enhancers/download_get_reply_info/" + table_id);
            }


            $("#view_report_modal").modal();

            var commnet_hide_delete_addon = "<?php echo $commnet_hide_delete_addon; ?>";
            if (commnet_hide_delete_addon == 1)
                var visible_section = "";
            else
                var visible_section = [9];

            if (table1 == '') {

                table1 = $("#mytable1").DataTable({
                    serverSide: true,
                    processing: true,
                    bFilter: false,
                    order: [[3, "desc"]],
                    pageLength: 10,
                    ajax: {
                        url: base_url + 'comment_reply_enhancers/ajax_get_reply_info',
                        type: 'POST',
                        data: function (d) {
                            d.table_id = $("#put_row_id").val();
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
                            targets: visible_section,
                            visible: false
                        },
                        {
                            targets: '',
                            className: 'text-center'
                        },
                        {
                            targets: [0, 1, 2, 5, 6, 7, 8, 9],
                            sortable: false
                        }
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

            $("#outside_filter").html('');
            setTimeout(function () {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url(); ?>comment_reply_enhancers/get_count_info",
                    data: {table_id: table_id},
                    dataType: 'JSON',
                    success: function (response) {
                        if (response.status == '1')
                            $("#outside_filter").html(response.str);
                    }
                });
            }, 2000);

        });

        $(document).on('keyup', '#searching', function (event) {
            event.preventDefault();
            table1.draw();
        });


    });


</script>