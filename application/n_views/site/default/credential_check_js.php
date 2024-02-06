<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '#submit', function (e) {
            e.preventDefault();
            var purchase_code = $("#purchase_code").val().trim();
            if (purchase_code == '') {
                $("#purchase_code").addClass('is-invalid');
                return false;
            } else {
                $("#purchase_code").removeClass('is-invalid');
            }

            var domain_name = "<?php echo base_url(); ?>";

            $(this).addClass("btn-progress");
            $.ajax({
                context: this,
                type: "POST",
                url: "<?php echo site_url('home/credential_check_action'); ?>",
                data: {domain_name: domain_name, purchase_code: purchase_code},
                dataType: 'JSON',
                // async: false,
                success: function (response) {
                    $(this).removeClass("btn-progress");
                    if (response == "success") {
                        var link = "<?php echo base_url('home/login'); ?>";
                        window.location.assign(link);
                    } else {
                        var success_message = response.reason;
                        var span = document.createElement("span");
                        span.innerHTML = success_message;
                        swal.fire({title: '<?php echo $this->lang->line("Error"); ?>', html: span, icon: 'error'});
                    }
                }
            });


        });
    });
</script>