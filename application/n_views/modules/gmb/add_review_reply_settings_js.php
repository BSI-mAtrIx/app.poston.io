<script>
    $(document).ready(function () {

        $("#generic_message, #reply_settings, #not_found_reply_settings").emojioneArea({
            <?php if ($rtl_on) {
                echo "dir: 'rtl',";
            } ?>
            autocomplete: false,
            pickerPosition: "bottom",
            // hideSource: false,
        });

        $(document).on("keypress", "#offensive_keywords", function (event) {
            if (event.which == 13) event.preventDefault();
        });

        $(".inputtags").tagsinput('items');
        $("#offensive_keywords_block").hide();
        $(".reply_settings_block").hide();

        $(document).on('click', '#delete_offensive_comment', function (event) {
            if (!this.checked) {
                $("#offensive_keywords_block").hide();
            } else {
                $("#offensive_keywords_block").show();
            }
        });

        $(document).on('click', 'input[name="reply_type"]', function (event) {

            let checked_value = $('input[name="reply_type"]:checked').val();

            if (checked_value == 'generic') {

                $(".reply_settings_block").hide();
                $(".generic_message_block").show();
            } else if (checked_value == 'keyword') {

                $(".generic_message_block").hide();
                $(".reply_settings_block").show();
            }
        });

        /* keyword message section start */
        $(document).on('click', '#add_more_keyword_button', function (event) {
            event.preventDefault();

            var content_amount = parseInt($("#content_block").val(), 10);

            if (content_amount < 20) {

                $("#content_block").val(content_amount + 1);

                var current_block = $("#odd_or_even").val();
                var card_class = '';
                var next_block = '';

                if (current_block == 'odd') {
                    card_class = 'card-primary';
                    next_block = 'even';
                } else if (current_block == 'even') {
                    card_class = 'card-info';
                    next_block = 'odd';
                }

                var div_string = '<div class="card ' + card_class + ' single_card">';
                div_string += '<div class="card-header justify-content-between">';
                div_string += '<h4><?php echo $this->lang->line("Keyword"); ?></h4>';
                div_string += '<div>';
                div_string += '<button class="btn btn-outline-secondary remove_div">';
                div_string += '<i class="bx bx-x"></i>&nbsp;';
                div_string += '<?php echo $this->lang->line('Remove'); ?>';
                div_string += '</button>';
                div_string += '</div>';
                div_string += '</div>';
                div_string += '<div class="card-body">';
                div_string += '<div class="form-group">';
                div_string += '<label for="keyword_settings">';
                div_string += '<?php echo $this->lang->line("Keyword")?>';
                div_string += '</label>';
                div_string += '<input name="keyword_settings[]" class="form-control keyword_word_input" type="text">';
                div_string += '</div>';
                div_string += '<div class="form-group">';
                div_string += '<label for="reply_settings">';
                div_string += '<?php echo $this->lang->line("Reply message")?>';
                div_string += '<a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("Spintax"); ?>" data-content="Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}" > <i class="bx bx-info-circle"></i></a>';
                div_string += '</label>';
                div_string += '<textarea name="reply_settings[]" class="form-control" id="reply_settings_' + content_amount + '"></textarea>';
                div_string += '</div>';
                div_string += '</div>';
                div_string += '</div>';
                div_string += '</div>';

                $(".add_more_button_block").before(div_string);
                $("#odd_or_even").val(next_block);

                $("#reply_settings_" + content_amount).emojioneArea({
                    <?php if ($rtl_on) {
                        echo "dir: 'rtl',";
                    } ?>autocomplete: false, pickerPosition: "bottom"
                });
            } else {
                $("#add_more_keyword_button").attr('disabled', 'true');
            }
        });

        $(document).on('click', '.remove_div', function (event) {
            event.preventDefault();

            var parent_div = $(this).parent().parent().parent();
            $(parent_div).remove();

            var content_amount = parseInt($("#content_block").val(), 10);
            $("#content_block").val(content_amount - 1);
            $("#add_more_keyword_button").removeAttr('disabled');
        });
        /* keyword message section end */

        $(document).on('click', '.cancel_template', function (event) {
            event.preventDefault();

            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to cancel this template?"); ?>',
                icon: "warning",
                buttons: true,
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        window.location.href = '<?php echo base_url('gmb/review_replies'); ?>';
                    }
                });
        });


        $(document).on('click', '#create_template', function (event) {
            event.preventDefault();

            $(this).addClass('btn-progress');
            var that = $(this);

            let form_data = new FormData($("#auto_reply_templete_form")[0]);

            $.ajax({
                url: '<?php echo base_url('gmb/save_review_reply'); ?>',
                type: 'POST',
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                data: form_data,
                success: function (response) {
                    $(that).removeClass('btn-progress');
                    if (false === response.status) {
                        if (response.html == 'yes') {
                            var span = document.createElement("span");
                            span.innerHTML = response.message;
                            swal.fire({
                                title: '<?php echo $this->lang->line("Warning!"); ?>',
                                html: span,
                                icon: 'warning'
                            });
                            return;
                        } else {
                            if (response.message) {
                                swal.fire({
                                    title: '<?php echo $this->lang->line("Error!"); ?>',
                                    text: response.message,
                                    icon: 'error'
                                });
                                return;
                            }

                            var error_content = '';
                            if (response.errors) {
                                for (var error_item of Object.values(response.errors)) {
                                    error_content += '<span class="d-block">' + error_item + '</span>';
                                }

                                var span = document.createElement("span");
                                span.innerHTML = error_content;
                                swal.fire({
                                    title: '<?php echo $this->lang->line("Error!"); ?>',
                                    html: span,
                                    icon: 'error'
                                });
                            }
                        }
                    } else if (true === response.status) {
                        if (response.message) {
                            swal.fire({
                                title: '<?php echo $this->lang->line('Success!'); ?>',
                                text: response.message,
                                icon: 'success',
                                buttons: true,
                            })
                                .then((willDelete) => {
                                    if (willDelete.isConfirmed) {
                                        window.location.href = '<?php echo base_url('gmb/review_replies'); ?>';
                                    }
                                });
                        }
                    }
                }
            });
        });
    });
</script>