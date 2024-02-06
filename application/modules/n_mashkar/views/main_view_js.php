<script>
    $('document').ready(function () {
        var csrf_token = "<?php echo $this->session->userdata('csrf_token_session'); ?>";

        var base_url = "<?php echo site_url(); ?>";
        var csrf_token = "<?php echo $csrf_token; ?>";

    });
</script>