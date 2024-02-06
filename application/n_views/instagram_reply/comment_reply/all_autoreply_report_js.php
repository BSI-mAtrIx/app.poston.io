<?php
$Youdidntprovideallinformation = $this->lang->line("you didn't provide all information.");
$Pleaseprovidepostid = $this->lang->line("please provide post id.");
$Youdidntselectanyoption = $this->lang->line("you didn\'t select any option.");
$AlreadyEnabled = $this->lang->line("already enabled");
$ThispostIDisnotfoundindatabaseorthispostIDisnotassociatedwiththepageyouareworking = $this->lang->line("This post ID is not found in database or this post ID is not associated with the page you are working.");
$EnableAutoReply = $this->lang->line("enable auto reply");
$areyousure = $this->lang->line("are you sure");
$disablebot = $this->lang->line("Disable reply");
$enablebot = $this->lang->line("Enable reply");
$restart_bot = $this->lang->line("Re-start Reply");
?>


<?php include("application/n_views/instagram_reply/comment_reply/comment_reply_js.php"); ?>

<script type="text/javascript">
    $("document").ready(function () {
        var base_url = "<?php echo base_url(); ?>";

        $('.modal').on("hidden.bs.modal", function (e) {
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
            }
        });

        $(document).on('change', '#switch_media', function (event) {
            event.preventDefault();
            var switch_media_type = $('input[name=switch_media]:checked').val();
            if (typeof (switch_media_type) == 'undefined') {
                switch_media_type = 'ig';
            }

            $.ajax({
                url: base_url + 'home/switch_to_media',
                type: 'POST',
                data: {media_type: switch_media_type},
                success: function (response) {
                    if (switch_media_type == 'fb') {
                        window.location.assign('<?php echo base_url('comment_automation/index'); ?>');
                    }

                    if (switch_media_type == 'ig') {
                        window.location.assign('<?php echo base_url('instagram_reply/get_account_lists'); ?>');

                    }
                }
            });
        });

        $(document).on('click', '.add_template', function (e) {
            e.preventDefault();
            var current_id = $(this).prev().prev().attr('id');
            var current_val = $(this).prev().prev().val();
            var page_id = get_page_id();
            if (page_id == "") {
                swal('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $("#add_template_modal").attr("current_id", current_id);
            $("#add_template_modal").attr("current_val", current_val);
            $("#add_template_modal").modal();
        });

        $(document).on('click', '.ref_template', function (e) {
            e.preventDefault();
            var current_val = $(this).prev().prev().prev().val();
            var current_id = $(this).prev().prev().prev().attr('id');
            var page_id = get_page_id();
            if (page_id == "") {
                swal('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "instagram_reply/get_private_reply_postbacks",
                data: {page_table_ids: page_id},
                dataType: 'JSON',
                success: function (response) {
                    $("#" + current_id).html(response.options).val(current_val);
                }
            });
        });

        $('#add_template_modal').on('hidden.bs.modal', function (e) {
            var current_id = $("#add_template_modal").attr("current_id");
            var current_val = $("#add_template_modal").attr("current_val");
            var page_id = get_page_id();
            if (page_id == "") {
                swal('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "instagram_reply/get_private_reply_postbacks",
                data: {page_table_ids: page_id, is_from_add_button: '1'},
                dataType: 'JSON',
                success: function (response) {
                    $("#" + current_id).html(response.options);
                }
            });
        });

        // getting postback list and making iframe
        $('#add_template_modal').on('shown.bs.modal', function () {
            var page_id = get_page_id();
            var rand_time = "<?php echo time(); ?>";
            var media_type = "ig";
            var iframe_link = "<?php echo base_url('messenger_bot/create_new_template/1/');?>" + page_id + "/0/" + media_type + "?lev=" + rand_time;
            $(this).find('iframe').attr('src', iframe_link);
        });
        // getting postback list and making iframe

    });

    function get_page_id() {
        var page_id = $("#dynamic_page_id").val();
        return page_id;
    }
</script>
