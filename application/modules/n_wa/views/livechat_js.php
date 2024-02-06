<script>
    var chatSidebarListWrapper = $(".chat-sidebar-list-wrapper"),
        chatOverlay = $(".chat-overlay"),
        chatContainer = $(".chat-container"),
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

    var contacts_list = '';
    var selected_chat = null;
    var livechat_bot_selected = <?php echo $bot_id; ?>;
    var csrf_token = "<?php echo $this->session->userdata('csrf_token_session'); ?>";
    var url_bot = "n_wa/api/";
    var base_url = "<?php echo site_url(); ?>";
    var csrf_token = "<?php echo $csrf_token; ?>";
    var iScrollPos = 0;
    var iScrollBLock = false;

    function chatMessagesSend(source) {
        var message = chatMessageSend.val();
        if (message != "") {
            var html =
                '<div class="chat">'+
                '<div class="chat-avatar">'+
                '<a class="avatar m-0 bg-info">'+
                '<img src="<?php echo base_url(); ?>assets/img/avatar/avatar-1.png" alt="chat avatar" height="36" width="36">' +
                '</a>' +
                '</div>'+
                '<div class="chat-body">'+
                '<div class="chat-message">'+
                "<p>" + message + "</p>"+
                "<div class=" + "chat-time" + "><?php echo $this->lang->line('Sending...'); ?></div>" +
                '</div>'+
                '</div>'+
                '</div>';

            $(".chat-wrapper .chat-content").append(html);

            chatContainer.scrollTop($(".chat-container > .chat-content").height());

            var params_filter_labels_custom = {
                bot_id: livechat_bot_selected,
                message: message,
                chat_id: selected_chat
            }

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {params:params_filter_labels_custom, csrf_token:csrf_token},
                url: base_url + url_bot + 'ajax_send_message',
                success: function (data) {

                }
            });

            chatMessageSend.val("");
        }
    }

    var myDropzone = new Dropzone(document.body, {
        url: '<?php echo base_url('n_wa/api/ajax_send_file'); ?>',
        maxFilesize: 5,
        uploadMultiple: false,
        paramName: "file",
        disablePreviews: true, // Define the container to display the previews
        clickable: "#select-files", // Define the element that should be used as click trigger to select files.
        acceptedFiles: ".png,.jpg,.jpeg,.mp3,.aac,.amr,.ogg,.opus",
        maxFiles: 1,
        autoProcessQueue: true,
        success: function (file, response) {
            var data = JSON.parse(response);

            // Shows error message
            if (data.error) {
                swal.fire({
                    icon: 'error',
                    text: data.error,
                    title: '<?php echo $this->lang->line('Error!'); ?>'
                });
                return;
            }

            myDropzone.removeAllFiles();

        },
        // error: function (file, message, xhr) {
        //     //$(file.previewElement).remove();
        // },
        // removedfile: function (file) {
        //     var filename = $(uploaded_file).val();
        //     delete_uploaded_file(filename);
        //     $("#tmb_preview").show();
        // },
    });
    myDropzone.on('sending', function(file, xhr, formData){
        formData.append('csrf_token', csrf_token);
        formData.append('bot_id', livechat_bot_selected);
        formData.append('chat_id', selected_chat);
    });


    $('document').ready(function () {
        <?php require_once(APPPATH.'modules/n_wa/include/sweetalert_v1.php'); ?>

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
        if ($(window).width() < 992) {
            chatSidebarToggle.on("click", function () {
                chatSidebar.addClass("show");
                chatOverlay.addClass("show");
            });
        }

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

        $("#chat-search").on("keyup", function () {
            ajax_get_contacts();
                });

        function ajax_select($element, $endpoint, $placeholder, $params_custom = '') {
            $($element).select2({
                placeholder: $placeholder,
                width: '100%',
                ajax: {
                    delay: 400,
                    url: base_url + url_bot + $endpoint,
                    type: "POST",
                    dataType: 'json',
                    data: function (params) {
                        $.blockUI({
                            message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                            overlayCSS: {
                                backgroundColor: '#ffffff',
                                opacity: 0.8,
                                cursor: 'wait'
                            },
                            css: {
                                border: 0,
                                padding: 0,
                                backgroundColor: 'transparent'
                            }
                        });

                        var query = {
                            search: params.term,
                            csrf_token: csrf_token,
                            params: $params_custom
                        }

                        return query;
                    },
                    processResults: function (data) {
                        $.unblockUI();
                        if (data.status == '0') {
                            swal.fire({
                                icon: 'error',
                                text: data.error,
                                title: '<?php echo $this->lang->line('Error!'); ?>',
                            });
                            return;
                        }

                        if (data.message.select == undefined) {
                            return {
                                results: ''
                            };
                        }

                        return {
                            results: data.message.select.data
                        };
                    }
                }
            });
        }

        var params_filter_labels_custom = {
            bot_id: livechat_bot_selected
        }

        $('#filters_add').on("click", function () {
            $('#livechat_filters_labels').show();
            ajax_select(
                '#livechat_filters_labels_select',
                'livechat_filters_labels',
                "<?php echo $this->lang->line('Search for labels '); ?>",
                params_filter_labels_custom
            );
        });

        $('#livechat_filters_labels').on("change", function () {
            ajax_get_contacts();
        });

        $('#state_human_agent').on("change", function () {
            ajax_get_contacts();
        });

        $('#state_human_agent_user').on("change", function () {
            var state_human_agent_user_change = 0;
            if($("#state_human_agent_user").prop('checked')==true){
                state_human_agent_user_change = 1;
            }

            var params_filter_labels_custom = {
                bot_id: livechat_bot_selected,
                status: state_human_agent_user_change,
                chat_id: selected_chat
            }

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {params:params_filter_labels_custom, csrf_token:csrf_token},
                url: base_url + url_bot + 'ajax_change_human_status',
                success: function (data) {

                    if(data.status!=undefined && data.status=='ok'){
                        if(state_human_agent_user_change=='1'){
                            $("#state_human_agent_user").prop('checked',  false);
                        }else{
                            $("#state_human_agent_user").prop('checked',  true);
                        }
                    }

                }
            });
        });

        $('#refresh_contact_list').on("click", function () {
            ajax_get_contacts();
        });

        function ajax_get_contacts(){
            //todo: get selected to select after get new list
            var params_filter_labels_custom = {
                bot_id: livechat_bot_selected,
                label_id: $('#livechat_filters_labels_select').val(),
                state_human_agents: $('#state_human_agent').prop('checked'),
                contact_name_search: $('#chat-search').val()
            }

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {params:params_filter_labels_custom, csrf_token:csrf_token},
                url: base_url + url_bot + 'ajax_get_contacts',
                success: function (data) {

                    if(data.message.data!=undefined){
                        contacts_list = '';

                        $(data.message.data).each(function( index, el ) {

                            active_class = '';
                            if(selected_chat==el.id){
                                active_class = 'active';
                            }

                            new_message_human_agent = '';
                            if(el.state_human_agent_new==1){
                                new_message_human_agent = ' font-weight-bold';
                            }

                            //todo: bg-info rand
                            contacts_list +=
                                '<li class="change_contact '+active_class+'" data-id="'+el.id+'" data-human-agent="'+el.state_human_agent+'" data-labels=\''+el.labels+'\'>' +
                                    '<div class="d-flex align-items-center">' +
                                        '<div class="avatar bg-info m-0 mr-50">' +
                                            '<span class="avatar-content">'+el.icon+'</span>' +
                                        '</div>' +
                                        '<div class="chat-sidebar-name">' +
                                            '<h6 class="mb-0 livechat_username'+new_message_human_agent+'">'+el.name+'</h6><span class="text-muted'+new_message_human_agent+'">'+el.id+'</span>' +
                                        '</div>' +
                                    '</div>' +
                                '</li>';

                        });

                        $('#contact_list').html(contacts_list);

                        $('.change_contact').on("click", function () {
                            if($(this).attr('data-id')!=undefined){
                                selected_chat = $(this).attr('data-id');
                            }

                            if ($("#contact_list li").hasClass("active")) {
                                $("#contact_list li").removeClass("active");
                            }

                            $('#contact_list li[data-id="'+selected_chat+'"]').addClass("active");

                            if ($("#contact_list li").hasClass("active")) {
                                $(".chat-start").addClass("d-none");
                                $(".chat-area").removeClass("d-none");
                            }else{
                                $(".chat-start").removeClass("d-none");
                                $(".chat-area").addClass("d-none");
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



                        usr_dat = $('#contact_list li[data-id="'+selected_chat+'"]');
                        usr_dat.addClass("active");

                    }

                }
            });
        }
        ajax_get_contacts();

        function ajax_get_chat(rthis){
            if(iScrollBLock){
                return;
            }
            if(rthis==null){
                chat_id_send = selected_chat;
            }else{
                chat_id_send  =  rthis.attr('data-id');
                selected_chat = chat_id_send;
            }

            var params_filter_labels_custom = {
                bot_id: livechat_bot_selected,
                chat_id: chat_id_send
            }

            var chat = '';

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {params:params_filter_labels_custom, csrf_token:csrf_token},
                url: base_url + url_bot + 'ajax_get_chat',
                success: function (data) {

                    if(data.message.data!=undefined){
                        contacts_list = '';


                    $.each(data.message.data, function (i, el) {
                        is_left = '';
                        avatar_chat = '';
                        text_msg = '';
                        if(el.user_id==selected_chat){
                            is_left= "chat-left";
                            avatar_chat = '<span class="avatar-content">'+$('#contact_list li[data-id="'+selected_chat+'"] .avatar-content').html()+'</span>';
                        }else{
                            avatar_chat = '<img src="<?php echo base_url(); ?>assets/img/avatar/avatar-1.png" alt="chat avatar" height="36" width="36">';
                        }


                        msg_date = '<span class="chat-time">'+el.date+'</span>';
                        if(el.reply_markup!=null){
                            msg_date = '';
                        }

                        if(el.media!=null){
                            el.media = JSON.parse(el.media);

                            if(el.media[0].audio!=undefined){
                                text_msg += '<audio controls preload="none"><source src="'+el.media[0].audio+'"><?php echo $this->lang->line('Your browser does not support the audio element.'); ?></audio>';
                            }else{
                                if(el.media[0].document!=undefined){
                                    text_msg += '<span><i class="bx bx-file"></i>'+el.media[0].document.file_name+'</span>';
                                }else if(el.media[0].url==undefined) {
                                    text_msg += '<img src="' + el.media[0] + '" class="img-fluid" alt="photo" >'
                                }else{
                                    text_msg += '<img src="'+el.media[0].url+'" class="img-fluid" alt="photo" >'
                                }

                                if(el.media[0].caption!=undefined && el.media[0].caption!=''){
                                    text_msg += '<p>'+el.media[0].caption+'</p>';
                                }
                            }


                        }

                        if(el.text!=null) {
                            text_msg += '<p>' + el.text + '</p>';
                        }

                        chat +=
                            '<div class="chat '+is_left+'">'+
                            '<div class="chat-avatar">'+
                            '<a class="avatar m-0 bg-info">'+
                            avatar_chat +
                            '</a>' +
                            '</div>'+
                            '<div class="chat-body">'+
                            '<div class="chat-message">'+
                            text_msg+
                            msg_date +
                            '</div>'+
                            '</div>'+
                            '</div>';

                        if(el.reply_markup!=null){
                            el.reply_markup = JSON.parse(el.reply_markup);
                            buttons_chat = null;
                            msg_rm = '';



                            if(el.reply_markup.buttons!=undefined){
                                buttons_chat = el.reply_markup.buttons;

                            }

                            $.each(buttons_chat, function (irm, elrm) {
                                msg_rm += '<a class="btn btn-outline-primary" href="#">'+elrm.reply.title+'</a>';

                            });


                            chat +=
                                '<div class="chat '+is_left+'">'+
                                '<div class="chat-avatar">'+
                                '<a class="avatar m-0 bg-info">'+
                                avatar_chat +
                                '</a>' +
                                '</div>'+
                                '<div class="chat-body">'+
                                '<div class="chat-message bg-transparent">'+
                                '<p>'+msg_rm+'</p>'+
                                '<span class="chat-time">'+el.date+'</span>'+
                                '</div>'+
                                '</div>'+
                                '</div>';
                        }

                    });

                        $('.chat-content').html(chat);

                        $('audio').on('playing', function(){
                            $('#infoscrollbarblock').show();
                            iScrollBLock = true;
                        });
                        $('audio').on('ended', function(){
                            $('#infoscrollbarblock').hide();
                            iScrollBLock = false;
                        });

                        $(".chat-container").scrollTop('initial');
                        if($(".chat-content")[0].scrollHeight>$(".chat-container").height()){
                            $(".chat-container").scrollTop($(".chat-content").height());
                            iScrollPos = $(".chat-container").scrollTop();
                        }

                    }

                }
            });

        }

        chatSidebarClose.on("click", function () {
            chatSidebar.removeClass("show");
            chatOverlay.removeClass("show");
        });

        const interval = setInterval(function() {
            ajax_get_contacts();
            ajax_get_chat(null);
        }, 5000);


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

        $('#infoscrollbarblock').on('click', function () {
            iScrollBLock = false;
            $('#infoscrollbarblock').hide();
            ajax_get_chat(null);
        });




    });
</script>