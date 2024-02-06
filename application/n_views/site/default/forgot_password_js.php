<script type="text/javascript">
    $('document').ready(function () {
        $("#submit").click(function (e) {
            e.preventDefault();


            var email = $("#email").val();
            if (email == '') {
                $("#email").addClass('is-invalid');
                return false;
            } else {
                $("#email").removeClass('is-invalid');
            }
            $(this).addClass('btn-progress');
            $.ajax({
                context: this,
                type: 'POST',
                url: "<?php echo site_url();?>home/code_genaration",
                data: {email: email},
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response == '0') {
                        swal.fire('<?php echo $this->lang->line("Error") ?>', '<?php echo $this->lang->line("Invalid email or it is not associated with any user") ?>', 'error');
                    } else {
                        var string = '<div class="alert alert-primary mb-2" role="alert"><div class="d-flex align-items-center"><i class="bx bx-like"></i><span><?php echo $this->lang->line("A email containing password reset steps has been sent to your email."); ?></span></div></div>';

                        $("#recovery_form").slideUp();
                        $("#recovery_form").html(string);
                        $("#recovery_form").slideDown();
                    }
                }
            });

        });
    });
</script>