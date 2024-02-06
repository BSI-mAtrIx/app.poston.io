<script>
    var base_url = "<?php echo site_url(); ?>";
    var action_url = base_url + "ecommerce/reminder_settings_action";
    var success_title = '<?php echo $this->lang->line("Settings Updated"); ?>';
    $("document").ready(function () {
        $(document).on('click', '#get_button2', function (e) {
            get_button2();
        });
    });

    function reset_values() {
        var mes = '';
        mes = "<?php echo $this->lang->line('Do you really want restore default settings?');?>";
        swal.fire({
            title: "<?php echo $this->lang->line("Restore Default Settings");?>",
            text: mes,
            icon: "warning",
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    window.location.assign('<?php echo base_url("ecommerce/reset_reminder/" . $xdata['id']);?>');
                }
            });
    }

    $('textarea.jodit').each(function () {
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
</script>
<?php include(APPPATH . 'n_views/ecommerce/store_js.php'); ?>