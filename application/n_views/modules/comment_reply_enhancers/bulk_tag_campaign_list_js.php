<?php
$somethingwentwrong = $this->lang->line("something went wrong.");
$pleasewait = $this->lang->line("please wait") . '...';
$areyousure = $this->lang->line("are you sure");
$Doyouwanttodeletethisrecordfromdatabase = $this->lang->line("do you want to delete this record from database?");
?>

<?php
include(FCPATH . 'application/n_views/include/upload_js.php');
?>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/moment.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script type="text/javascript"
        src="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
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

    var base_url = "<?php echo site_url(); ?>";
    var somethingwentwrong = "<?php echo $somethingwentwrong;?>";
    var pleasewait = "<?php echo $pleasewait;?>";
    var areyousure = "<?php echo $areyousure;?>";


</script>

<script>

    $("document").ready(function () {

        $(document).ready(function () {
            'use strict';

            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%',

            });
        });
        var areWeUsingScroll = false;
        //todo: areWeUsingScroll

        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });

        // $('.datepicker').datetimepicker({
        // theme:'light',
        // format:'Y-m-d',
        // formatDate:'Y-m-d',
        // timepicker:false
        // });

        var base_url = '<?php echo base_url(); ?>';

        setTimeout(function () {
            $('#post_date_range').daterangepicker({
                locale: daterange_locale,
                ranges: {
                    '<?php echo $this->lang->line("Last 30 Days");?>': [moment().subtract(29, 'days'), moment()],
                    '<?php echo $this->lang->line("This Month");?>': [moment().startOf('month'), moment().endOf('month')],
                    '<?php echo $this->lang->line("Last Month");?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            }, function (start, end) {
                $('#post_date_range_val').val(start.format('YYYY-M-D') + '|' + end.format('YYYY-M-D')).change();
            });
        }, 2000);

        // datatable section started
        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: false,
            order: [[1, "desc"]],
            pageLength: 10,
            ajax:
                {
                    "url": base_url + 'comment_reply_enhancers/bulk_tag_campaign_list_data',
                    "type": 'POST',
                    data: function (d) {
                        d.page_id = $('#page_id').val();
                        d.searching = $('#searching').val();
                        d.post_date_range = $('#post_date_range_val').val();
                    }
                },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1],
                    visible: false
                },
                {
                    targets: [5, 6, 7, 8, 9, 10],
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 2, 5, 6, 7, 8],
                    sortable: false
                },
                {
                    targets: [5, 6, 7, 8],
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
                        data = data.replaceAll('161px', '308px');
                        data = data.replaceAll("data-toggle='tooltip'", " data-html='true' data-toggle='tooltip'");

                        return data;
                    }
                },
            ],
            fnInitComplete: function () { // when initialization is completed then apply scroll plugin
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

        $(document).on('change', '#page_id', function (event) {
            event.preventDefault();
            table.draw();
        });

        $(document).on('change', '#post_date_range_val', function (event) {
            event.preventDefault();
            table.draw();
        });

        $(document).on('click', '#search_submit', function (event) {
            event.preventDefault();
            table.draw();
        });
        // End of datatable section

        // report table started
        var table1 = '';
        var perscroll1;
        $(document).on('click', '.show_report', function (e) {
            e.preventDefault();

            var table_id = $(this).attr('table_id');

            var decrease_pageName = "";
            var page_name = $(this).attr("page_name");
            if (page_name.length > 20) decrease_pageName = page_name.substr(0, 15) + " ...";
            else decrease_pageName = page_name;

            var decrease_cam = "";
            var campaign_name = $(this).attr("campaign_name");
            if (campaign_name.length > 20) decrease_cam = campaign_name.substr(0, 15) + " ...";
            else decrease_cam = campaign_name;

            var page_id = $(this).attr("page_id");
            var post_id = $(this).attr("post_id");
            var onlypostid = post_id.split("_");
            var errorMsg = $(this).attr("errorMsg");
            var tagContent = $(this).attr("tagContent");

            $("#errorMsg").css("display", "none");

            $("#put_row_id").val(table_id);
            $("#pageName").prepend(page_name);
            $("#pageName").attr("href", "https://facebook.com/" + page_id);
            $("#campaign_name").html(decrease_cam);
            $("#postID").attr("href", "https://facebook.com/" + post_id);
            $("#postID").html(onlypostid[1]);
            $("#tagContent").html(tagContent);

            if (errorMsg != '') {
                $("#errorMsg").css("display", "block");
                $("#errorMsg").prepend("<i class='bx bx-alarm-exclamation'></i> " + errorMsg);
            }

            $("#view_report_modal").modal();


            setTimeout(function () {

                if (table1 == '') {
                    table1 = $("#mytable1").DataTable({
                        serverSide: true,
                        processing: true,
                        bFilter: false,
                        order: [[3, "desc"]],
                        pageLength: 10,
                        ajax: {
                            url: base_url + 'comment_reply_enhancers/bulk_tag_campaign_report',
                            type: 'POST',
                            data: function (d) {
                                d.table_id = $("#put_row_id").val();
                                d.searching1 = $("#searching1").val();
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
                                targets: [0, 1, 2],
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
                        }
                    });
                } else table1.draw();

            }, 1000);


        });

        $(document).on('keyup', '#searching1', function (event) {
            event.preventDefault();
            table1.draw();
        });


        $('#view_report_modal').on('hidden.bs.modal', function () {
            $("#put_row_id").val('');
            $("#pageName").attr("href", "");
            $("#campaign_name").attr("href", "");
            $("#pageName").text("");
            $("#campaign_name").html('');
            $("#errorMsg").html("");
            $("#tagContent").html("");
            $("#searching1").val("");
            table.draw();
        });
        // report table end


        var Doyouwanttodeletethisrecordfromdatabase = "<?php echo $Doyouwanttodeletethisrecordfromdatabase; ?>";
        $(document).on('click', '.delete_campaign', function (e) {
            e.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: Doyouwanttodeletethisrecordfromdatabase,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var id = $(this).attr("data-id");

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo base_url('comment_reply_enhancers/delete_bulk_tag_campaign')?>",
                            data: {id: id},
                            success: function (response) {
                                iziToast.success({
                                    title: '',
                                    message: '<?php echo $this->lang->line("Campaign has been deleted successfully."); ?>',
                                    position: 'bottomRight'
                                });
                                table.draw();
                            }
                        });
                    }
                });

        });

        // only pending campaign
        $(document).on('click', '.not_see_report', function (event) {
            event.preventDefault();
            swal.fire("", "<?php echo $this->lang->line('Sorry, Only parent campaign has shown report.'); ?>", "error");
        });

        $(document).on('click', '.not_published', function (event) {
            event.preventDefault();
            swal.fire("", "<?php echo $this->lang->line('Sorry, this post is not published yet.'); ?>", 'error');
        });

        $(document).on('click', '.not_editable', function (event) {
            event.preventDefault();
            swal.fire("", "<?php echo $this->lang->line('Sorry, Only Pending Campaigns Are Editable.'); ?>", 'error');
        });

        $(document).on('click', '.not_delete_campaign', function (event) {
            event.preventDefault();
            swal.fire("", "<?php echo $this->lang->line('Sorry, Processing Campaign Can not be deleted.'); ?>", 'error');
        });

        $(document).on('click', '.not_embed_code', function (event) {
            event.preventDefault();
            swal.fire("", "<?php echo $this->lang->line('Sorry, Embed code is only available for published video posts.'); ?>", 'error');
        });

    });
</script>