<script type="text/javascript">
    $('document').ready(function () {

        $("#submit").click(function (e) {
            e.preventDefault();

            $("#msg").removeAttr('class');
            $("#msg").html("");

            var code = $("#code").val();
            var email = $("#email").val();

            if (email == '') {
                $("#email").addClass('is-invalid');
                return false;
            } else {
                $("#email").removeClass('is-invalid');
            }

            if (code == '') {
                $("#code").addClass('is-invalid');
                return false;
            } else {
                $("#code").removeClass('is-invalid');
            }

            $(this).addClass('btn-progress');
            $.ajax({
                context: this,
                type: 'POST',
                url: "<?php echo base_url();?>home/account_activation_action",
                data: {code: code, email: email},
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response == 0) {
                        swal.fire('<?php echo $this->lang->line("Error")?>', '<?php echo $this->lang->line("Account activation code does not match") ?>', 'error');
                    }
                    if (response == 2) {
                        var string = '<div class="alert alert-primary mb-2" role="alert"><div class="d-flex align-items-center"><i class="bx bx-like"></i><span><?php echo $this->lang->line("Congratulations, your account has been activated successfully."); ?></span></div></div>' +
                            '<a href="<?php echo site_url();?>home/login" class="btn btn-outline-primary mr-1 mb-1"><?php echo $this->lang->line("You can login here") ?></a>';
                        $("#recovery_form").slideUp();
                        $("#recovery_form").html(string);
                        $("#recovery_form").slideDown();
                    }
                }
            });

        });
    });
</script>