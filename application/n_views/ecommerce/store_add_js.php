<script>
    var base_url = "<?php echo site_url(); ?>";
    var action_url = base_url + "ecommerce/add_store_action";
    var success_title = '<?php echo $this->lang->line("Store Created"); ?>';
    $("document").ready(function () {

        $(document).on('blur', '#store_name', function (event) {
            event.preventDefault();
            var ref = $(this).val();
            $("#email_subject").val(ref + " | <?php echo $this->lang->line('Cart Update'); ?>");

        });

        $(document).on('change', '#page', function (event) {
            event.preventDefault();

            var page_id = $(this).val();
            $.ajax({
                type: 'POST',
                url: base_url + "ecommerce/get_template_label_dropdown",
                data: {page_id: page_id},
                dataType: 'JSON',
                success: function (response) {
                    // $("#template_id").html(response.template_option);
                    $("#label_ids").html(response.label_option);
                    $("#put_script").html(response.script);
                }

            });
        });

        $(document).on('click', '#get_button', function (e) {
            get_button();
        });


    });
</script>
<?php include(APPPATH . 'n_views/ecommerce/store_js.php'); ?>