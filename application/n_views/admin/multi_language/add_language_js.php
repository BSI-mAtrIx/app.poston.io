<script>
    var base_url = "<?php echo base_url(); ?>";

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

        // save language name for all
        $(document).on('click', '#save_language_name', function (event) {
            event.preventDefault();
            var languageName = $('#language_name').val();

            // if the language name filed is empty
            if (languageName == '') {
                var giveAname = "<?php echo $giveAname; ?>";
                swal.fire('<?php echo $this->lang->line("Warning")?>', giveAname, 'warning');
                return false;
            }

            $.ajax({
                url: base_url + 'multi_language/save_language_name',
                type: 'POST',
                data: {languageName: languageName},
                success: function (response) {
                    if (response == "1") {
                        swal.fire('<?php echo $this->lang->line("Success")?>', '<?php echo $this->lang->line("Your data has been successfully saved.") ?>', 'success');

                    } else if (response == '3') {
                        swal.fire('<?php echo $this->lang->line("Error") ?>', '<?php echo $this->lang->line("Only characters and underscores are allowed.") ?>', 'error');
                    } else {
                        swal.fire('<?php echo $this->lang->line("Error") ?>', '<?php echo $this->lang->line("Sorry, this language already exists, you can not add this again.") ?>', 'error');
                    }

                }
            });

        });


        // showing language files data from directory
        $(document).on('click', '.language_file', function (event) {
            event.preventDefault();

            var languageFieldSelect = $(this).attr('id');
            var languageName = $.trim($('#language_name').val());
            var fileType = $(this).attr('file_type');
            var base_url = "<?php echo base_url(); ?>";

            // if the language name filed is empty
            if (languageName == '') {
                var giveAname = "<?php echo $giveAname; ?>";
                swal.fire('<?php echo $this->lang->line("Warning")?>', giveAname, 'warning');
                return false;
            }

            // loading processing img
            var loading = '<br><img src="' + base_url + 'assets/pre-loader/color/Preloader_9.gif" class="center-block" height="30" width="30">';
            $('#response_status').html(loading);

            $.ajax({
                type: 'POST',
                url: base_url + "multi_language/ajax_get_language_details",
                data: {fileType: fileType, languageName: languageName},
                dataType: 'JSON',
                success: function (response) {
                    if (response.result == "1") {
                        $('#language_file_modal').modal();
                        $('#languageDataBody').html(response.langForm);
                        $("#language_type_modal").html(fileType);
                        $('#response_status').html('');
                        $("#new_lang_val").html(languageName);

                    } else {
                        var giveAname = "<?php echo $giveAname; ?>";
                        swal.fire('<?php echo $this->lang->line("Warning")?>', giveAname, 'warning');
                    }
                }
            });
        });


        // saving language file with language folder name
        $(document).on('click', '.save_language_button', function (event) {
            event.preventDefault();

            var languageFieldSelect = $(this).attr('id');
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
            var ftype = $("#language_type_modal").html();
            var base_url = "<?php echo base_url(); ?>";

            var alldatas = new FormData($("#language_creating_form")[0]);

            $.ajax({
                context: this,
                type: 'POST',
                url: base_url + "multi_language/ajax_language_file_saving",
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
