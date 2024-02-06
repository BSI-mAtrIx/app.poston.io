<script src="<?php echo base_url(); ?>n_assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<script>
    var base_url = "<?php echo site_url(); ?>";
    $("document").ready(function () {
        $(document).ready(function () {
            'use strict';

            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%',

            });
        });


        $('.color-picker-rgb').colorpicker({
            format: 'hex'
        });

        $("#create_label_custom_plugin,.add_template,.ref_template").css('display', 'none');

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
            ref = ref.toUpperCase();
            $("#reference").val(ref);

        });


        $(document).on('change', '#page', function (event) {
            var page_id = $(this).val();

            $("#loader").removeClass('hidden');
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot_enhancers/get_template_label_dropdown",
                data: {page_id: page_id},
                dataType: 'JSON',
                success: function (response) {

                    if (page_id == "") {
                        $("#create_label_custom_plugin,.add_template,.ref_template").css('display', 'none');
                        $("#create_label_custom_plugin").attr('page_id_for_label', '');
                        $(".add_template").attr('page_id_add_postback', '');
                        $(".ref_template").attr('page_id_refresh_postback', '');
                    } else {
                        $("#create_label_custom_plugin,.add_template,.ref_template").css('display', 'block');
                        $("#create_label_custom_plugin").attr('page_id_for_label', page_id);
                        $(".add_template").attr('page_id_add_postback', page_id);
                        $(".ref_template").attr('page_id_refresh_postback', page_id);
                    }

                    $("#loader").addClass('hidden');
                    $("#template_id").html(response.template_option);
                    $("#label_ids").html(response.label_option);
                    $("#put_script").html(response.script);
                }

            });

        });

        $("#page").val('<?php echo $page_id; ?>').change();


        // create an new label and put inside label list
        $(document).on('click', '#create_label_custom_plugin', function (e) {
            e.preventDefault();

            var page_id = $(this).attr('page_id_for_label');

            swal.fire({
                title: "<?php echo $this->lang->line('Label Name'); ?>",
                input: "text",
                confirmButtonText: "<?php echo $this->lang->line('New Label'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('Cancel'); ?>",
                showCancelButton: true,
            })
                .then((value) => {
                    if (value.isDenied || value.isDismissed) {
                        return;
                    }
                    var label_name = `${value.value}`;
                    if (label_name != "" && label_name != 'null') {
                        $("#save_changes").addClass("btn-progress");
                        $.ajax({
                            context: this,
                            type: 'POST',
                            dataType: 'JSON',
                            url: "<?php echo site_url();?>home/common_create_label_and_assign",
                            data: {page_id: page_id, label_name: label_name},
                            success: function (response) {

                                $("#save_changes").removeClass("btn-progress");

                                if (response.error) {
                                    var span = document.createElement("span");
                                    span.innerHTML = response.error;

                                    swal.fire({
                                        icon: 'error',
                                        title: '<?php echo $this->lang->line('Error'); ?>',
                                        html: span,
                                    });

                                } else {
                                    var newOption = new Option(response.text, response.id, true, true);
                                    $('#label_ids').append(newOption).trigger('change');
                                }
                            }
                        });
                    }
                });
        });

        // ===================== add & refresh postback section ====================

        // getting postback list and making iframe
        $('#add_template_modal').on('shown.bs.modal', function () {
            var page_id = $(".add_template").attr("page_id_add_postback");
            var iframe_link = "<?php echo base_url('messenger_bot/create_new_template/1/');?>" + page_id;
            $(this).find('iframe').attr('src', iframe_link);
        });
        // getting postback list and making iframe

        // add postback template modal
        $(document).on('click', '.add_template', function (e) {
            e.preventDefault();

            var page_id = $(this).attr("page_id_add_postback");
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $("#add_template_modal").modal();
        });

        $(document).on('click', '.ref_template', function (e) {
            e.preventDefault();
            var current_val = $("#template_id").val();
            var page_id = $(this).attr("page_id_refresh_postback");

            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }

            $.ajax({
                type: 'POST',
                url: base_url + "home/common_get_postback",
                data: {page_id: page_id},
                success: function (response) {
                    $("#template_id").html(response).val(current_val);
                    $('#template_id').select2({
                        width: '100%'
                    });
                }
            });
        });

        $('#add_template_modal').on('hidden.bs.modal', function (e) {
            var current_val = $("#template_id").val();
            var page_id = $(".add_template").attr("page_id_add_postback");
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "home/common_get_postback",
                data: {page_id: page_id},
                success: function (response) {
                    $("#template_id").html(response);
                    $('#template_id').select2({
                        width: '100%'
                    });
                }
            });
        });

        // ============================ Add & refresh Postback Section ===============================

        $(document).on('click', '#get_button', get_button);

        function get_button() {

            var page = $("#page").val();
            var domain_name = $("#domain_name").val();
            var template_id = $("#template_id").val();
            var reference = $("#reference").val();
            var logged_in = $("#logged_in").val();
            var logged_out = $("#logged_out").val();
            if (page == "") {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please select a page.'); ?>", 'error');
                return false;
            }

            if (template_id == '') {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please select OPT-IN inbox confirmation message template.'); ?>", 'error');
                return false;
            }

            if (reference == '') {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please enter an reference.'); ?>", 'error');
                return false;
            }


            if (logged_in.length > 80) {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Logged in greeting text can be maximum 80 characters long.') ?>", 'error');
                return false;
            }

            if (logged_out.length > 80) {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Logged out greeting text can be maximum 80 characters long.') ?>", 'error');
                return false;
            }

            $('#get_button').addClass('btn-progress');

            var queryString = new FormData($("#plugin_form")[0]);


            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot_enhancers/customer_chat_add_action",
                data: queryString,
                dataType: 'JSON',
                // async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status == '1') {

                        $("#response").attr('class', 'alert alert-success text-center').html(response.message);
                        $("#get_button").removeClass('btn-progress');
                        $("#get_button").attr('disabled', true);
                        $(".description").text(response.js_code);
                        Prism.highlightElement($('#test')[0]);
                        $("#wp_plugin").attr('href', response.wp_plugin);
                        $("#get_plugin_modal").modal();

                        $(".toolbar-item").find('a').addClass('copy');
                    } else {
                        swal.fire("<?php echo $this->lang->line('Error'); ?>", response.message, 'error');
                        $("#get_button").removeClass('btn-progress');
                    }


                }

            });

        }

        $('#get_plugin_modal').on('hidden.bs.modal', function () {
            window.location.href = base_url + "messenger_bot_enhancers/customer_chat_plugin_list/" + '<?php echo $page_id ?>' + '/1';
        });

        $(document).on('click', '.copy', function (event) {
            event.preventDefault();

            $(this).html('<?php echo $this->lang->line("Copied!"); ?>');
            var that = $(this);

            var text = $(this).parent().parent().parent().find('code').text();
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(text).select();
            document.execCommand("copy");
            $temp.remove();


            // iziToast.success({
            //     title: "",
            //     message: "<?php echo $this->lang->line('Copied to clipboard') ?>",
            // });

            setTimeout(function () {
                $(that).html('<?php echo $this->lang->line("Copy"); ?>');
            }, 2000);

        });


        $(".xscroll1").mCustomScrollbar({
            autoHideScrollbar: true,
            theme: "light-thick",
            axis: "x"
        });


    });
</script>