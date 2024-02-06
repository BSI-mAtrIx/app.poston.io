<script>
    $("document").ready(function () {
        var base_url = '<?php echo base_url(); ?>';

        $("#right_column .makeScroll").mCustomScrollbar({
            autoHideScrollbar: true,
            theme: "rounded-dark"
        });

        $(document).on('click', '#answer-to-question-link', function (e) {
            e.preventDefault();
            var question_id = $(this).data('question-id'),
                question_text = $(this).data('question-text');
            $('#question-id').val(question_id);
            $('#question-text').val(question_text);

            // Opens up modal
            $('#answer-to-question-modal').modal();
        });

        $(document).on('submit', '#answer-to-question-form', function (e) {
            e.preventDefault();

            // Starts spinner
            $('#answer-to-question-submit').addClass('btn-progress');

            // Gets form data
            var question_id = $('#question-id').val(),
                question_text = $('#question-text').val(),
                answer_to_question_message = $('#answer-to-question-message').val();

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {question_id, question_text, answer_to_question_message},
                url: '<?php echo base_url('gmb/answer_to_question'); ?>',
                success: function (response) {
                    $('#answer-to-question-submit').removeClass('btn-progress');
                    if (false === response.status) {
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
                            swal.fire({title: '<?php echo $this->lang->line("Error!"); ?>', html: span, icon: 'error'});
                        }
                    } else if (true === response.status) {
                        $('#answer-to-question-message').val('');
                        $('#answer-to-question-modal').modal('hide');
                        if (response.message) {
                            swal.fire({
                                title: '<?php echo $this->lang->line("Success!"); ?>',
                                text: response.message,
                                icon: "success",
                                button: '<?php echo $this->lang->line("Ok"); ?>',
                            }).then(() => {
                                $('.xit-spinner').show();
                                setTimeout(function () {
                                    window.location.replace(base_url + 'gmb/question_list');
                                }, 12000);
                            });
                        }
                    }
                },
                error: function (xhr, xhrStatus, xhrError) {
                    $('#answer-to-question-submit').removeClass('btn-progress');
                    if ('string' === typeof xhrError) {
                        swal.fire({
                            title: '<?php echo $this->lang->line('Error!'); ?>',
                            text: xhrError,
                            icon: 'error'
                        });
                    }
                }
            });

        });

        $(document).on('click', '#delete-question-answer-link', function (e) {
            e.preventDefault();

            // Makes reference to current object
            var that = this;

            // Gets form data
            var question_id = $(that).data('question-id');

            swal.fire({
                title: '<?php echo $this->lang->line('Are you sure?'); ?>',
                text: '<?php echo $this->lang->line('The answer will be deleted from your google account'); ?>',
                icon: 'warning',
                buttons: true,
            }).then(yes => {
                if (yes) {
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        data: {question_id},
                        url: '<?php echo base_url('gmb/delete_question_answer'); ?>',
                        success: function (response) {
                            if (false === response.status) {
                                swal.fire({
                                    title: '<?php echo $this->lang->line("Error!"); ?>',
                                    text: response.message,
                                    icon: 'error'
                                });
                                return;
                            } else if (true === response.status) {

                                $(that).remove();
                                $('#question-answer-title').text('<?php echo $this->lang->line('Answer to Question'); ?>');

                                if (response.message) {
                                    swal.fire({
                                        title: '<?php echo $this->lang->line("Success!"); ?>',
                                        text: response.message,
                                        icon: "success",
                                        button: '<?php echo $this->lang->line("Ok"); ?>',
                                    }).then(yes => {
                                        $('.xit-spinner').show();
                                        setTimeout(function () {
                                            window.location.replace(base_url + 'gmb/question_list');
                                        }, 12000);
                                    });

                                }
                            }
                        },
                        error: function (xhr, xhrStatus, xhrError) {
                            if ('string' === typeof xhrError) {
                                swal.fire({
                                    title: '<?php echo $this->lang->line('Error!'); ?>',
                                    text: xhrError,
                                    icon: 'error'
                                });
                            }
                        }
                    });
                }
            });
        });
    });
</script>