<script>
    $("#instagram_menu").addClass('active');


    $('.update_your_account').click(function () {
        var base_url = '<?php echo site_url();?>';
        var id = this.getAttribute('data-id');
        var alert_id = "alert_" + id;
        $(".update_your_account").addClass('disabled');

        var loading = '<img src="' + base_url + 'assets/pre-loader/custom.gif" class="center-block">';
        $("#" + alert_id).removeClass("alert-success");
        $("#" + alert_id).show().html(loading);
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url();?>n_igstats/update_your_account_info",
            data: {
                id: id,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',

            },
            dataType: 'JSON',
            success: function (response) {
                $("#" + alert_id).addClass("alert-success");
                $("#" + alert_id).show().html(response.message);
                // alert(response.message);
                alertify.alert('Result', response.message, function () {
                    location.reload();
                });
            }
        });
    });


</script>