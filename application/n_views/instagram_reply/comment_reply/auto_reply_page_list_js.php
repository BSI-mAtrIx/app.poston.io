<?php include("application/n_views/instagram_reply/comment_reply/comment_reply_js.php"); ?>
<?php include("application/n_views/instagram_reply/comment_reply/full_mentions_campaign_modals.php"); ?>
<!-- start of auto comment javascript section -->
<?php include(FCPATH . 'application/n_views/comment_automation/autocomment_javascript_section.php'); ?>
<?php include(FCPATH . 'application/n_views/comment_automation/autocomment_modal_section.php'); ?>
<!-- end of auto comment javascript section -->

<script>
    $(document).ready(function () {
        $('body').addClass('menu-collapsed');
        $('.brand-logo').removeClass('d-none');
    });
</script>

<script type="text/javascript">
    $("document").ready(function () {
        var base_url = "<?php echo base_url(); ?>";

        $('.modal').on("hidden.bs.modal", function (e) {
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
            }
        });

        $(document).on('click', '.add_template', function (e) {
            e.preventDefault();
            var current_id = $(this).prev().prev().attr('id');
            var current_val = $(this).prev().prev().val();
            var page_id = get_page_id();
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $("#add_template_modal").attr("current_id", current_id);
            $("#add_template_modal").attr("current_val", current_val);
            $("#add_template_modal").modal();
        });

        $(document).on('click', '.ref_template', function (e) {
            e.preventDefault();
            var current_val = $(this).prev().prev().prev().val();
            var current_id = $(this).prev().prev().prev().attr('id');
            var page_id = get_page_id();
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "instagram_reply/get_private_reply_postbacks",
                data: {page_table_ids: page_id},
                dataType: 'JSON',
                success: function (response) {
                    $("#" + current_id).html(response.options).val(current_val);
                }
            });
        });

        $('#add_template_modal').on('hidden.bs.modal', function (e) {
            var current_id = $("#add_template_modal").attr("current_id");
            var current_val = $("#add_template_modal").attr("current_val");
            var page_id = get_page_id();
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "instagram_reply/get_private_reply_postbacks",
                data: {page_table_ids: page_id, is_from_add_button: '1'},
                dataType: 'JSON',
                success: function (response) {
                    $("#" + current_id).html(response.options);
                }
            });
        });

        // getting postback list and making iframe
        $('#add_template_modal').on('shown.bs.modal', function () {
            var page_id = get_page_id();
            var rand_time = "<?php echo time(); ?>";
            var media_type = "ig";
            var iframe_link = "<?php echo base_url('messenger_bot/create_new_template/1/');?>" + page_id + "/0/" + media_type + "?lev=" + rand_time;
            $(this).find('iframe').attr('src', iframe_link);
        });
        // getting postback list and making iframe

    });

    function get_page_id() {
        var page_id = $('#bot_list_select').val();
        return page_id;
    }
</script>

