<link rel="stylesheet" type="text/css"
      href="<?php echo base_url(); ?>n_assets/js/spectrum/spectrum.min.css?ver=<?php echo $n_config['theme_version']; ?>"/>
<script src="<?php echo base_url(); ?>n_assets/js/spectrum/spectrum.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<script>
    $('.spectrum').spectrum();

    $(".select2_token").select2({
        tags: true,
        tokenSeparators: [',', ' '],
        width: '100%',
        multiple: true,
    });
</script>