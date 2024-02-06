<script>

    function search_in_td(obj, td_id) {  // obj = 'this' of jquery, td_id = id of the td
        var filter = $(obj).val().toUpperCase();
        if (filter != "") {
            $('#' + td_id + ' td .text_key').each(function () {
                var content = $(this).text().trim();

                if (content.toUpperCase().indexOf(filter) > -1) {
                    $(this).css('display', 'block');
                    $(this).parent().parent().find('.text_value').css("display", "block");
                    $(this).parent().parent().css('display', 'table-row');
                } else {
                    $(this).parent().parent().css('display', 'none');
                }

            });
        } else {
            $('#' + td_id + ' tbody tr').each(function (index, el) {
                $(this).css("display", "table-row");
            });

        }
    }

    $(document).ready(function () {

        // updating language name
        $(document).on('click', '#update_language_name', function (event) {
            event.preventDefault();

            var base_url = '<?php echo base_url(); ?>';
            var languagename = $("#language_name").val();
            var pre_value = '<?php echo $editable_language; ?>';


            if (languagename == '') {
                var giveAname = "<?php echo $giveAname; ?>";
                swal.fire('<?php echo $this->lang->line("Warning")?>', giveAname, 'warning');
                return false;
            }

            if (languagename === pre_value) {
                swal.fire('<?php echo $this->lang->line("Warning")?>', '<?php echo $this->lang->line("This language already exist, no need to update.") ?>', 'warning');

            } else {
                $.ajax({
                    url: base_url + 'multi_language/updating_language_name',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {languagename: languagename, pre_value: pre_value},
                    success: function (response) {
                        if (response.status == "1") {
                            var name = response.new_name;
                            var currentUrl = base_url + "multi_language/edit_language/" + name + "/main_app";
                            location.assign(currentUrl);

                        } else if (response.status == '3') {
                            swal.fire('<?php echo $this->lang->line("Error") ?>', '<?php echo $this->lang->line("Only characters and underscores are allowed.") ?>', 'error');
                        } else {
                            swal.fire('<?php echo $this->lang->line("Error") ?>', '<?php echo $this->lang->line("This language is already exist, please try with different one.") ?>', 'error');
                        }
                    }
                });
            }
        });


        // showing language files data from directory
        $(document).on('click', '.allFiles', function (event) {
            event.preventDefault();

            // getting which file is clicked
            var fileType = $(this).attr('file_type');
            var languageFieldSelect = $(this).attr('id');
            var languageName = '<?php echo $editable_language; ?>';
            var langname_existance = $("#language_name").val();
            var addonLangName = $(this).attr("folderName");
            var base_url = "<?php echo base_url(); ?>";

            // if the language name filed is empty
            if (languageFieldSelect == "main_app") {
                if (langname_existance == '') {
                    var giveAname = "<?php echo $giveAname; ?>";
                    swal.fire('<?php echo $this->lang->line("Warning")?>', giveAname, 'warning');
                    return false;
                }
            }

            // loading processing img
            var loading = '<br><img src="' + base_url + 'assets/pre-loader/color/Preloader_9.gif" class="center-block" height="30" width="30">';
            $('#response_status').html(loading);

            $.ajax({
                type: 'POST',
                url: base_url + "multi_language/ajax_get_lang_file_data_update",
                dataType: 'JSON',
                data: {fileType: fileType, languageName: languageName, langname_existance: langname_existance},
                success: function (response) {
                    if (response.status == "1") {
                        $('#language_file_modal').modal();
                        $('#languageDataBody').html(response.langForm);
                        $('#response_status').html('');
                        $("#languName").html(languageName);
                        $("#addon_languName").html(addonLangName);

                    } else if (response.status == "3") {
                        swal.fire('<?php echo $this->lang->line("Error") ?>', '<?php echo $this->lang->line("Your given name has not updated, please update the name first.") ?>', 'error');
                    } else {
                        $('#response_status').html(loading);
                    }
                }

            });

        });


        // saving language file with language folder name
        $(document).on('click', '.update_language_button', function (event) {
            event.preventDefault();

            var languageName = $('#language_name').val();

            // if the language name filed is empty
            if (languageName == '') {
                var giveAname = "<?php echo $giveAname; ?>";
                swal.fire('<?php echo $this->lang->line("Warning")?>', giveAname, 'warning');
                return false;
            }

            $('#saving_response').html('');
            $(this).addClass("btn-progress");

            // Generate the language folder name from input
            var folder_name = $("#language_folder_name").val(languageName);
            // detect the file type clicked
            var clickedFile = $("#language_file_id").val();
            var base_url = "<?php echo base_url(); ?>";


            var alldatas = new FormData($("#language_creating_form")[0]);

            $.ajax({
                context: this,
                type: 'POST',
                url: base_url + "multi_language/ajax_updating_lang_file_data",
                data: alldatas,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(this).removeClass("btn-progress");
                    if (response.status == "1") {
                        iziToast.success({title: '', message: response.message, position: 'bottomRight'});
                    } else {
                        iziToast.error({title: '', message: response.message, position: 'bottomRight'});
                    }
                }

            });
        });


    });
</script>