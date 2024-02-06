<script>
    $(document).ready(function ($) {
        var base_url = '<?php echo base_url(); ?>';
        $('div.note-group-select-from-files').remove();

        $('textarea').each(function () {
            <?php if($jodit_cg){
            echo "editor = Jodit.make(this, {
                                    disablePlugins: [
                                        'about'
                                    ],
                                    buttons: [
                                        ...Jodit.defaultOptions.buttons,
                                    ],
                                    extraButtons: ext_butt
                });";
        }else{
            echo 'var editor = new Jodit(this);';
        } ?>
        });

        $(document).on('click', '.send_test_mail', function (event) {
            event.preventDefault();
            $("#modal_send_test_email").modal();
        });

        $(document).on('click', '#send_test_email', function (event) {
            event.preventDefault();

            var email = $("#recipient_email").val();
            var subject = $("#subject").val();
            var message = $("#message").val();
            var csrf_token = $("#csrf_token").val();

            if (email == '') {
                $("#recipient_email").addClass('is-invalid');
                return false;
            } else {
                $("#recipient_email").removeClass('is-invalid');
            }

            if (subject == '') {
                $("#subject").addClass('is-invalid');
                return false;
            } else {
                $("#subject").removeClass('is-invalid');
            }

            if (message == '') {
                $("#message").addClass('is-invalid');
                return false;
            } else {
                $("#message").removeClass('is-invalid');
            }

            $(this).addClass('btn-progress');
            $("#show_message").html('');
            $.ajax({
                context: this,
                type: 'POST',
                url: "<?php echo site_url(); ?>admin/send_test_email",
                data: {email: email, message: message, subject: subject, csrf_token: csrf_token},
                success: function (response) {

                    $(this).removeClass('btn-progress');
                    $("#show_message").addClass("alert alert-light");

                    if (response == 1) {

                        $("#show_message").html('<?php echo $this->lang->line("Test email has been sent successfully.");?>');

                    } else {

                        $("#show_message").html(response);

                    }
                }
            });

        });
    });

</script>