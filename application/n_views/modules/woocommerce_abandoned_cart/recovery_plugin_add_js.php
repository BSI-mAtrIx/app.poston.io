<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/moment.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/plugins/summernote/summernote-bs4.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<script>
    var base_url = "<?php echo site_url(); ?>";
    $(document).ready(function () {
        'use strict';

        $(".select2").select2({
            dropdownAutoWidth: true,
            width: '100%',

        });
    });
    $("document").ready(function () {

        $(document).on('blur', '#domain_name', function (event) {
            event.preventDefault();
            var ref = $(this).val();
            ref = ref.replace("http://", "");
            ref = ref.replace("https://", "");
            ref = ref.replace(/ /g, "");
            ref = ref.replace(/-/g, "");
            ref = ref.replace(/_/g, "");
            ref = ref.replace(/"/g, "");
            ref = ref.replace(/'/g, "");
            ref = ref.replace(/:/g, "");
            ref = ref.replace(/;/g, "");
            ref = ref.replace(/,/g, "");
            $("#email_subject").val(ref + " - shop");
            ref = ref.toUpperCase();
            $("#reference").val(ref);

        });

        $(document).on('change', '#page', function (event) {
            event.preventDefault();

            var page_id = $(this).val();
            $.ajax({
                type: 'POST',
                url: base_url + "woocommerce_abandoned_cart/get_template_label_dropdown",
                data: {page_id: page_id},
                dataType: 'JSON',
                success: function (response) {
                    // $("#template_id").html(response.template_option);
                    $("#label_ids").html(response.label_option);
                    $("#put_script").html(response.script);
                }

            });
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
                url: base_url + "woocommerce_abandoned_cart/recovery_plugin_add_action",
                data: queryString,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $("#get_button").removeClass('btn-progress');
                    if (response.status == '1') {
                        swal.fire('<?php echo $this->lang->line("Plugin Created"); ?>', response.message, 'success').then((value) => {
                            $('.download').attr('campaign_id', response.id).click();
                        });
                        // $("#get_button").attr('disabled',true);
                    } else swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                }

            });

        }

        $('#download_modal').on('hidden.bs.modal', function (e) {
            window.location.assign('<?php echo base_url("woocommerce_abandoned_cart/recovery_plugin_list") ?>');
        });


    });
</script>

<?php
include(FCPATH . 'application/n_views/modules/woocommerce_abandoned_cart/download_code.php');
include(FCPATH . 'application/n_views/modules/woocommerce_abandoned_cart/style.php');
?>
