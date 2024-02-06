<script>var rand_time = "<?php echo time(); ?>";</script>
<script src="<?php echo base_url('n_assets/js/system/instagram/template_manager.js?ver=' . $n_config['theme_version']); ?>"></script>

<script type="text/javascript">
    $(document).ready(function (e) {

        $(".private_reply_postback").select2({
            tags: true,
            width: '100%'
        });

    });

</script>

<?php
if(file_exists(APPPATH.'n_sgp/tools/spintax.php')){
    include(APPPATH.'n_sgp/tools/spintax.php');
}