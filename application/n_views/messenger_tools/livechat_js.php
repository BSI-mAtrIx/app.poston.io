<script>
    $(document).ready(function () {

        var base_url = "<?php echo base_url(); ?>";
        setTimeout(function () {
            $('#dynamic_field_modal').modal('show');
        }, 500);

        $('#submit').click(function (e) {
            e.preventDefault();
            var page_id = $('#page_id').val();

            if (page_id == '') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Please select a Facebook page / Instagram account"); ?>', 'warning');
                return false;
            } else {
                var exp = page_id.split("-");
                var page_auto_id = 0;
                var social_media = 'fb';
                if (typeof (exp[0]) !== 'undefined') page_auto_id = exp[0];
                if (typeof (exp[1]) !== 'undefined') social_media = exp[1];

                var link = base_url + "message_manager/message_dashboard/" + page_auto_id;
                if (social_media == 'ig') link = base_url + "message_manager/instagram_message_dashboard/" + page_auto_id;
                window.open(link, '_blank').focus();
            }

        });

        $('#dynamic_field_modal').on("hidden.bs.modal", function (e) {
            window.history.back();
        });


    });
</script>