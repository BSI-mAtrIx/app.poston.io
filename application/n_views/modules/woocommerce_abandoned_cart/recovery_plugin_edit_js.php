<script>
    var base_url = "<?php echo site_url(); ?>";
    $("document").ready(function () {

        // $('.nav-pills a').on('show.bs.tab', function(){
        //   var targetid=$(this).attr("aria-controls");
        //   $("#"+targetid+" textarea:nth-child(1)").focus();
        // });

        var page_id = '<?php echo $xdata["page_id"]; ?>';
        var id = '<?php echo $xdata["id"]; ?>';
        $.ajax({
            type: 'POST',
            url: base_url + "woocommerce_abandoned_cart/get_template_label_dropdown_edit",
            data: {page_id: page_id, id: id},
            dataType: 'JSON',
            success: function (response) {
                // $("#template_id").html(response.template_option);
                $("#label_ids").html(response.label_option);
                $("#put_script").html(response.script);
            }

        });


        $(document).on('click', '#get_button', get_button);

        function get_button() {

            var page = $("#page").val();
            var domain_name = $("#domain_name").val();
            var reference = $("#reference").val();

            if (page == "") {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please select a page.'); ?>", 'error');
                return false;
            }

            if (domain_name == "") {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please put your domain name.'); ?>", 'error');
                return false;
            }


            if (reference == '') {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please enter an unique reference.'); ?>", 'error');
                return false;
            }


            $('#get_button').addClass('btn-progress');

            var queryString = new FormData($("#plugin_form")[0]);

            $.ajax({
                type: 'POST',
                url: base_url + "woocommerce_abandoned_cart/recovery_plugin_edit_action",
                data: queryString,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $("#get_button").removeClass('btn-progress');
                    if (response.status == '1') {
                        swal.fire('<?php echo $this->lang->line("Plugin Updated"); ?>', response.message, 'success').then((value) => {
                            window.location.assign('<?php echo base_url("woocommerce_abandoned_cart/recovery_plugin_list") ?>');
                        });
                        // $("#get_button").attr('disabled',true);
                    } else swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                }

            });

        }


    });
</script>

<?php include(APPPATH . 'n_views/modules/woocommerce_abandoned_cart/download_code.php'); ?>
<?php include(APPPATH . 'n_views/modules/woocommerce_abandoned_cart/style.php'); ?>
