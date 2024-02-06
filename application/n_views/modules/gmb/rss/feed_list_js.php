<script type="text/javascript">
    $("document").ready(function () {
        var user_id = "<?php echo $this->session->userdata('user_id'); ?>";
        var base_url = "<?php echo site_url(); ?>";

        var table = $("#mytable").DataTable({
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [3, 5],
                    sortable: false
                },
                {
                    targets: [3],
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

            $('.xit-spinner').show();
            var id = $(this).attr('data-id');

            $.ajax({
                type: 'POST',
                url: base_url + "gmb/rss_campaign_settings",
                data: {id},
                dataType: 'JSON',
                success: function (response) {
                    if (response.status == '0') {
                        $("#settings_modal .modal-footer").hide();
                    } else {
                        $("#settings_modal .modal-footer").show();
                    }

                    $("#feed_setting_container").html(response.html);
                    $("#put_feed_name").html(" : " + response.feed_name);

                    $("#submit_status").hide();
                    $('.xit-spinner').hide();
                    $("#settings_modal").modal();

                }
            });
        });

        $(document).on('click', '#save_settings', function (e) {
            e.preventDefault();

            var location_name = $("#location_name").val(),
                posting_start_time = $("#posting_start_time").val(),
                posting_end_time = $("#posting_end_time").val();

            if (!Array.isArray(location_name) || !location_name.length) {
                swal.fire(
                    '<?php echo $this->lang->line("Error"); ?>',
                    '<?php echo $this->lang->line('Please select location name(s)');?>',
                    'error'
                );

                return;
            }


            if (location_name.length) {
                if (posting_start_time == '' || posting_end_time == '') {
                    swal.fire(
                        '<?php echo $this->lang->line("Error"); ?>',
                        '<?php echo $this->lang->line('Please select post between times'); ?>',
                        'error'
                    );

                    return;
                }

                var rep1 = parseFloat(posting_start_time.replace(":", "."));
                var rep2 = parseFloat(posting_end_time.replace(":", "."));
                var rep_diff = rep2 - rep1;

                if (rep1 >= rep2 || rep_diff < 1.0) {
                    swal.fire(
                        '<?php echo $this->lang->line("Error"); ?>',
                        '<?php echo $this->lang->line("Post time was invalid. (The time difference should be 1 hour at least)");?>',
                        'error'
                    );

                    return;
                }
            }

            $("#save_settings").addClass("btn-progress");
            var queryString = new FormData($("#campaign_settings_form")[0]);

            $.ajax({
                type: 'POST',
                url: base_url + "gmb/create_rss_campaign",
                dataType: 'JSON',
                data: queryString,
                contentType: false,
                processData: false,
                success: function (response) {
                    $("#save_settings").removeClass("btn-progress");

                    if ("0" === response.status) {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                        return;
                    }

                    if (response.status == '1') {
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success');
                    }

                    $("#settings_modal").modal('hide');
                    $('.modal-backdrop').hide();
                }
            });
        });

        $(document).on('click', '.enable_settings', function (e) {
            e.preventDefault();

            $(this).addClass('disabled');
            var id = $(this).attr('data-id');

            swal.fire({
                title: '<?php echo $this->lang->line("Delete Campaign"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to enable this campaign?"); ?>',
                icon: 'warning',
                buttons: true,
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: base_url + "gmb/enable_rss_settings",
                        data: {id: id},
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
                title: '<?php echo $this->lang->line("Delete Campaign"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to disable this campaign?"); ?>',
                icon: 'warning',
                buttons: true,
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: base_url + "gmb/disable_rss_settings",
                        data: {id},
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

        $(document).on('click', '.delete_settings', function (e) {
            e.preventDefault();

            var id = $(this).attr('data-id');

            swal.fire({
                title: '<?php echo $this->lang->line("Delete Campaign"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to delete this campaign?"); ?>',
                icon: 'warning',
                buttons: true,
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: base_url + "gmb/delete_rss_settings",
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

            var feed_name = $("#feed_name").val();
            var feed_url = $("#feed_url").val();

            if (feed_name == '') {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select feed type name');?>", 'error');
                return;
            }

            if (feed_url == '') {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Feed URL can not be empty');?>", 'error');
                return;
            }

            $("#add_feed_submit").addClass('btn-progress');

            var queryString = new FormData($("#add_feed_form")[0]);

            $.ajax({
                type: 'POST',
                url: base_url + "gmb/add_feed_action",
                data: queryString,
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (response) {
                    $("#add_feed_submit").removeClass('btn-progress');

                    if (response.status == '1') {
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success');
                    } else {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }

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
            $(".xit-spinner").show();
            $("#error_modal_container").html("");
            $("#error_modal").modal();
            var id = $(this).attr('data-id');
            $.ajax({
                type: 'POST',
                url: base_url + "gmb/show_rss_error_log",
                data: {id: id},
                success: function (response) {
                    $("#error_modal_container").html(response);
                    $(".xit-spinner").hide();
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
                buttons: true,
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: base_url + "gmb/clear_rss_error_log",
                        data: {id: id},
                        success: function (response) {
                            $("#error_modal").modal('toggle');
                            swal.fire('<?php echo $this->lang->line("Clear Log"); ?>', "<?php echo $this->lang->line('Log has been cleared successfully.');?>", 'success');
                        }
                    });
                }
            });
        });

        // Upload status
        $(document).on('change', '#media_status', function (e) {
            e.preventDefault();

            if (true === $('#media_status').prop('checked')) {
                $('#upload-wrapper').removeClass('d-none');
            } else {
                $('#upload-wrapper').addClass('d-none');
            }
        });
    });
</script>