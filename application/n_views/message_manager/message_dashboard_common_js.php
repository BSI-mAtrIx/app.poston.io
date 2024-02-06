<script>
    var iScrollPos = 0;
    var iScrollBLock = false;

    function search_in_subscriber_ul(obj, ul_id) {  // obj = 'this' of jquery, ul_id = id of the ul
        var filter = $(obj).val().toUpperCase().trim();
        var count_li = 0;
        $('#' + ul_id + ' li').each(function () {
            var content = $(this).text().trim();

            if (content.toUpperCase().indexOf(filter) > -1) {
                $(this).css('display', '');
                count_li++;
            } else $(this).css('display', 'none');
        });

        if (filter.length >= 3 && count_li == 0) {
            var page_table_id = $("#refresh_data").attr('page_table_id');
            $.ajax({
                url: base_url + 'message_manager/search_subscriber_database',
                type: 'POST',
                data: {page_table_id, social_media, filter},
                success: function (response) {
                    $("#put_content").append(response);
                    $("#put_content img").on("error", function () {
                        $(this).attr('src', base_url + 'assets/img/avatar/avatar-1.png');
                    });
                }
            });
        }

    }

    var is_webview_exist = "<?php echo $webview_access; ?>"
    var base_url = "<?php echo base_url(); ?>";
    var loading = '<br><div class="col-12 text-center waiting previewLoader"><i class="bx bx-loader bx-spin blue text-center" style="font-size: 60px; margin-top: 100px; margin-bottom: 100px;"></i></div>';
    var refresh_interval = 10000;
    var auto_refresh_con = '';
    chatContainer = $(".chat-container");



        function openTab(url) {
            var win = window.open(url, '_blank');
            win.focus();
        }

    function img_video_error(selector){
        $(selector).remove();
    }

    $("#postback_reply_button").tooltip();

    function get_subscriber_action_content2(id, subscribe_id, page_id) {
        $("#subscriber_action").html(loading);
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>message_manager_n/subscriber_actions_modal",
            data: {id: id, page_id: page_id, subscribe_id: subscribe_id, call_from_conversation: '1'},
            success: function (response) {
                data = response;
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

                $("#subscriber_action").html(data);
            }
        });
    }

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $("document").ready(function () {


        // setTimeout(function () {
        //     auto_refresh_con = setInterval(function () {
        //         $('.open_conversation.active').click();
        //     }, refresh_interval);
        //     $(document).on('change', '#refresh_interval', function (e) {
        //         refresh_interval = $("#refresh_interval").val();
        //         clearInterval(auto_refresh_con);
        //         auto_refresh_con = setInterval(function () {
        //             $('.open_conversation.active').click();
        //         }, refresh_interval);
        //     });
        //     // setInterval(function(){$('#refresh_data').click();},180015);
        //    // ajax_call(".open_conversation:first");
        // }, 500);

        $(document).on('change', '#page_id', function (event) {
            event.preventDefault();
            var pageid = $(this).val();
            if (pageid == '') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Please select a Facebook page / Instagram account"); ?>', 'warning');
                return false;
            }
            $(".search_list").val('');
            $('#refresh_data').attr('page_table_id', pageid);
            $.ajax({
                url: base_url + 'home/switch_to_page',
                type: 'POST',
                data: {page_id: pageid},
                success: function () {
                }
            })
            ajax_call(".open_conversation:first");

            $.ajax({
                url: base_url + 'message_manager/get_dropdown_postback/' + pageid + '/' + social_media + '/0',
                type: 'POST',
                success: function (response) {
                    $("#postbackModalBody").html(response);
                }
            })


        });


        $(document).on('click', '.open_conversation_contacts', function () {


            $("#chat-content-section").html('');

            var already_loaded = false;
            if ($(this).hasClass('active')) already_loaded = true;
            $('.media').removeClass('active');
            $(this).addClass('active');
            var from_user_id = $(this).attr('from_user_id');
            var from_user = $(this).attr('from_user');
            var subscribe_id = $(this).attr('from_user_id');
            var thread_id = $(this).attr('thread_id');
            var page_table_id = $(this).attr('page_table_id');
            var last_message_id = $(".card-body .chat-item:last .chat-details").attr('message_id');
            if (!already_loaded) last_message_id = '';
            $("#final_reply_button").attr('thread_id', thread_id);
            $("#final_reply_button").attr('page_table_id', page_table_id);
            $("#final_reply_button").attr('from_user_id', from_user_id);
            // $("#conversation_modal_body").html(loading);

            var page_table_id_social_media = $(this).attr('page_table_id') + "-" + social_media;
            if (!already_loaded) get_subscriber_action_content2(0, from_user_id, page_table_id_social_media);
        });

        $(".chat-container").scroll(function () {
            var iCurScrollPos = $(this).scrollTop();
            if (iCurScrollPos != iScrollPos) {
                iScrollBLock = true;
                $('#infoscrollbarblock').show();
            }else{
                iScrollBLock = false;
            }
            iScrollPos = iCurScrollPos;
        });


        $(document).on('click', '#save_changes', function () {

            $("#n_subscriber_actions_modal").modal('hide');

        });

        function get_subscriber_flowdata(id, subscribe_id, page_id) {
            $(".flowanswers_div").html('<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center"></i></div>');

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>subscriber_manager/get_subscriber_inputflow_data",
                data: {id: id, page_id: page_id, subscribe_id: subscribe_id},
                success: function (response) {
                    $(".flowanswers_div").html(response);
                }
            });
        }

        var table2 = '';

        $(document).on('change', '#search_status', function (e) {
            table2.draw();
        });

        $(document).on('change', '#search_date_range_val', function (e) {
            e.preventDefault();
            table2.draw();
        });

        $(document).on('keypress', '#search_value2', function (e) {
            if (e.which == 13) $("#search_action").click();
        });

        $(document).on('click', '#search_action', function (event) {
            event.preventDefault();
            table2.draw();
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var id = $(this).attr('id');
            if (id == 'purchase-tab') setTimeout(function () {
                get_purchase_data();
            }, 1000);
        });

        function get_purchase_data() {
            var perscroll2;
            if (table2 == '') {
                table2 = $("#mytable2").DataTable({
                    serverSide: true,
                    processing: true,
                    bFilter: false,
                    order: [[10, "desc"]],
                    pageLength: 10,
                    ajax: {
                        url: base_url + 'subscriber_manager/my_orders_data',
                        type: 'POST',
                        data: function (d) {
                            d.search_subscriber_id = $('#search_subscriber_id').val();
                            d.search_status = $('#search_status').val();
                            d.search_value = $('#search_value2').val();
                            d.search_date_range = $('#search_date_range_val').val();
                        }
                    },
                    language:
                        {
                            url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                        },
                    dom: '<"top"f>rt<"bottom"lip><"clear">',
                    columnDefs: [
                        {
                            targets: [1, 3, 6, 7, 11],
                            visible: false
                        },
                        {
                            targets: [5, 7, 8, 9, 10, 11],
                            className: 'text-center'
                        },
                        {
                            targets: [3, 4],
                            className: 'text-right'
                        },
                        {
                            targets: [2, 8, 9],
                            sortable: false
                        },
                        {
                            targets: [5, 6, 7, 8, 9],
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
                                data = data.replaceAll('fas fa-briefcase', 'bx bx-briefcase');
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
                                data = data.replaceAll('fas fa-male', 'bx bx-male')
                                data = data.replaceAll('fas fa-female', 'bx bx-female')
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
                                data = data.replaceAll('fas fa-ellipsis-v', 'bx bx-dots-vertical-rounded');
                                data = data.replaceAll('fas fa-file-signature', 'bx bxs-user-badge');
                                data = data.replaceAll('fas fa-user-circle', 'bx bxs-user');
                                data = data.replaceAll('fas fa-toggle-on', 'bx bx-toggle-right');
                                data = data.replaceAll('fas fa-toggle-off', 'bx bx-toggle-left');
                                data = data.replaceAll('fas fa-info-circle', 'bx bx-info-circle');
                                data = data.replaceAll('fa fa-image', 'bx bx-image');
                                data = data.replaceAll('208px', '308px');
                                data = data.replaceAll("data-toggle='tooltip'", " data-html='true' data-toggle='tooltip'");

                                return data;
                            }
                        }
                    ],
                    fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                        if (areWeUsingScroll) {
                            if (perscroll2) perscroll2.destroy();
                            perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
                        }
                    },
                    scrollX: 'auto',
                    fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                        if (areWeUsingScroll) {
                            if (perscroll2) perscroll2.destroy();
                            perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
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
            } else table2.draw();
        }

        function get_subscriber_customfields(id, subscribe_id, page_id) {
            $(".customfields_div").html('<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center"></i></div>');

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>subscriber_manager/get_subscriber_customfields_data",
                data: {id: id, page_id: page_id, subscribe_id: subscribe_id},
                success: function (response) {
                    $(".customfields_div").html(response);
                }
            });
        }

        function get_subscriber_formdata(id, subscribe_id, page_id) {
            $(".formdata_div").html('<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center"></i></div>');

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>subscriber_manager/get_subscriber_formdata",
                data: {id: id, page_id: page_id, subscribe_id: subscribe_id},
                success: function (response) {
                    $(".formdata_div").html(response);
                }
            });
        }

        $("#put_content").html(loading);

        //new theme js

        var chatSidebarListWrapper = $(".chat-sidebar-list-wrapper"),
            chatOverlay = $(".chat-overlay"),
            chatSidebarProfileToggle = $(".chat-sidebar-profile-toggle"),
            chatProfileToggle = $(".chat-profile-toggle"),
            chatSidebarClose = $(".chat-sidebar-close"),
            chatProfile = $(".chat-profile"),
            chatUserProfile = $(".chat-user-profile"),
            chatProfileClose = $(".chat-profile-close"),
            chatSidebar = $(".chat-sidebar"),
            chatArea = $(".chat-area"),
            chatStart = $(".chat-start"),
            chatSidebarToggle = $(".chat-sidebar-toggle"),
            chatMessageSend = $(".chat-message-send");


        "use strict";
        // menu user list perfect scrollbar initialization
        if (chatSidebarListWrapper.length > 0) {
            var menu_user_list = new PerfectScrollbar(".chat-sidebar-list-wrapper");
        }
        // user profile sidebar perfect scrollbar initialization
        if ($(".chat-user-profile-scroll").length > 0) {
            var profile_sidebar_scroll = new PerfectScrollbar(".chat-user-profile-scroll");
        }
        // chat area perfect scrollbar initialization
        if (chatContainer.length > 0) {
            var chat_user_user = new PerfectScrollbar(".chat-container");
        }
        if ($(".chat-profile-content").length > 0) {
            var chat_profile_content = new PerfectScrollbar(".chat-profile-content");
        }
        // user profile sidebar toggle
        chatSidebarProfileToggle.on("click", function () {
            chatUserProfile.addClass("show");
            chatOverlay.addClass("show");
        });
        // user profile sidebar toggle
        chatProfileToggle.on("click", function () {

            chatProfile.addClass("show");
            chatOverlay.removeClass("d-none");
            chatProfile.removeClass("d-none");
            chatOverlay.addClass("show");

        });
        // on profile close icon click
        chatProfileClose.on("click", function () {
            chatUserProfile.removeClass("show");
            chatProfile.removeClass("show");
            if (!chatSidebar.hasClass("show")) {
                chatOverlay.removeClass("show");
            }
        });
        // On chat menu sidebar close icon click
        chatSidebarClose.on("click", function () {
            chatSidebar.removeClass("show");
            chatOverlay.removeClass("show");
        });
        // on overlay click
        chatOverlay.on("click", function () {
            chatSidebar.removeClass("show");
            chatOverlay.removeClass("show");
            chatUserProfile.removeClass("show");
            chatProfile.removeClass("show");


        });

        function ajax_call(selected) {
            var page_table_id = $("#refresh_data").attr('page_table_id');
            var selected_chat = $("#contact_list .active").attr('data-id');

            $("#chat_with").html("<?php echo $this->lang->line('Loading...')?>");
            $.ajax({
                url: base_url + 'message_manager_n/' + get_pages_conversation_url,
                type: 'POST',
                data: {page_table_id: page_table_id,is_new_theme:true},
                success: function (response) {



                    $("#contact_list").html(response);
                    //$("#put_content").getNiceScroll().remove();
                    //$("#put_content").css('overflow', 'hidden');

                    $('#contact_list li[data-id="'+selected_chat+'"]').addClass("active");

                    $('.change_contact').on("click", function () {
                        if($(this).attr('data-id')!=undefined){
                            selected_chat = $(this).attr('data-id');
                        }

                        if ($("#contact_list li").hasClass("active")) {

                            $("#contact_list li").removeClass("active");
                            var parentUl = $(this).closest('ul');
                            parentUl.find('li').not(this).removeClass('active');

                        }

                        if ($("#contact_list li").hasClass("active")) {
                            $(".chat-start").removeClass("d-none");
                            $(".chat-area").addClass("d-none");
                        }else{
                            $(".chat-start").addClass("d-none");
                            $(".chat-area").removeClass("d-none");
                        }

                        $('#livechat_name_header').html($('#contact_list li[data-id="'+selected_chat+'"] .livechat_username').html());

                        usr_dat = $('#contact_list li[data-id="'+selected_chat+'"]');
                        if(usr_dat.attr('data-human-agent')=='1'){
                            $("#state_human_agent_user").prop('checked',  true);
                        }else{
                            $("#state_human_agent_user").prop('checked',  false);
                        }

                        iScrollBLock = false;
                        $('#infoscrollbarblock').hide();

                        ajax_get_chat($(this));
                    });

                }
            });





            // Add class active on click of Chat users list
            $(".chat-sidebar-list-wrapper ul li").on("click", function () {

                if ($(".chat-sidebar-list-wrapper ul li").hasClass("active")) {
                    $(".chat-sidebar-list-wrapper ul li").removeClass("active");
                }
                $(this).addClass("active");
                if ($(".chat-sidebar-list-wrapper ul li").hasClass("active")) {
                    chatStart.addClass("d-none");
                    chatArea.removeClass("d-none");
                }
                else {
                    chatStart.removeClass("d-none");
                    chatArea.addClass("d-none");
                }
            });
            // app chat favorite star click
            $(".chat-icon-favorite i").on("click", function (e) {
                $(this).parent(".chat-icon-favorite").toggleClass("warning");
                $(this).toggleClass("bxs-star bx-star");
                e.stopPropagation();
            });
            // menu toggle till medium screen
            if ($(window).width() < 992) {
                chatSidebarToggle.on("click", function () {
                    chatSidebar.addClass("show");
                    chatOverlay.addClass("show");
                });
            }
            // autoscroll to bottom of Chat area
            $(".chat-sidebar-list li").on("click", function () {
                //  chatContainer.animate({ scrollTop: chatContainer[0].scrollHeight }, 400)
            });

            // click on main menu toggle will remove sidebars & overlays
            $(".menu-toggle").click(function () {
                chatSidebar.removeClass("show");
                chatOverlay.removeClass("show");
                chatUserProfile.removeClass("show");
                chatProfile.removeClass("show");
            });

            // chat search filter
            $("#chat-search").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                if (value != "") {
                    $(".chat-sidebar-list-wrapper .chat-sidebar-list li").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                }
                else {
                    // if search filter box is empty
                    $(".chat-sidebar-list-wrapper .chat-sidebar-list li").show();
                }
            });
            // window resize
            $(window).on("resize", function () {
                // remove show classes from overlay when resize, if size is > 992
                if ($(window).width() > 992) {
                    if (chatOverlay.hasClass("show")) {
                        chatOverlay.removeClass("show");
                    }
                }
                // menu toggle on resize till medium screen
                if ($(window).width() < 992) {
                    chatSidebarToggle.on("click", function () {
                        chatSidebar.addClass("show");
                        chatOverlay.addClass("show");
                    });
                }
                // disable on click overlay when resize from medium to large
                if ($(window).width() > 992) {
                    chatSidebarToggle.on("click", function () {
                        chatOverlay.removeClass("show");
                    });
                }
            });



        }

        ajax_call();




        function ajax_get_chat(rthis){
            if(iScrollBLock){
                return;
            }

            var from_user_id = rthis.attr('from_user_id');
            var from_user = rthis.attr('from_user');
            var thread_id = rthis.attr('thread_id');
            var message_tag = $('#message_tag').val();
            var page_table_id = $("#refresh_data").attr('page_table_id');


            $.ajax({
                type: 'POST',
                // dataType: 'JSON',
                data: {
                    params:"",
                    page_table_id: page_table_id,
                    from_user_id: from_user_id,
                    thread_id: thread_id,
                    message_tag: message_tag
                },
                url: base_url + 'message_manager_n/' + get_post_conversation_url,
                success: function (data) {

                    $("#chat-content-section").html("");
                    $("#chat-content-section").html(data);

                    $(".chat-container").scrollTop('initial');
                    if($(".chat-content")[0].scrollHeight>$(".chat-container").height()){
                        $(".chat-container").scrollTop($(".chat-content").height());
                        iScrollPos = $(".chat-container").scrollTop();
                    }

                }
            });

        }



        $(".chat-sidebar-close").on("click", function () {
            chatSidebar.removeClass("show");
            chatOverlay.removeClass("show");
        });

        const interval = setInterval(function() {
            ajax_get_chat($("#contact_list .active"));
        }, 15000);


        const interval_c = setInterval(function() {
            ajax_call(".open_conversation:first");
        }, 10000);


        $('#infoscrollbarblock').on('click', function () {
            iScrollBLock = false;
            $('#infoscrollbarblock').hide();
            $('.change_contact.active').click();
        });






        $(document).on('click', '#refresh_data', function (e) {
            e.preventDefault();
            var from_user_id = $('.open_conversation.active').attr('from_user_id');
            $("#put_content").html(loading);
            var selected = ".open_conversation[from_user_id=" + from_user_id + "]";
            ajax_call(selected);
        });

        $(document).on('click', '.postback-item', function (e) {
            e.preventDefault();
            var page_table_id = $("#refresh_data").attr('page_table_id');
            var subscriber_id = $('.open_conversation_contacts.active').attr('from_user_id');
            var postback_id = $(this).attr('data-id');

            $(this).addClass('disabled');

            $.ajax({
                context: this,
                url: base_url + 'message_manager/send_postback_reply',
                type: 'POST',
                data: {page_table_id, subscriber_id, postback_id, social_media},
                dataType: 'JSON',
                success: function (response) {
                    $(this).removeClass('disabled');
                    $('#postbackModal').modal('hide');
                    if (response.status == '1') {
                        iziToast.success({
                            title: '<?php echo $this->lang->line("Template Sent")?>',
                            message: response.message,
                            position: 'bottomRight'
                        });
                        $('.open_conversation.active').click();
                    } else {
                        iziToast.error({
                            title: '<?php echo $this->lang->line("Error")?>',
                            message: response.message,
                            position: 'bottomRight'
                        });
                    }
                }
            });
        });

    });




    $("#final_reply_button").on("click", function () {
        var message_tag=$('#message_tag').val();

        var from_user_id = $(this).attr('from_user_id');
        var from_user = $(this).attr('from_user');
        var thread_id = $(this).attr('thread_id');
        var page_table_id = $(this).attr('page_table_id');

        var message = $(".chat-message-send").val();
        if (message != "") {


            $.ajax({
                url: base_url + 'message_manager/' + reply_to_conversation_url,
                type: 'POST',
                data: {
                    page_table_id: page_table_id,
                    reply_message: message,
                    from_user_id: from_user_id,
                    thread_id: thread_id,
                    message_tag: message_tag
                },
                success: function (response) {

                    var html = '<div class="chat-message">' + "<p>" + message + "</p>" + "<div class=" + "chat-time" + ">3:35 AM</div></div>";
                    $(".chat-wrapper .chat:last-child .chat-body").append(html);
                    $(".chat-message-send").val("");

                    iScrollBLock = false;
                    $('#infoscrollbarblock').hide();

                    $(".chat-container").scrollTop('initial');
                    if($(".chat-content")[0].scrollHeight>$(".chat-container").height()){
                        $(".chat-container").scrollTop($(".chat-content").height());
                        iScrollPos = $(".chat-container").scrollTop();
                    }


                }

            });


        }

    });




    $(document).on('click', '.n_subscriber_actions_modal', function (e) {
        e.preventDefault();

        $("#n_subscriber_actions_modal").modal();
        //get_subscriber_action_content(0,from_user_id,page_table_id_social_media);
        var user_input_flow_exist = "no";
        if (user_input_flow_exist == 'yes') {
            get_subscriber_flowdata(0, from_user_id, page_table_id_social_media);
            get_subscriber_customfields(0, from_user_id, page_table_id_social_media);
        } else {
            $("#flowanswers-tab,#customfields-tab").hide();
        }

        if (is_webview_exist) {
            get_subscriber_formdata(0, from_user_id, page_table_id_social_media);
        } else $("#formdata-tab").hide();

        $("#flowanswers-tab").click();
    });



    function get_subscriber_formdata(id, subscribe_id, page_id) {

        $(".formdata_div").html('<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center"></i></div>');

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>/subscriber_manager/get_subscriber_formdata",
            data: {id: id, page_id: page_id, subscribe_id: subscribe_id},
            success: function (response) {
                $(".formdata_div").html(response);
            }
        });
    }

