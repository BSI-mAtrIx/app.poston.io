<script>

    var ext_butt = [
        {
            name: 'Pa',
            tooltip: '<?php echo $this->lang->line('Paraphrase'); ?>',
            exec: (editor) => {
                var selection = editor.selection;
                var text = editor.selection.html;

                special_button('paraphrase', text, editor);
            }
        },
        {
            name: 'Re',
            tooltip: '<?php echo $this->lang->line('Rewrite'); ?>',
            exec: (editor) => {
                var selection = editor.selection;
                var text = editor.selection.html;

                special_button('rewrite', text, editor);
            }
        },
        {
            name: 'Co',
            tooltip: '<?php echo $this->lang->line('Complete'); ?>',
            exec: (editor) => {
                var selection = editor.selection;
                var text = editor.selection.html;

                special_button('complete', text, editor);
            }
        },
        {
            name: 'Pl',
            tooltip: '<?php echo $this->lang->line('Plagiarism checker'); ?>',
            exec: (editor) => {
                var selection = editor.selection;
                var text = editor.selection.html;

                special_button('plagiarism', text, editor);
            }
        },
        {
            name: 'Gr',
            tooltip: '<?php echo $this->lang->line('Grammar'); ?>',
            exec: (editor) => {
                var selection = editor.selection;
                var text = editor.selection.html;

                special_button('grammar', text, editor);
            }
        },
        {
            name: 'Ex',
            tooltip: '<?php echo $this->lang->line('Extend'); ?>',
            exec: (editor) => {
                var selection = editor.selection;
                var text = editor.selection.html;

                special_button('extend', text, editor);
            }
        },
        {
            name: 'Sh',
            tooltip: '<?php echo $this->lang->line('Shorten'); ?>',
            exec: (editor) => {
                var selection = editor.selection;
                var text = editor.selection.html;

                special_button('shorten', text, editor);
            }
        }
    ];

    var langs = {};
    langs['keywords'] = "<?php echo $this->lang->line("Description your article. Use only keywords for best results."); ?>";
    langs['section_topic'] = "<?php echo $this->lang->line("Copy here your section topic."); ?>";
    langs['section_keywords'] = "<?php echo $this->lang->line("Description your section topic. Use only keywords for best results. (option)"); ?>";
    langs['bad_response'] = "<?php echo $this->lang->line("Bad response. Please contact with administration."); ?>";
    langs['text_to_transform'] = "<?php echo $this->lang->line("Text to transform"); ?>";
    langs['script'] = "<?php echo $this->lang->line("Script"); ?>";
    langs['sentence'] = "<?php echo $this->lang->line("Sentence"); ?>";
    langs['keywords_niche'] = "<?php echo $this->lang->line("Niche Keywords"); ?>";
    langs['describe_startup'] = "<?php echo $this->lang->line("Startup Description"); ?>";
    langs['text'] = "<?php echo $this->lang->line("Text"); ?>";
    langs['product_audience'] = "<?php echo $this->lang->line("Product and audience description"); ?>";
    langs['headline'] = "<?php echo $this->lang->line("Headline"); ?>";
    langs['keywords_single'] = "<?php echo $this->lang->line("Keywords"); ?>";
    langs['bullets'] = "<?php echo $this->lang->line("Bullets"); ?>";
    langs['button'] = "<?php echo $this->lang->line("Button"); ?>";
    langs['description'] = "<?php echo $this->lang->line("Description"); ?>";
    langs['word'] = "<?php echo $this->lang->line("Word"); ?>";
    langs['video_title'] = "<?php echo $this->lang->line("Video title"); ?>";
    langs['product_target'] = "<?php echo $this->lang->line("Product target"); ?>";
    langs['product_bullets'] = "<?php echo $this->lang->line("Product bullet text"); ?>";
    langs['product_name'] = "<?php echo $this->lang->line("Product name"); ?>";
    langs['command'] = "<?php echo $this->lang->line("Command"); ?>";
    langs['keywords_or_desc'] = "<?php echo $this->lang->line("Keywords or description"); ?>";
    langs['photo_description'] = "<?php echo $this->lang->line("Photo description"); ?>";
    langs['photo_description_key'] = "<?php echo $this->lang->line("Photo description or keywords"); ?>";
    langs['video_chapter'] = "<?php echo $this->lang->line("Video Chapter"); ?>";

    function get_lang($str) {
        return langs[$str];
    }

    function to_api($endpoint, $data) {
        return $.ajax({
            type: 'POST',
            dataType: 'JSON',
            data: $data,
            url: '<?php echo base_url('n_generator/api/'); ?>' + $endpoint,
            success: function (res) {
                $.unblockUI();
                if (res.error) {
                    swal.fire({
                        icon: 'error',
                        text: res.error,
                        title: '<?php echo $this->lang->line('Error!'); ?>',
                    });
                    return;
                }
                if (res.status == "ok_alert") {
                    iziToast.success({title: '', message: res.message, position: 'bottomRight'});
                }

                return res;
            },
            error: function (xhr, status, error) {
                // Shows error if something goes wrong
                $.unblockUI();
                swal.fire({
                    icon: 'error',
                    text: xhr.responseText,
                    title: '<?php echo $this->lang->line('Error!'); ?>',
                });
            }
        });
    }

    function special_button(action_api, textarea, editor){
        var count = textarea.length;

        if(count<100){
            iziToast.warning({title: '', message: '<?php echo $this->lang->line('Selected text is too short. Minimum characters: 100'); ?>', position: 'bottomRight'});
            return;
        }

        if(count>2048){
            iziToast.warning({title: '', message: '<?php echo $this->lang->line('Selected text is too long. Maximum characters: 2048'); ?>', position: 'bottomRight'});
            return;
        }

        $.blockUI({
            message: '<div class="bx bx-revision bx-spin bx-md"></div>',
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

        var doc_id = $('#doc_id').val();

        var language = $('#language').val();
        var tone = $('#tone').val();
        var creativity = $('#creativity').val();
        var textarea_c1 = '';

        var api_json = to_api('generate', {
            action_api,
            textarea,
            doc_id,
            language,
            tone,
            creativity,
            textarea_c1,

            csrf_token: "<?php echo $this->session->userdata('csrf_token_session'); ?>"
        }).done(function (res) {
            if (res['message'] == 'bad_response') {
                swal.fire({
                    icon: 'error',
                    text: get_lang(res['message']),
                    title: '<?php echo $this->lang->line('Error!'); ?>',
                });
                return;
            }
            res['message']['text'] = res['message']['text'].replace("/\n/g", "<br />");
            // if (res['message']['replace'] != undefined) {
            //     res['message']['replace'] = res['message']['replace'].replaceAll("\\", '');
            //     editor.value = editor.value.replace(res['message']['replace'], res['message']['replace'] + res['message']['text'] + "<br />");
            // } else {
            //     editor.value = editor.value + res['message']['text'];
            // }

            if(action_api=='plagiarism'){
                iziToast.warning({title: '', message: res['message']['text'], position: 'bottomRight'});
                return;
            }

            editor.s.insertHTML(res['message']['text']);

            var text = '<div class="border p-1 mb-1 d-block"><div class="action vote_' + res.message.insert_id + '">';

            text = text + '<?php echo $this->lang->line("Feedback: "); ?>' +
                '<a href="#" class="feedback_action" data-id="' + res.message.insert_id + '" data-vote="yes"><i class="bx bx-happy-heart-eyes"></i></a><a href="#" class="feedback_action" data-id="' + res.message.insert_id + '" data-vote="no"> <i class="bx bx-sad"></i></a>';

            text = text + '</div><div class="ai_content border-top">' + res.message.text + '</div></div>';

            $('.generate_result').html(text);

            $('#credits_cp').html(res['message']['cp_update']);
            $('#user_menu_cp').html(res['message']['cp_update']);




        });
    }
</script>