<!-- BEGIN: Page Vendor JS-->
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<!-- END: Page Vendor JS-->

<script>
    $(document).ready(function () {
        // form repeater jquery
        $('.repeater-default').repeater({
            show: function () {
                $(this).slideDown();
                $(this).find('textarea').each(function () {
                    <?php if($jodit_cg){
                    echo "editor = Jodit.make(this, {
                                    disablePlugins: [
                                        'about'
                                    ],
                                    buttons: [
                                        ...Jodit.defaultOptions.buttons,
                                    ],
                                    extraButtons: ext_butt
                });";
                }else{
                    echo 'var editor = new Jodit(this);';
                } ?>
                });
            },
            hide: function (deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            }
        });

        $('textarea').each(function () {
            <?php if($jodit_cg){
            echo "editor = Jodit.make(this, {
                                    disablePlugins: [
                                        'about'
                                    ],
                                    buttons: [
                                        ...Jodit.defaultOptions.buttons,
                                    ],
                                    extraButtons: ext_butt
                });";
        }else{
            echo 'var editor = new Jodit(this);';
        } ?>
        });

    });

</script>