<!-- IG auto reply and comment report section starts here -->
<?php
$Edit = $this->lang->line("edit");
$Report = $this->lang->line("report");
$Delete = $this->lang->line("delete");
$PauseCampaign = $this->lang->line("pause campaign");
$StartCampaign = $this->lang->line("start campaign");
$Doyouwanttopausethiscampaign = $this->lang->line("do you want to pause this campaign?");
$Doyouwanttostarthiscampaign = $this->lang->line("do you want to start this campaign?");
$Doyouwanttodeletethisrecordfromdatabase = $this->lang->line("do you want to delete this record from database?");
?>
<script type="text/javascript">
    var table_campaign_report = '';
    var ig_reply_perscroll_campaign_report;
    var  ig_reply_table_campaign_report = '';
    $(document).on('click', '.ig_view_report', function (e) {
        e.preventDefault();

        var table_id = $(this).attr("table_id");
        var post_id = $(this).attr("post_id");
        var reply_type = $(this).attr("reply_type");
        $("#ig_replycampaign_report_modal").modal();

        $("#contents").html('<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center font_size_40px"></i></div');

        $.ajax({
            url: base_url + 'instagram_reply/get_content_info',
            type: 'post',
            data: {table_id: table_id, post_id: post_id, reply_type},
            success: function (response) {
                $("#contents").html(response);
            }
        })

        $("#ig_reply_campaign_report_post_id").val(post_id);
        $("#ig_reply_table_id").val(table_id);
        $("#ig_reply_reply_type").val(reply_type);

        setTimeout(function () {
            if (ig_reply_table_campaign_report == '') {
                ig_reply_table_campaign_report = $("#ig_mytable_campaign_report").DataTable({
                    serverSide: true,
                    processing: true,
                    bFilter: true,
                    order: [[1, "desc"]],
                    pageLength: 10,
                    ajax: {
                        url: base_url + 'instagram_reply/get_autoreply_report',
                        type: 'POST',
                        data: function (d) {
                            d.table_id = $("#table_id").val();
                            d.reply_type = $("#reply_type").val();
                            d.post_id = $("#campaign_report_post_id").val();
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
                            targets: [5, 6],
                            className: 'text-center'
                        },
                        {
                            targets: [0, 1, 2, 3, 4, 5, 6, 7],
                            sortable: false
                        }
                    ],
                    fnInitComplete: function () { // when initialization is completed then apply scroll plugin
                        if (areWeUsingScroll) {
                            if (ig_reply_perscroll_campaign_report) ig_reply_perscroll_campaign_report.destroy();
                            ig_reply_perscroll_campaign_report = new PerfectScrollbar('#ig_mytable_campaign_report_wrapper .dataTables_scrollBody');
                        }
                    },
                    scrollX: 'auto',
                    fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                        if (areWeUsingScroll) {
                            if (ig_reply_perscroll_campaign_report) ig_reply_perscroll_campaign_report.destroy();
                            ig_reply_perscroll_campaign_report = new PerfectScrollbar('#ig_mytable_campaign_report_wrapper .dataTables_scrollBody');
                        }
                    }
                });
            } else ig_reply_table_campaign_report.draw();
        }, 1000);
    });

    $('#ig_replycampaign_report_modal').on('hidden.bs.modal', function () {
        ig_reply_table_campaign_report.draw();
    });


    $(document).on('click', '.ig_pause_campaign_info', function (e) {
        e.preventDefault();
        var to_do = $(this).attr('to_do');
        var display_to_do = 'start';
        if (to_do == 'pause') display_to_do = to_do;

        swal.fire({
            title: '<?php echo $this->lang->line("Are you sure?"); ?>',
            text: '<?php echo $this->lang->line("Do you really want to"); ?> ' + display_to_do + ' <?php echo $this->lang->line("this campaign?"); ?>',
            icon: 'warning',
            buttons: true,
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    var table_id = $(this).attr('table_id');

                    $.ajax({
                        context: this,
                        type: 'POST',
                        url: "<?php echo base_url('instagram_reply/pause_campaign_info')?>",
                        data: {table_id: table_id, to_do: to_do},
                        success: function (response) {
                            var message = '<?php echo $this->lang->line("Camapaign status has been updated successfully."); ?>';
                            if (response == "1") {
                                swal.fire('<?php echo $this->lang->line("Success"); ?>', message, 'success').then((value) => {
                                    $(".page_list_item.active").click();
                                });
                            } else {
                                swal.fire('<?php echo $this->lang->line("Error"); ?>', '<?php echo $this->lang->line("Something went wrong, please try once again. "); ?>', 'error');
                            }
                        }
                    });
                }
            });

    });


    $(document).on('click', '.ig_delete_post_report', function (e) {
        e.preventDefault();
        swal.fire({
            title: '<?php echo $this->lang->line("Are you sure?"); ?>',
            text: '<?php echo $this->lang->line("Do you really want to delete this Campaign? If you delete this all of your saved data and post report will be deleted."); ?>',
            icon: 'warning',
            buttons: true,
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    var table_id = $(this).attr('table_id');
                    var page_info_table_id = $(this).attr('page_info_table_id');
                    var autoreply_type = $(this).attr('autoreply_type');

                    $.ajax({
                        context: this,
                        type: 'POST',
                        url: "<?php echo base_url('instagram_reply/delete_post_report')?>",
                        data: {
                            table_id: table_id,
                            page_info_table_id: page_info_table_id,
                            autoreply_type: autoreply_type
                        },
                        success: function (response) {

                            if (response == "1") {
                                swal.fire('<?php echo $this->lang->line("Success"); ?>', '<?php echo $this->lang->line("Post Auto reply and reports has been successfully deleted."); ?>', 'success').then((value) => {
                                    $(".page_list_item.active").click();
                                });
                            } else {
                                swal.fire('<?php echo $this->lang->line("Error"); ?>', '<?php echo $this->lang->line("Something went wrong, please try once again. "); ?>', 'error');
                            }
                        }
                    });
                }
            });
    });


    var Doyouwanttopausethiscampaign = "<?php echo $Doyouwanttopausethiscampaign; ?>";
    var Doyouwanttostarthiscampaign = "<?php echo $Doyouwanttostarthiscampaign; ?>";
    var Doyouwanttodeletethisrecordfromdatabase = "<?php echo $Doyouwanttodeletethisrecordfromdatabase; ?>";
    var Edit = "<?php echo $Edit; ?>";
    var Report = "<?php echo $Report; ?>";
    var Delete = "<?php echo $Delete; ?>";
    var PauseCampaign = "<?php echo $PauseCampaign; ?>";
    var StartCampaign = "<?php echo $StartCampaign; ?>";

    var autocomment_table1 = '';
    var autocomment_perscroll1;
    $(document).on('click', '.autocomment_view_report', function (e) {
        e.preventDefault();

        var table_id = $(this).attr('table_id');
        if (table_id != '') {
            $("#autocomment_put_row_id").val(table_id);
        }

        $("#autocomment_view_report_modal").modal();

        if (autocomment_table1 == '') {
            setTimeout(function () {
                autocomment_table1 = $("#autocomment_mytable1").DataTable({
                    serverSide: true,
                    processing: true,
                    bFilter: false,
                    order: [[5, "desc"]],
                    pageLength: 10,
                    ajax: {
                        url: base_url + 'comment_automation/ajax_get_autocomment_reply_info',
                        type: 'POST',
                        data: function (d) {
                            d.table_id = $("#autocomment_put_row_id").val();
                            d.searching = $("#autocomment_searching").val();
                        }
                    },
                    language:
                        {
                            url: base_url + "n_assets/plugins/datatables_language/" + selected_language + ".json"
                        },
                    dom: '<"top"f>rt<"bottom"lip><"clear">',
                    columnDefs: [
                        {
                            targets: '',
                            className: 'text-center'
                        },
                        {
                            targets: '',
                            sortable: false
                        }
                    ],
                    fnInitComplete: function () { // when initialization is completed then apply scroll plugin
                        if (areWeUsingScroll) {
                            if (autocomment_perscroll1) autocomment_perscroll1.destroy();
                            autocomment_perscroll1 = new PerfectScrollbar('#autocomment_mytable1_wrapper .dataTables_scrollBody');
                        }
                    },
                    scrollX: 'auto',
                    fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                        if (areWeUsingScroll) {
                            if (autocomment_perscroll1) autocomment_perscroll1.destroy();
                            autocomment_perscroll1 = new PerfectScrollbar('#autocomment_mytable1_wrapper .dataTables_scrollBody');
                        }
                    }
                });
            }, 500);
        } else setTimeout(function () {
            autocomment_table1.draw();
        }, 500);
    });

    $(document).on('keyup', '#autocomment_searching', function (event) {
        event.preventDefault();
        autocomment_table1.draw();
    });

    $('#autocomment_view_report_modal').on('hidden.bs.modal', function () {
        $("#autocomment_put_row_id").val('');
        $("#autocomment_searching").val("");
        autocomment_table1.draw();
    });

    $(document).on('click', '.autocomment_pause_campaign_info', function (e) {
        e.preventDefault();
        swal.fire({
            title: '',
            text: Doyouwanttopausethiscampaign,
            icon: 'warning',
            buttons: true,
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    var table_id = $(this).attr('table_id');

                    $.ajax({
                        context: this,
                        type: 'POST',
                        url: base_url + "comment_automation/ajax_autocomment_pause",
                        data: {table_id: table_id},
                        success: function (response) {
                            iziToast.success({
                                title: '',
                                message: global_lang_campaign_paused_successfully,
                                position: 'bottomRight'
                            });
                            $(".page_list_item.active").click();
                        }
                    });
                }
            });

    });

    $(document).on('click', '.autocomment_play_campaign_info', function (e) {
        e.preventDefault();
        swal.fire({
            title: '',
            text: Doyouwanttostarthiscampaign,
            icon: 'warning',
            buttons: true,
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    var table_id = $(this).attr('table_id');

                    $.ajax({
                        context: this,
                        type: 'POST',
                        url: base_url + "comment_automation/ajax_autocomment_play",
                        data: {table_id: table_id},
                        success: function (response) {
                            iziToast.success({
                                title: '',
                                message: global_lang_campaign_started_successfully,
                                position: 'bottomRight'
                            });
                            $(".page_list_item.active").click();
                        }
                    });
                }
            });

    });


    $(document).on('click', '.autocomment_delete_report', function (e) {
        e.preventDefault();
        swal.fire({
            title: '<?php echo $this->lang->line("Are you sure?"); ?>',
            text: Doyouwanttodeletethisrecordfromdatabase,
            icon: 'warning',
            buttons: true,
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    var table_id = $(this).attr('table_id');

                    $.ajax({
                        context: this,
                        type: 'POST',
                        url: base_url + "comment_automation/ajax_autocomment_delete",
                        data: {table_id: table_id},
                        success: function (response) {
                            iziToast.success({
                                title: '',
                                message: global_lang_campaign_deleted_successfully,
                                position: 'bottomRight'
                            });
                            $(".page_list_item.active").click();
                        }
                    });
                }
            });

    });

