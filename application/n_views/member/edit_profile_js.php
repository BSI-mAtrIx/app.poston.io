<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
    var user_id = "<?php echo $this->user_id; ?>";
    $(document).ready(function () {
        $(document).on('click', '.delete_full_access', function () {
            $("#delete_dialog").modal();
        });

        $(document).on('click', '.cancel_button', function () {
            $("#delete_dialog").modal('hide');
        });

        $(document).on('click', '.delete_confirm', function () {
            $("#message_div").attr("class", "text-center").html('<img class="center-block" src="' + base_url + 'assets/pre-loader/color/Preloader_9.gif" height="30" width="30" alt="Processing..."><br/>');
            $("#delete_dialog").modal();
            var csrf_token = $(this).attr('csrf_token');
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "<?php echo site_url();?>home/user_delete_action/" + user_id,
                data: {csrf_token: csrf_token},
                success: function (response) {
                    if (response.status == 1) {
                        $("#delete_dialog").modal('hide');
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
                            location.reload();
                        });
                    } else {
                        $('#message_div').attr("class", "alert alert-danger text-center").css("margin-top", "20px").html(response.message);
                        $(".modal-footer").hide();
                    }
                }
            });
        });

        $('#delete_dialog').on('hidden.bs.modal', function () {
            location.reload();
        });
    });


</script>
<?php
$file_location_epayco = APPPATH.'modules/n_epayco/lib/profile_info_js.php';
if(file_exists($file_location_epayco)){
    include($file_location_epayco);
}