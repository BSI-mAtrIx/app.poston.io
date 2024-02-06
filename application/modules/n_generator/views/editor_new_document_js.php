<script type="text/javascript">
    function search_in_ul_n(obj) {  // obj = 'this' of jquery, ul_id = id of the ul
        var ul_id = 'filters';
        var filter = $(obj).val().toUpperCase();
        $('#' + ul_id + ' li').each(function () {
            var content = $(this).text().trim();

            if (content.toUpperCase().indexOf(filter) > -1) {
                $(this).removeClass('hidden');
            } else $(this).addClass('hidden');
        });
    }

    $('document').ready(function () {

        if (window.swal && typeof window.swal.fire !== "function") {
            window.swal.fire = function ($args) {
                window.swal($args);
            };
        }

        var csrf_token = $('#csrf_token').val();

        const editor = new toastui.Editor({
            el: document.querySelector('#editor'),
            previewStyle: 'vertical',
            height: '500px',
            initialValue: $('#document').html()
        });

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


        /***********************/
        // Component Variables //
        /***********************/
        var accordion = $(".accordion"),
            defaultaccordion = $(".accordion .card-header"),
            collapseTitle = $(".collapsible .card-header"),
            collapseHoverTitle = $(".card-hover .card-header"),
            dropdownMenuIcon = $(".dropdown-icon-wrapper .dropdown-item");

        // To open Collapse on hover
        if (accordion.attr("data-toggle-hover", "true")) {
            collapseHoverTitle.closest(".card").on("mouseenter", function () {
                var $this = $(this);
                $this.children(".collapse").collapse("show");
                $this.closest(".card").addClass("open");
            });
            collapseHoverTitle.closest(".card").on("mouseleave", function () {
                var $this = $(this);
                $this.children(".collapse").collapse("hide");
                $this.closest(".card").removeClass("open");
            });
        }
        // When Collapse open on click
        collapseTitle.on("click", function () {
            var $this = $(this);
            $this.next(".collapse").on('show.bs.collapse', function () {
                $this.parent().addClass("open")
            })
            $this.next(".collapse.show").on('hide.bs.collapse', function () {
                $this.parent().removeClass("open")
            })
        });
        // When accordion open on click
        defaultaccordion.on("click", function () {
            var $this = $(this);
            if ($this.parent().next(".show")) {
                $this.closest(".card").toggleClass("open");
                $this.closest(".card").siblings(".open").removeClass("open");
            }
        });


        $("#filter_frameworks").change(function () {
            $('#filters li').addClass('hidden');
            console.log($(this).val());
            if ($(this).val() == 'all') {
                $('#filters li').removeClass('hidden');
                return;
            }
            $('#filters li.' + $(this).val()).removeClass('hidden');
        });

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

        function save_new_config() {
            var language = $('#language').val();
            var tone = $('#tone').val();
            var creativity = $('#creativity').val();
            var autosave = $('#autosave').val();

            to_api('save_user_config', {language, tone, creativity, autosave, csrf_token});
        }

        $("#language").change(function () {
            save_new_config();
        });

        $("#tone").change(function () {
            save_new_config();
        });

        $("#creativity").change(function () {
            save_new_config();
        });

        $("#autosave").change(function () {
            save_new_config();
        });


        function generate_text() {
            var language = $('#language').val();
            var tone = $('#tone').val();
            var creativity = $('#creativity').val();

            to_api('', {
                language,
                tone,
                creativity,
                csrf_token
            });
        }

        function n_save_document() {
            var doc_title = $('#doc_title').val();
            var doc_text = $('#document').val();
            var doc_id = $('#doc_id').val();

            to_api('save_document', {
                doc_title,
                doc_text,
                doc_id,
                csrf_token
            });
        }

        $(document).on('click', '#button-editor-save', function (e) {
            n_save_document();
        });

        var delay = (function () {
            var timer = 0;
            return function (callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })()


        function n_auto_save() {
            delay(function () {
                n_save_document();
            }, 2000);
        }

        <?php if($config_autosave == 'true'){ ?>
        //editor.events.on('change', () => n_auto_save());
        <?php } ?>

        $(document).on('click', '#filters li', function (e) {
            $('#action_api').val($(this).attr('action'));
            $('#count_limit').html($(this).attr('count_limit'));
            $('#textarea-counter').attr('data-length', $(this).attr('count_limit'));

            $('#main_title').html(get_lang($(this).attr('textarea_title')));

            $('textarea.customs').val('');

            $('div.customs_editor').hide();


            $('#framework_title').html($(this).find('.list-title').html());


            if ($(this).attr('custom1_editor') != undefined) {
                $('#custom1').show();
                $('#custom1_title').html(get_lang($(this).attr('custom1_editor')));
                $('#custom1 textarea').attr('data-length', $(this).attr('c1_count_limit'));
                $('#count_limit_c1').html($(this).attr('c1_count_limit'));
            }

            $('.generate_result').html();

            $('.nav_action li a').removeClass('active');
            $('.tabs_action .tab-pane').removeClass('active');
            $('#action-fill').addClass('active');
        });

        $(document).on('click', '#load_more_action', function (e) {
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
            var load_more = $('#load_more_action').attr('data-start');

            var api_json = to_api('history', {
                load_more,

                csrf_token
            }).done(function (res) {

                if (res.data.length == 0) {
                    $("#load_more_action").hide();
                    $("#no_more_results").show();

                    return;
                }
                $.each(res.data, function (key, val) {
                    var text = '<div class="border p-1 mb-1 d-block"><div class="action vote_' + val.id + '">';

                    if (val.vote == 'none') {
                        text = text + '<?php echo $this->lang->line("Feedback: "); ?>' +
                            '<a href="#" class="feedback_action" data-id="' + val.id + '" data-vote="yes"><i class="bx bx-happy-heart-eyes"></i></a><a href="#" class="feedback_action" data-id="' + val.id + '" data-vote="no"> <i class="bx bx-sad"></i></a>';
                    }

                    text = text + '</div><div class="ai_content border-top">' + val.response + '</div></div>';

                    $("#history_load").append(text);
                    $("#load_more_action").attr('data-start', res.start);

                });

            });

        });

        $(document).on('click', '.feedback_action', function (e) {
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
            var id = $(this).attr('data-id');
            var feedback = $(this).attr('data-vote');

            var api_json = to_api('vote', {
                id,
                feedback,
                csrf_token
            }).done(function (res) {
                $('.vote_' + id).hide();
            });

        });

        $( '#generate_action').on('click', function (e) {
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

            var action_api = $('#action_api').val();
            var textarea = $('#textarea-counter').val();
            var doc_id = $('#doc_id').val();

            var language = $('#language').val();
            var tone = $('#tone').val();
            var creativity = $('#creativity').val();

            var textarea_c1 = $('#textarea-c1').val();


            var api_json = to_api('generate', {
                action_api,
                textarea,
                doc_id,
                language,
                tone,
                creativity,
                textarea_c1,

                csrf_token
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
                if (res['message']['replace'] != undefined) {
                    res['message']['replace'] = res['message']['replace'].replaceAll("\\", '');
                    //editor.value = editor.value.replace(res['message']['replace'], res['message']['replace'] + res['message']['text'] + "<br />");
                } else {
                    //editor.value = editor.value + res['message']['text'];
                }

                var text = '<div class="border p-1 mb-1 d-block"><div class="action vote_' + res.message.insert_id + '">';

                text = text + '<?php echo $this->lang->line("Feedback: "); ?>' +
                    '<a href="#" class="feedback_action" data-id="' + res.message.insert_id + '" data-vote="yes"><i class="bx bx-happy-heart-eyes"></i></a><a href="#" class="feedback_action" data-id="' + res.message.insert_id + '" data-vote="no"> <i class="bx bx-sad"></i></a>';

                text = text + '</div><div class="ai_content border-top">' + res.message.text + '</div></div>';

                $('.generate_result').html(text);

                $('#credits_cp').html(res['message']['cp_update']);
                $('#user_menu_cp').html(res['message']['cp_update']);


            });


        });


    });
</script>