</script>


<!-- postback add/refresh button section -->
<div class="modal fade" id="add_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i
                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add Template'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" width="100%"></iframe>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" type="button" class="btn btn-dark"><i
                            class="bx bx-refresh"></i> <?php echo $this->lang->line("Close & Refresh List"); ?></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="ig_replycampaign_report_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bx bx-show"></i> <?php echo $this->lang->line("Campaign Report") ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="sent_report_body">
                <div id="contents"></div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive2 data-card">
                            <input type="hidden" value="" id="ig_reply_campaign_report_post_id">
                            <input type="hidden" value="" id="ig_reply_table_id">
                            <input type="hidden" value="" id="ig_reply_reply_type">
                            <table class="table table-bordered" id="ig_mytable_campaign_report">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('#'); ?></th>
                                    <th><?php echo $this->lang->line('id'); ?></th>
                                    <th><?php echo $this->lang->line("Name"); ?></th>
                                    <th><?php echo $this->lang->line("comment"); ?></th>
                                    <th><?php echo $this->lang->line("comment reply message"); ?></th>
                                    <th><?php echo $this->lang->line('reply time'); ?></th>
                                    <th><?php echo $this->lang->line('comment reply status'); ?></th>
                                    <?php
                                    $reply_type = 'post';
                                    if ($instagram_bot_exist && $reply_type != "mention") {
                                        echo "<th>" . $this->lang->line('Private reply status') . "</th>";
                                    }
                                    ?>
                                    <th><?php echo $this->lang->line('Error Message'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="autocomment_view_report_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-mega">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i
                            class="bx bx-comment"></i> <?php echo $this->lang->line("Auto Comment Report"); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body data-card">
                <div class="row">
                    <div class="col-12 col-md-9">
                        <input type="text" id="autocomment_searching" name="autocomment_searching"
                               class="form-control width_200px"
                               placeholder="<?php echo $this->lang->line("Search..."); ?>">
                    </div>
                    <div class="col-12">
                        <div class="table-responsive2">
                            <input type="hidden" id="autocomment_put_row_id">
                            <table class="table table-bordered" id="autocomment_mytable1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo $this->lang->line("Comment ID"); ?></th>
                                    <th><?php echo $this->lang->line("Comment"); ?></th>
                                    <th><?php echo $this->lang->line("comment time"); ?></th>
                                    <th><?php echo $this->lang->line("Schedule Type"); ?></th>
                                    <th><?php echo $this->lang->line("Comment Status"); ?></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- IG auto reply and comment report section ends here -->

<?php
if(file_exists(APPPATH.'n_sgp/tools/spintax.php')){
    include(APPPATH.'n_sgp/tools/spintax.php');
}