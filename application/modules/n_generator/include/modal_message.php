<div class="modal fade" tabindex="-1" role="dialog" id="generator_modal_message" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><?php echo $this->lang->line("Generate message using AI"); ?> <span
                        class="put_add_on_title"></span></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">

                <form>
                    <input type="hidden" name="csrf_token" id="csrf_token"
                           value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

                    <div class="row">
                        <div class="col-12">
                            <label for="textarea-counter"><?php echo $this->lang->line('Description about mesasge'); ?></label>
                            <fieldset class="form-label-group mb-0">
                                <textarea data-length="200"
                                          class="form-control char-textarea customs"
                                          id="textarea-counter" rows="3"></textarea>
                            </fieldset>
                            <small class="counter-value float-right"><span
                                    class="char-count">0</span> / <span
                                    id="count_limit">200</span> </small>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <h6><?php echo $this->lang->line("Language"); ?></h6>
                            <div class="form-group">
                                <?php echo form_dropdown('language', $sdk_locale, $config_sdk_locale, 'class="select2 form-control" id="language"'); ?>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <h6><?php echo $this->lang->line("Creativity"); ?></h6>
                            <div class="form-group">
                                <?php
                                $select_lan = 'false';
                                if (isset($config_creativity)) {
                                    $select_lan = $config_creativity;
                                }
                                $options = array();
                                $options['Optimal'] = $this->lang->line("Optimal");
                                $options['None'] = $this->lang->line("None (more factual)");
                                $options['Low'] = $this->lang->line("Low");
                                $options['Medium'] = $this->lang->line("Medium");
                                $options['High'] = $this->lang->line("High");
                                $options['Max'] = $this->lang->line("Max (less factual)");

                                echo form_dropdown('creativity', $options, $select_lan, 'class="select2 form-control" id="creativity"'); ?>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <h6><?php echo $this->lang->line("Tone"); ?></h6>
                            <div class="form-group">
                                <?php
                                $select_lan = 'false';
                                if (isset($config_tone)) {
                                    $select_lan = $config_tone;
                                }
                                $options = array();
                                $options['Appreciative'] = $this->lang->line("Appreciative");
                                $options['Assertive'] = $this->lang->line("Assertive");
                                $options['Awestruck'] = $this->lang->line("Awestruck");
                                $options['Candid'] = $this->lang->line("Candid");
                                $options['Casual'] = $this->lang->line("Casual");
                                $options['Cautionary'] = $this->lang->line("Cautionary");
                                $options['Compassionate'] = $this->lang->line("Compassionate");
                                $options['Convincing'] = $this->lang->line("Convincing");
                                $options['Critical'] = $this->lang->line("Critical");
                                $options['Earnest'] = $this->lang->line("Earnest");
                                $options['Enthusiastic'] = $this->lang->line("Enthusiastic");
                                $options['Formal'] = $this->lang->line("Formal");
                                $options['Funny'] = $this->lang->line("Funny");
                                $options['Humble'] = $this->lang->line("Humble");
                                $options['Humorous'] = $this->lang->line("Humorous");
                                $options['Informative'] = $this->lang->line("Informative");
                                $options['Inspirational'] = $this->lang->line("Inspirational");
                                $options['Joyful'] = $this->lang->line("Joyful");
                                $options['Passionate'] = $this->lang->line("Passionate");
                                $options['Thoughtful'] = $this->lang->line("Thoughtful");
                                $options['Urgent'] = $this->lang->line("Urgent");
                                $options['Worried'] = $this->lang->line("Worried");

                                echo form_dropdown('tone', $options, $select_lan, 'class="select2 form-control" id="tone"'); ?>
                            </div>
                        </div>

                    </div>


                </form>



            </div>

            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-primary" id="generate_action" data-dismiss="modal">
                    <span class="align-middle ml-25"><?php echo $this->lang->line("generate and paste"); ?></span>
                </button>

                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <span class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    var csrf_token = $('#csrf_token').val();

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

    $('#generate_action').on('click', function (e) {
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

        var action_api = 'telegram_message_generator';
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
            res['message']['text'] = res['message']['text'].replaceAll("\n", "");
            res['message']['text'] = res['message']['text'].replaceAll("<br />", "");

            if (res['message']['replace'] != undefined) {
                res['message']['replace'] = res['message']['replace'].replaceAll("\\", '');
            }

            $('#editor_message').val(res['message']['text']);

            //var text = '<div class="border p-1 mb-1 d-block"><div class="action vote_' + res.message.insert_id + '">';
            //
            //text = text + '<?php //echo $this->lang->line("Feedback: "); ?>//' +
            //    '<a href="#" class="feedback_action" data-id="' + res.message.insert_id + '" data-vote="yes"><i class="bx bx-happy-heart-eyes"></i></a><a href="#" class="feedback_action" data-id="' + res.message.insert_id + '" data-vote="no"> <i class="bx bx-sad"></i></a>';
            //
            //text = text + '</div><div class="ai_content border-top">' + res.message.text + '</div></div>';
            //
            //$('.generate_result').html(text);




        });


    });
</script>