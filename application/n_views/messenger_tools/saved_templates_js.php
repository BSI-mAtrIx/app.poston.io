<script type="text/javascript">
    $(document).ready(function () {
        // setTimeout(function(){ $("#collapse_me_plz").click();}, 100);
        $("#select2").select2();
        $(document).on('click', '#cancel_bot_submit', function (e) {
            e.preventDefault();
            $("#export_bot_modal").modal('hide');
        });
        $(document).on('click', '#cancel_bot_submit2', function (e) {
            e.preventDefault();
            $("#edit_export_bot_modal").modal('hide');
        });
        $('[data-toggle="tooltip"]').tooltip()
        //$("#allowed_package_ids").select2({ width: "100%" });

        $(document).on('click', '.export_bot', function (e) {
            e.preventDefault();
            var table_id = $(this).attr('table_id');
            // $("#export_id").val(table_id);

            $('#allowed_package_ids').val(null).trigger('change');
            $("#template_name").val('');
            $("#template_description").val('');
            $("#template_preview_image").val('');
            $("#only_me_input").prop("checked", true);
            $("#other_user_input").prop("checked", false);
            $("#allowed_package_ids_con").addClass('hidden')

            $("#export_bot_modal").modal();
        });

        $(document).on('change', 'input[name=template_access]', function () {
            var template_access = $(this).val();
            if (template_access == 'private') $("#allowed_package_ids_con").addClass('hidden');
            else $("#allowed_package_ids_con").removeClass('hidden');
        });


        $(document).on('change', 'input[name=template_access2]', function () {
            var template_access = $(this).val();
            if (template_access == 'private') $("#allowed_package_ids_con2").addClass('hidden');
            else $("#allowed_package_ids_con2").removeClass('hidden');
        });

        $("#json_upload").uploadFile({
            url: base_url + "messenger_bot/upload_json_template",
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            fileName: "myfile",
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".json",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('messenger_bot/upload_json_template_delete');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#json_upload_input").val('');
                        $(".type1,.type2").show();
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = data;
                $("#json_upload_input").val(data_modified);
                $(".type1,.type2").hide();
            }
        });


        var user_id = "<?php echo $this->session->userdata('user_id'); ?>";
        var image_upload_limit = "<?php echo $image_upload_limit; ?>";
        $("#template_preview_image_div").uploadFile({
            url: base_url + "messenger_bot/upload_image_only",
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            fileName: "myfile",
            maxFileSize: image_upload_limit * 1024 * 1024,
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg,.JPEG,.JPG,.PNG,.gif,.GIF",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('messenger_bot/delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#template_preview_image").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload/image/" + user_id + "/" + data;
                $("#template_preview_image").val(data_modified);
            }
        });

        $(document).on('click', '.load_preview_modal', function (e) {
            e.preventDefault();
            var item_type = $(this).attr('item_type');
            var file_path = $(this).parent().next().val();
            var user_id = "<?php echo $this->user_id; ?>";

            var res = file_path.match(/http/g);
            if (file_path != '' && res === null)
                file_path = base_url + "upload/image/" + user_id + "/" + file_path;

            $("#preview_text_field").val(file_path);
            if (item_type == 'image') {
                $("#modal_preview_image").attr('src', file_path);
                $("#image_preview_div_modal").show();
                $("#video_preview_div_modal").hide();
                $("#audio_preview_div_modal").hide();

            }
            $("#modal_for_preview").modal();
        });

        $(document).on('click', '.load_preview_modal_edit', function (e) {
            e.preventDefault();
            var item_type = $(this).attr('item_type');
            var file_path = $(this).parent().next().val();
            var user_id = "<?php echo $this->user_id; ?>";

            var res = file_path.match(/http/g);
            if (file_path != '' && res === null)
                file_path = base_url + "upload/image/" + user_id + "/" + file_path;

            $("#preview_text_field").val(file_path);
            if (item_type == 'image') {
                $("#modal_preview_image").attr('src', file_path);
                $("#image_preview_div_modal").show();
                $("#video_preview_div_modal").hide();
                $("#audio_preview_div_modal").hide();

            }
            $("#modal_for_preview").modal();
        });

        $(document).on('click', '.export_bot_edit', function (e) {
            e.preventDefault();
            var table_id = $(this).attr('table_id');
            $("#edit_export_bot_modal").modal();

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>messenger_bot/get_bot_template_form",
                data: {table_id: table_id},
                success: function (response) {
                    $('#edit_export_bot_modal_body').html(response);
                }
            });
        });


        $(document).on('click', '#export_bot_submit', function (e) {
            e.preventDefault();
            var template_name = $("#template_name").val();
            var template_access = $('input[name=template_access]:checked').val();
            var allowed_package_ids = $("#allowed_package_ids").val();
            var bot_category = $("#bot_category").val();
            var filename = $("#json_upload_input").val();

            if (template_name == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please provide template name.');?>", 'warning');
                return;
            }

            if (bot_category == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please select template category.');?>", 'warning');
                return;
            }

            if (filename == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Upload your template json file.');?>", 'warning');
                return;
            }

            if (template_access == "public" && allowed_package_ids == null) {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('You must choose user packages to give them template access.');?>", 'warning');
                return;
            }

            $(this).addClass('btn-progress');
            var queryString = new FormData($("#export_bot_form")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot/save_messenger_template_info",
                dataType: 'JSON',
                data: queryString,
                cache: false,
                contentType: false,
                processData: false,
                context: this,
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    var report_link = base_url + 'messenger_bot/saved_templates';
                    var success_message = response.message;
                    var span = document.createElement("span");
                    span.innerHTML = success_message;
                    swal.fire({
                        title: '<?php echo $this->lang->line("Template Upload Status"); ?>',
                        html: span,
                        icon: 'success'
                    }).then((value) => {
                        location.reload();
                    });
                }
            });

        });


        $(document).on('click', '#update_bot_submit', function (e) {
            e.preventDefault();
            var template_name = $("#template_name2").val();
            var template_access = $('input[name=template_access2]:checked').val();
            var allowed_package_ids = $("#allowed_package_ids2").val();
            var bot_category = $("#bot_category2").val();
            var filename = $("#json_upload_input_edit").val();

            if (template_name == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please provide template name.');?>", 'warning');
                return;
            }

            if (bot_category == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please select template category.');?>", 'warning');
                return;
            }

            if (template_access == "public" && allowed_package_ids == null) {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('You must choose user packages to give them template access.');?>", 'warning');
                return;
            }

            $(this).addClass('btn-progress');
            var queryString = new FormData($("#export_bot_form_edit")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot/update_messenger_template_info",
                dataType: 'JSON',
                data: queryString,
                cache: false,
                contentType: false,
                processData: false,
                context: this,
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    var report_link = base_url + 'messenger_bot/saved_templates';
                    var success_message = response.message;
                    var span = document.createElement("span");
                    span.innerHTML = success_message;
                    swal.fire({
                        title: '<?php echo $this->lang->line("Template Upload Status"); ?>',
                        html: span,
                        icon: 'success'
                    }).then((value) => {
                        location.reload();
                    });
                }
            });

        });

        $(document).on('click', '.install_template', function (event) {
            event.preventDefault();
            var template_id = $(this).attr("current_template_id");
            var media_type = $(this).attr("media_type");
            $("#template_id").val(template_id)
            $("#media_type").val(media_type)
            $("#install_template_modal").modal();

        });


        $(document).on('click', '.delete_template_category', function (e) {
            e.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Do you want to delete this category?"); ?>',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var table_id = $(this).attr('cat_id');
                        var that = $(this);
                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo base_url("messenger_bot/delete_template_category")?>",
                            data: {table_id: table_id},
                            success: function (response) {
                                if (response == '1') {
                                    swal.fire({
                                        title: 'Success',
                                        text: '<?php echo $this->lang->line('Category has been deleted successfully.'); ?>',
                                        icon: 'success'
                                    }).then((value) => {
                                        window.location.href = base_url + "messenger_bot/saved_templates";
                                    });
                                } else {
                                    iziToast.error({
                                        title: '',
                                        message: '<?php echo $this->lang->line('Something went wrong, please try once again.'); ?>',
                                        position: 'bottomRight',
                                        timeout: 3000
                                    });
                                }

                                // setTimeout(function(){ location.reload(); }, 3000);
                            }
                        });
                    }
                });
        });


        $(document).on('click', '.install_template_action', function (e) {
            e.preventDefault();
            var template_id = $("#template_id").val();
            var page_id = $("#page_id").val();
            var media_type = $("#media_type").val();

            if (template_id == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('You must select a template or upload one.');?>", 'warning');
                return;
            }

            $(this).addClass('btn-progress');

            var queryString = new FormData($("#install_template_form")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot/import_bot_check",
                dataType: 'JSON',
                data: {import_id: page_id, template_id: template_id, json_upload_input: "", media_type: media_type},
                context: this,
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response.status == '1') {
                        // var json_upload_input=response.json_upload_input;
                        swal.fire({
                            title: '<?php echo $this->lang->line("Warning!"); ?>',
                            text: response.message,
                            icon: 'warning',
                            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                            showCancelButton: true,
                            dangerMode: true,
                        }).then((willDelete) => {
                            if (willDelete.isDenied || willDelete.isDismissed) {
                                return;
                            }
                            if (willDelete.isConfirmed) {
                                $(this).addClass('btn-progress');
                                $.ajax({
                                    context: this,
                                    type: 'POST',
                                    url: "<?php echo site_url();?>messenger_bot/import_bot",
                                    // dataType: 'json',
                                    data: {
                                        json_upload_input: '',
                                        page_id: response.page_id,
                                        template_id: response.template_id,
                                        media_type: response.media_type
                                    },
                                    success: function (response2) {
                                        $(this).removeClass('btn-progress');
                                        var success_message = response2;
                                        var span = document.createElement("span");
                                        span.innerHTML = success_message;
                                        swal.fire({
                                            title: '<?php echo $this->lang->line("Import Status"); ?>',
                                            html: span,
                                            icon: 'success'
                                        }).then((value) => {
                                            location.reload();
                                        });
                                    }
                                });
                            }
                        });
                    } else {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }
                }
            });
        });

        $(document).on('click', '.install_template', function (event) {
            event.preventDefault();
            var page_id = $("#page_id").val();
            var template_id = $("#installed_template_id").val();

            $.ajax({
                url: base_url + 'messenger_bot/import_bot',
                type: 'POST',
                data: {page_id: page_id, template_id: template_id},
                success: function (response) {

                }
            })

        });

        $('#export_bot_modal').on('shown.bs.modal', function () {
            $(document).off('focusin.modal');
        });

        // create an new category and put inside category list
        $(document).on('click', '#create_category', function (e) {
            e.preventDefault();

            swal.fire({
                title: "<?php echo $this->lang->line('Category Name'); ?>",
                input: "text",
                confirmButtonText: "<?php echo $this->lang->line('New Category'); ?>",
            })
                .then((value) => {
                    var category_name = `${value.value}`;
                    if (category_name != "" && category_name != 'null') {
                        $("#save_changes").addClass("btn-progress");
                        $.ajax({
                            context: this,
                            type: 'POST',
                            dataType: 'JSON',
                            url: "<?php echo site_url();?>messenger_bot/add_template_Category",
                            data: {category_name: category_name},
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
                                    $('#bot_category').append(newOption).trigger('change');
                                }
                            }
                        });
                    }
                });

        });


        // create an new group and put inside group list
        $(document).on('click', '#create_category2', function (e) {
            e.preventDefault();

            swal.fire({
                title: "<?php echo $this->lang->line('Category Name'); ?>",
                input: "text",
                confirmButtonText: "<?php echo $this->lang->line('New Category'); ?>",
            })
                .then((value) => {
                    var category_name = `${value.value}`;
                    if (category_name != "" && category_name != 'null') {
                        $("#save_changes").addClass("btn-progress");
                        $.ajax({
                            context: this,
                            type: 'POST',
                            dataType: 'JSON',
                            url: "<?php echo site_url();?>messenger_bot/add_template_Category",
                            data: {category_name: category_name},
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
                                    $('#bot_category2').append(newOption).trigger('change');
                                }
                            }
                        });
                    }
                });

        });

        $(document).on('click', '.delete_template', function (e) {
            e.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Warning!"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to delete this template?"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isDenied || willDelete.isDismissed) {
                        return;
                    }
                    if (willDelete.isConfirmed) {
                        var base_url = '<?php echo site_url();?>';
                        $(this).addClass('btn-progress');
                        $(this).removeClass('btn-circle');

                        var id = $(this).attr('table_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>messenger_bot/delete_template",
                            dataType: 'json',
                            data: {id: id},
                            context: this,
                            success: function (response) {
                                $(this).removeClass('btn-progress');
                                $(this).addClass('btn-circle');
                                var report_link = base_url + 'messenger_bot/saved_templates';
                                if (response == '1') {
                                    swal.fire('<?php echo $this->lang->line("Success"); ?>', '<?php echo $this->lang->line("Template has been deleted successfully."); ?>', 'success').then((value) => {
                                        window.location.href = report_link;
                                    });

                                } else {
                                    iziToast.error({
                                        title: '',
                                        message: '<?php echo $this->lang->line("Something went wrong."); ?>',
                                        position: 'bottomRight'
                                    });
                                }
                            }
                        });
                    }
                });


        });


    });
</script>