<script type="text/javascript">
    $('document').ready(function () {

        var csrf_token = $('#csrf_token').val();
        var editor = new Jodit('#document');

        var langs = {};
        langs['keywords'] = "<?php echo $this->lang->line("Description your article. Use only keywords for best results."); ?>";
        langs['section_topic'] = "<?php echo $this->lang->line("Copy here your section topic."); ?>";
        langs['section_keywords'] = "<?php echo $this->lang->line("Description your section topic. Use only keywords for best results. (option)"); ?>";
        langs['bad_response'] = "<?php echo $this->lang->line("Bad response. Please contact with administration."); ?>";

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
            $('#filters li').hide();
            if ($(this).val() == 'all') {
                $('#filters li').show();
                return;
            }
            $('#filters li.' + $(this).val()).show();
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
        editor.events.on('change', () => n_auto_save());
        <?php } ?>

        $(document).on('click', '#filters li', function (e) {
            $('#action_api').val($(this).attr('action'));
            $('#count_limit').html($(this).attr('count_limit'));
            $('#textarea-counter').attr('data-length', $(this).attr('count_limit'));

            $('#textarea-counter').val('');
            $('#main_title').html(get_lang($(this).attr('textarea_title')));

            $('textarea.customs').val('');
            $('div.customs_editor').hide();

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


        $(document).on('click', '#generate_action', function (e) {
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
                res['message']['text'] = res['message']['text'].replace(/\n/g, "<br />");
                if (res['message']['replace'] != undefined) {
                    editor.value = editor.value.replace(res['message']['replace'], res['message']['replace'] + res['message']['text'] + "<br />");
                } else {
                    editor.value = editor.value + res['message']['text'];
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
