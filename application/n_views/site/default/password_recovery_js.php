<script type="text/javascript">
    $('document').ready(function () {
        var confirm_match = 0;
        $(".password").keyup(function () {
            var new_pass = $("#new_password").val();
            var conf_pass = $("#new_password_confirm").val();

            if (new_pass == '' || conf_pass == '') {
                return false;
            }

            if (new_pass == conf_pass) {
                confirm_match = 1;
                $("#new_password").removeClass('is-invalid');
                $("#new_password_confirm").removeClass('is-invalid');
            } else {
                confirm_match = 0;
                $("#new_password_confirm").addClass('is-invalid');
            }

        });


        $("#submit").click(function (e) {
            e.preventDefault();

            var is_code = $("#code").val();
            var new_pass = $("#new_password").val();
            var conf_pass = $("#new_password_confirm").val();

            if (is_code == '') {
                $("#code").addClass('is-invalid');
                return false;
            } else {
                $("#code").removeClass('is-invalid');
            }

            if (new_pass == '' || conf_pass == '') {
                $("#new_password").addClass('is-invalid');
                return false;
            } else {
                $("#new_password").removeClass('is-invalid');
            }

            if (new_pass == conf_pass) {
                $("#new_password_confirm").removeClass('is-invalid');
            } else {
                $("#new_password_confirm").addClass('is-invalid');
                return false;
            }

            var code = $("#code").val();
            var newp = $("#new_password").val();
            var conf = $("#new_password_confirm").val();
            $(this).addClass('btn-progress');
            $.ajax({
                context: this,
                type: 'POST',
                url: "<?php echo base_url();?>home/recovery_check",
                data: {code: code, newp: newp, conf: conf},
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response == '0') {
                        swal.fire('<?php echo $this->lang->line("Error")?>', '<?php echo $this->lang->line("Password reset code does not match") ?>', 'error');
                    } else if (response == '1') {
                        swal.fire('<?php echo $this->lang->line("Error")?>', '<?php echo $this->lang->line("Password reset code is expired") ?>', 'error');
                    } else {
                        var string = '<div class="alert alert-primary mb-2" role="alert">' +
                            '<div class="d-flex align-items-center">' +
                            '<i class="bx bx-check-circle"></i>' +
                            '<span><?php echo $this->lang->line("Password has been updated successfully."); ?></span></div></div> ' +
                            '<a href="<?php echo site_url();?>home/login" class="btn btn-primary glow position-relative w-100"><?php echo $this->lang->line("You can login here"); ?><i class="bx bx-right-arrow-alt"></i></a>';

                        $("#recovery_form").slideUp();
                        $("#recovery_form").html(string);
                        $("#recovery_form").slideDown();
                    }
                }
            });

        });
    });
</script>