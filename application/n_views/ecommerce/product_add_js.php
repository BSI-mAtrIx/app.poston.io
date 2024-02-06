<?php include(APPPATH . 'n_views/ecommerce/product_js.php'); ?>
<?php include(APPPATH . 'n_views/ecommerce/editor_js.php'); ?>

<script>
    $(document).ready(function () {
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

        $('#attribute_ids').on('select2:select', function (e) {
            var id = e.params.data.id;
            $.ajax({
                context: this,
                type: 'POST',
                // dataType:'JSON',
                url: "<?php echo site_url();?>ecommerce/get_attribute_values",
                data: {id: id},
                success: function (response) {
                    $("#attribute_values").append(response);
                }
            });
        });

        $('#attribute_ids').on('select2:unselect', function (e) {
            var id = e.params.data.id;
            $("#attribute_values_" + id).remove();
        });
    });
</script>