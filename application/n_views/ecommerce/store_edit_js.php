<?php include(APPPATH . 'n_views/ecommerce/store_js.php'); ?>
<script>
    var base_url = "<?php echo site_url(); ?>";
    var action_url = base_url + "ecommerce/edit_store_action";
    var success_title = '<?php echo $this->lang->line("Store Updated"); ?>';

    $("document").ready(function () {


        $(document).on('blur', '#store_name', function (event) {
            event.preventDefault();
            var ref = $(this).val();
            $("#email_subject").val(ref + " | <?php echo $this->lang->line('Cart Update'); ?>");

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

        var page_id = '<?php echo $xdata["page_id"]; ?>';
        var id = '<?php echo $xdata["id"]; ?>';
        $.ajax({
            type: 'POST',
            url: base_url + "ecommerce/get_template_label_dropdown_edit",
            data: {page_id: page_id, id: id},
            dataType: 'JSON',
            success: function (response) {
                // $("#template_id").html(response.template_option);
                $("#label_ids").html(response.label_option);
                $("#put_script").html(response.script);
            }

        });

        $(document).on('click', '#get_button', function (e) {
            get_button();
        });

        $(document).on('click', '.img_preview', function (e) {
            var src = $(this).attr('data-src');
            $('#preview_modal .modal-body').html('');
            var img = "<img src='" + base_url + "upload/ecommerce/" + src + "' class='img-fluid img-thumbnail'>";
            $('#preview_modal .modal-body').html(img);
            $("#preview_modal").modal();
        });


    });
</script>