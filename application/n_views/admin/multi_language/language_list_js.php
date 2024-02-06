<?php
// Retrieve the selected language from session
$selectedlanguage = $this->session->userdata("selected_language");
?>

<script>
    var base_url = "<?php echo base_url(); ?>";
    $(document).ready(function ($) {

        // getting addon language folders to download
        $(document).on('click', '.download_addon', function (event) {
            event.preventDefault();

            var base_url = "<?php echo base_url(); ?>";
            var addon = $(this).attr("addonname");
            var clickedtype = $(this).attr("id");

            $.ajax({
                url: base_url + "multi_language/get_addon_folders_to_download",
                type: 'POST',
                data: {addon: addon},
                success: function (response) {
                    if (response) {
                        $("#language_file_modal").modal();
                        $('#languageDataBody').html(response);
                        $("#addon_names").html(addon);
                        $("#addon_type").html(clickedtype);
                        $(".modal-title").html('<?php echo '<i class="bx bx-save"></i>' . " " . $this->lang->line('Download Language') ?>');
                    } else {
                        $("#addon_names").html('');
                        $("#addon_type").html('');
                    }
                }
            })
        });

        // getting language folders to delete from all
        $(document).on('click', '.delete', function (event) {
            event.preventDefault();

            var base_url = "<?php echo base_url(); ?>";

            $.ajax({
                url: base_url + 'multi_language/get_all_languages_to_delete',
                type: 'POST',
                data: {param1: 'value1'},
                success: function (response) {
                    $("#language_file_modal").modal();
                    $("#languageDataBody").html(response);
                    $(".modal-title").html('<?php echo '<i class="bx bx-trash"></i>' . " " . $this->lang->line('Delete Language') ?>');
                    $("#addon_names").html('');
                    $("#addon_type").html('');

                }
            })
        });


        // deleting the language from all, main,plugin,addons
        $(document).on('click', '.delete_language', function (event) {
            event.preventDefault();
            var langname = $(this).html();
            var selectedLang = <?php echo '"' . $selectedlanguage . '"'; ?>;

            if (langname == 'english') {
                swal.fire('<?php echo $this->lang->line("Error") ?>', '<?php echo $this->lang->line("Sorry, english language can not be deleted.") ?>', 'error');
                return;
            }

            if (langname == selectedLang) {
                swal.fire('<?php echo $this->lang->line("Error") ?>', '<?php echo $this->lang->line("This is your default language, it can not be deleted.") ?>', 'error');
                return;
            }

            var that_parent = $(this).parent().parent().parent().parent();


            swal.fire({
                title: '<?php echo $this->lang->line("Delete Language?"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to delete this language? It will delete all files of this language."); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $.ajax({
                            url: base_url + 'multi_language/delete_language_from_all',
                            type: 'POST',
                            data: {langname: langname},
                            success: function (response) {
                                if (response == '1') {
                                    // swal.fire('<?php echo $this->lang->line("Success")?>', '<?php echo $this->lang->line("Your language file has been successfully deleted.")?>', 'success');
                                    iziToast.success({
                                        title: '',
                                        message: '<?php echo $this->lang->line("Your language file has been successfully deleted.")?>',
                                        position: 'bottomRight'
                                    });
                                    $(that_parent).addClass('d-none');

                                } else {
                                    // swal.fire('<?php echo $this->lang->line("Error")?>', '<?php echo $this->lang->line("Something went wrong, please try again.")?>', 'error');
                                    iziToast.success({
                                        title: '',
                                        message: '<?php echo $this->lang->line("Something went wrong, please try again.")?>',
                                        position: 'bottomRight'
                                    });
                                    $(that_parent).removeClass('d-none');
                                }
                            }
                        })
                    }
                });

        });


        // if delete modal reload the location else no reload
        $('#modal_close').on('click', function (event) {
            event.preventDefault();

            console.log("dsdsdfs");

            var download_modal = $("#addon_type").html();
            if (download_modal == "addons") {
                //no reload
                var tab = $("#addonTab").attr("href");

            } else {
                // if delete modal then do reload
                location.reload();
            }
        });

    });
</script>
