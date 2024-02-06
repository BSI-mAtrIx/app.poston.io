<?php
$somethingwentwrong = $this->lang->line("something went wrong, please try again.");
$doyoureallywanttodeletethisbot = $this->lang->line("Do you really want to delete this settings?");
$doyoureallywanttodisablethisbot = $this->lang->line("Do you really want to disable this settings?");
$doyoureallywanttoenablethisbot = $this->lang->line("Do you really want to enable this settings? This operation may take few time.");
$areyousure = $this->lang->line("are you sure");
?>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script type="text/javascript">
    $("document").ready(function () {
        var user_id = "<?php echo $this->session->userdata('user_id'); ?>";
        var base_url = "<?php echo site_url(); ?>";
        var areyousure = "<?php echo $areyousure;?>";
        var is_broadcaster_exist = "<?php echo $is_broadcaster_exist;?>";
        var is_ultrapost_exist = "<?php echo $is_ultrapost_exist;?>";
        var doyoureallywanttodeletethisbot = "<?php echo $doyoureallywanttodeletethisbot;?>";
        var doyoureallywanttodisablethisbot = "<?php echo $doyoureallywanttodisablethisbot;?>";
        var doyoureallywanttoenablethisbot = "<?php echo $doyoureallywanttoenablethisbot;?>";
        var somethingwentwrong = "<?php echo $somethingwentwrong;?>";

        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });

        var table = $("#mytable").DataTable({
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [5],
                    sortable: false
                }
            ]
        });

        (function ($, undefined) {
            $.fn.getCursorPosition = function () {
                var el = $(this).get(0);
                var pos = 0;
                if ('selectionStart' in el) {
                    pos = el.selectionStart;
                } else if ('selection' in document) {
                    el.focus();
                    var Sel = document.selection.createRange();
                    var SelLength = document.selection.createRange().text.length;
                    Sel.moveStart('character', -el.value.length);
                    pos = Sel.text.length - SelLength;
                }
                return pos;
            }
        })(jQuery);

        $(document).on('click', '#title_variable', function (event) {
            // event.preventDefault();

            let textAreaTxt = $(".emojionearea-editor").html();
            var lastIndex = textAreaTxt.lastIndexOf("<br>");
            var lastTag = textAreaTxt.substr(textAreaTxt.length - 4);
            lastTag = lastTag.trim(lastTag);

            if (lastTag == "<br>") {
                textAreaTxt = textAreaTxt.substring(0, lastIndex);
            }

            var txtToAdd = " #TITLE# ";
            var new_text = textAreaTxt + txtToAdd;
            $(".emojionearea-editor").html(new_text);
            $(".emojionearea-editor").click();


        });


        $(document).on('click', '.campaign_settings', function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            $.ajax({
                type: 'POST',
                url: base_url + "auto_feed_post/campaign_settings",
                data: {id: id},
                dataType: 'JSON',
                success: function (response) {
                    if (response.status == '0') $("#settings_modal .modal-footer").hide();
                    else $("#settings_modal .modal-footer").show();
                    $("#feed_setting_container").html(response.html);
                    $("#put_feed_name").html(" : " + response.feed_name);
                    $("#settings_modal").modal();
                }
            });

        });

        $(document).on('click', '#save_settings', function (e) {
            e.preventDefault();

            var post_to_pages = $("#post_to_pages").val();
            var post_to_groups = $("#post_to_groups").val();
            var broadcast_pages = '';

            if (is_broadcaster_exist == '1')
                broadcast_pages = $("#page").val();

            if (post_to_pages == '' && broadcast_pages == '') {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select pages to publish the feed');?>", 'error');
                return;
            }

            if (post_to_pages != '') {
                var posting_start_time = $("#posting_start_time").val();
                var posting_end_time = $("#posting_end_time").val();
                var rep1 = parseFloat(posting_start_time.replace(":", "."));
                var rep2 = parseFloat(posting_end_time.replace(":", "."));
                var rep_diff = rep2 - rep1;

                if (posting_start_time == '' || posting_end_time == '') {
                    swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select post between times');?>", 'error');
                    return false;
                }

                if (rep1 >= rep2 || rep_diff < 1.0) {
                    swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Post between start time must be less than end time and need to have minimum one hour time span');?>", 'error');
                    return false;
                }
            }

            if (broadcast_pages != '') {
                var broadcast_start_time = $("#broadcast_start_time").val();
                var broadcast_end_time = $("#broadcast_end_time").val();
                var rep1 = parseFloat(broadcast_start_time.replace(":", "."));
                var rep2 = parseFloat(broadcast_end_time.replace(":", "."));
                var rep_diff = rep2 - rep1;

                if (broadcast_start_time == '' || broadcast_end_time == '') {
                    swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select broadcast between times');?>", 'error');
                    return false;
                }

                if (rep1 >= rep2 || rep_diff < 1.0) {
                    swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Broadcast between start time must be less than end time and need to have minimum one hour time span');?>", 'error');
                    return false;
                }
            }

            // var loading = '<img src="'+base_url+'assets/pre-loader/custom_lg.gif" class="center-block">';
            // $("#submit_status").show();
            var queryString = new FormData($("#campaign_settings_form")[0]);
            $("#save_settings").addClass("btn-progress");
            // var loading = '<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center" style="font-size:40px"></i></div>';
            // $("#submit_response").attr('class','').html(loading);
            var id = $(this).attr('data-id');
            $.ajax({
                type: 'POST',
                url: base_url + "auto_feed_post/create_campaign",
                dataType: 'JSON',
                data: queryString,
                contentType: false,
                processData: false,
                success: function (response) {

                    if (response.status == '1')
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success');
                    else swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');

                    // $("#submit_response").html('');
                    $("#save_settings").removeClass("btn-progress");
                    // $("#submit_status").hide();
                }
            });

        });

        $(document).on('click', '.enable_settings', function (e) {
            e.preventDefault();
            $(this).addClass('disabled');
            var id = $(this).attr('data-id');
            var media_type = 'youtube';

            swal.fire({
                title: '<?php echo $this->lang->line("Enable Campaign"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to enable this campaign?"); ?>',
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
                            url: base_url + "auto_feed_post/enable_settings",
                            data: {id, media_type},
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == '0') {
                                    $("#enable" + id).removeClass('disabled');
                                    iziToast.error({
                                        title: '<?php echo $this->lang->line("Error"); ?>',
                                        message: response.message,
                                        position: 'bottomRight'
                                    });
                                } else {
                                    iziToast.success({
                                        title: '<?php echo $this->lang->line("Success"); ?>',
                                        message: '<?php echo $this->lang->line("Campaign has been enabled successfully."); ?>',
                                        position: 'bottomRight'
                                    });
                                    setTimeout(function () {
                                        location.reload();
                                    }, 1000);

                                }
                            }
                        });
                    }
                });

        });

        $(document).on('click', '.disable_settings', function (e) {
            e.preventDefault();

            var id = $(this).attr('data-id');

            swal.fire({
                title: '<?php echo $this->lang->line("Disable Campaign"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to disable this campaign?"); ?>',
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
                            url: base_url + "auto_feed_post/disable_settings",
                            data: {id: id},
                            success: function (response) {
                                iziToast.success({
                                    title: '<?php echo $this->lang->line("Success"); ?>',
                                    message: '<?php echo $this->lang->line("Campaign has been disabled successfully."); ?>',
                                    position: 'bottomRight'
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                            }
                        });
                    }
                });

        });

        $(document).on('click', '.force_process', function (e) {
            e.preventDefault();

            var id = $(this).attr('data-id');

            swal.fire({
                title: '<?php echo $this->lang->line("Delete Campaign"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to force process this campaign? This can be helpful if your Youtube channel video posting tools have stopped for some unknown reasons and not responding."); ?>',
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
                            url: base_url + "auto_feed_post/force_process",
                            data: {id: id},
                            success: function (response) {
                                iziToast.success({
                                    title: '<?php echo $this->lang->line("Success"); ?>',
                                    message: '<?php echo $this->lang->line("Campaign has been processed by force successfully."); ?>',
                                    position: 'bottomRight'
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                            }
                        });
                    }
                });

        });

        $(document).on('click', '.delete_settings', function (e) {
            e.preventDefault();

            var id = $(this).attr('data-id');

            swal.fire({
                title: '<?php echo $this->lang->line("Delete Campaign"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to delete this campaign?"); ?>',
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
                            url: base_url + "auto_feed_post/delete_settings",
                            data: {id: id},
                            success: function (response) {
                                iziToast.success({
                                    title: '<?php echo $this->lang->line("Success"); ?>',
                                    message: '<?php echo $this->lang->line("Campaign has been deleted successfully."); ?>',
                                    position: 'bottomRight'
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                            }
                        });
                    }
                });

        });

        $(document).on('click', '#add_feed_submit', function () {

            var feed_type = $("input[name='feed_type']:checked").val();
            var feed_name = $("#feed_name").val();
            var youtube_channel_id = $("#youtube_channel_id").val();

            if (feed_type == '') {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select feed type');?>", 'error');
                return;
            }
            if (feed_name == '') {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select feed type name');?>", 'error');
                return;
            }
            if (youtube_channel_id == '') {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Youtube channel id can not be empty');?>", 'error');
                return;
            }
            $("#add_feed_submit").addClass('btn-progress');
            // $("#loader").removeClass('hidden');
            var queryString = new FormData($("#add_feed_form")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "auto_feed_post/add_feed_action",
                data: queryString,
                dataType: 'JSON',
                // async: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status == '1') {
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success');
                    } else {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }
                    // $("#loader").addClass('hidden');
                    $("#add_feed_submit").removeClass('btn-progress');
                }

            });
        });

        $('#add_feed_modal').on('hidden.bs.modal', function () {
            location.reload();
        });
        $('#settings_modal').on('hidden.bs.modal', function () {
            location.reload();
        });


        $(document).on('click', '.error_log', function (e) {
            e.preventDefault();
            $("#error_loading").removeClass('hidden');
            $("#error_modal_container").html("");
            $("#error_modal").modal();
            var id = $(this).attr('data-id');
            $.ajax({
                type: 'POST',
                url: base_url + "auto_feed_post/error_log",
                data: {id: id},
                success: function (response) {
                    $("#error_modal_container").html(response);
                    $("#error_loading").addClass('hidden');
                }
            });
        });

        $(document).on('click', '.clear_log', function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            swal.fire({
                title: '<?php echo $this->lang->line("Clear Log"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to clear log?"); ?>',
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
                            url: base_url + "auto_feed_post/clear_log",
                            data: {id: id},
                            success: function (response) {
                                $("#error_modal").modal('toggle');
                                swal.fire('<?php echo $this->lang->line("Clear Log"); ?>', "<?php echo $this->lang->line('Log has been cleared successfully.');?>", 'success');
                            }
                        });
                    }
                });

        });
    });
</script>
