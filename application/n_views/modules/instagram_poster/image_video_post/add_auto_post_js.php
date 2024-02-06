<script type="text/javascript">
    "use strict";
    var instragram_post_image_upload_limit = "<?php echo isset($image_upload_limit) ? $image_upload_limit : 1; ?>";
    var instragram_post_video_upload_limit = "<?php echo isset($video_upload_limit) ? $video_upload_limit : 100; ?>";
    var ximage_url = [];
    var all_image_url = [<?php echo '"' . implode('","', $all_image_url) . '"' ?>];
    var all_video_url = [<?php echo '"' . implode('","', $all_video_url) . '"' ?>];
</script>


<script src="<?php echo base_url('n_assets/js/system/instagram/posting_common.js?ver=' . $n_config['theme_version']); ?>"></script>
<script src="<?php echo base_url('n_assets/js/system/instagram/posting_add.js?ver=' . $n_config['theme_version']); ?>"></script>
<script>
    $(document).ready(function () {
        $('body').addClass('menu-collapsed');
        $('.brand-logo').removeClass('d-none');
    });
</script>


<?php
if($content_generator){
    include(APPPATH.'modules/n_generator/include/modal_message_universal.php');
}
?>