</script>





<?php include(FCPATH . 'application/n_views/messenger_tools/subscriber_actions_common_js.php'); ?>


<!-- Modal -->
<div class="modal fade" id="postbackModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title full_width" id="postbackModalLabel">
                    <i class="bx bx-paper-plane"></i> <?php echo $this->lang->line('Send Template') ?>
                    <input type="text" class="form-control d-inline" autofocus style="width: 120px;" autofocus=""
                           onkeyup="search_in_class(this,'postback-item')"
                           placeholder="<?php echo $this->lang->line('Search') ?>...">
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="height:500px;overflow:auto" id="postbackModalBody">
                <?php echo $postback_list; ?>
            </div>
        </div>
    </div>
</div>

<style>
    /*@media (min-width: 992px) {*/
    /*    .no_padding_col {*/
    /*        padding: 0 !important;*/
    /*    }*/

    /*    .no_padding_col_left {*/
    /*        padding-left: 0 !important;*/
    /*    }*/

    /*    .no_padding_col_right {*/
    /*        padding-right: 0 !important;*/
    /*    }*/

    /*    .main_row {*/
    /*        margin-left: 0;*/
    /*    }*/
    /*}*/

    /*.no_radius {*/
    /*    border-radius: 0 !important;*/
    /*}*/


    /*#subscriber_action .pt-4{*/
    /*    padding:0px !important;*/
    /*}*/

    #subscriber_action .list-group-item {
        padding-left: 0 !important;
    }

    #livechat_name_header{
        cursor:pointer;
    }



    /*.chat-application .chat-profile{*/
    /*    height:unset !important;*/
    /*}*/

    /*.chat-application .chat-profile .chat-profile-content {*/
    /*    height: calc(90vh - 6.5rem) !important;*/
    /*}*/

    /*.chat-profile .ps__rail-x{*/
    /*    display: none !important;*/
    /*}*/

</style>