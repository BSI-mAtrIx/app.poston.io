<?php
include(FCPATH . 'application/n_views/include/upload_js.php');
?>

<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/forms/select/select2.full.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/moment.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script type="text/javascript"
        src="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.print.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/pdfmake.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/vfs_fonts.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/plugins/summernote/summernote-bs4.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<script>
    $(document.body).on('click', '.get_js_embed', function (event) {
        event.preventDefault();

        var embed_id = $(this).attr('embed_id');
        var form_type = $(this).attr('form_type');

        var areWeUsingScroll = false;
        //TODO: areWeUsingScroll


        $.ajax({
            url: '<?php echo base_url('email_optin_form_builder/embeded_js_code') ?>',
            type: 'POST',
            dataType: 'JSON',
            data: {embed_id: embed_id, form_type: form_type},
            success: function (response) {
                if (response) {
                    $("#test").text(response.str1);
                    $("#get_embed_modal").modal();
                    Prism.highlightAll($('#test'));

                    $("#mme").text(response.str2);
                    $("#readMeText").text(response.read_me_text);
                    $(".toolbar-item").find('a').addClass('copy');
                } else {
                    swal.fire('<?php echo $this->lang->line("Error"); ?>', '<?php echo $this->lang->line("Something went wrong"); ?>', 'error');
                }


            }

        });

    });

    $(document).on("click", ".copy", function (event) {
        event.preventDefault();

        $(this).html('<?php echo $this->lang->line("Copied!"); ?>');
        var that = $(this);

        var text = $(this).parent().parent().parent().find('code').text();
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(text).select();
        document.execCommand("copy");
        $temp.remove();

        setTimeout(function () {
            $(that).html('<?php echo $this->lang->line("Copy"); ?>');
        }, 2000);

    });


    $(document).ready(function () {

        var data_table = $('#optin-datatable').DataTable({

            processing: true,
            serverSide: true,
            order: [[0, "desc"]],
            pageLength: 10,
            ajax: {
                url: '<?= base_url('email_optin_form_builder/form_lists_data') ?>',
                type: 'POST',
                dataSrc: function (json) {

                    //$(".table-responsive").niceScroll();
                    //TODO: niceScroll
                    return json.data;
                },
            },

            columns: [
                {data: 'id'},
                {data: 'form_name'},
                {data: 'form_position'},
                {data: 'interval_time'},
                {data: 'actions'},
                {data: 'contact_group'},
                {data: 'inserted_at'},

            ],

            language: {

                url: "<?= base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
            },

            columnDefs: [
                {
                    targets: [0],
                    visible: false
                },

                {"className": "text-center", "targets": [2, 3, 4, 6]},
                {"sortable": false, "targets": [1, 2, 4, 6]},
                {
                    targets: [4],
                    "render": function (data, type, row) {
                        data = data.replaceAll('fas fa-code', 'bx bx-code');
                        data = data.replaceAll('fas fa-edit', 'bx bx-edit');
                        data = data.replaceAll('fa fa-edit', 'bx bx-edit');
                        data = data.replaceAll('fa  fa-edit', 'bx bx-edit');
                        data = data.replaceAll('far fa-copy', 'bx bx-copy');
                        data = data.replaceAll('fa fa-trash', 'bx bx-trash');
                        data = data.replaceAll('fas fa-trash', 'bx bx-trash');
                        data = data.replaceAll('fa fa-eye', 'bx bxs-show');
                        data = data.replaceAll('fas fa-eye', 'bx bxs-show');
                        data = data.replaceAll('fas fa-trash-alt', 'bx bx-trash');
                        data = data.replaceAll('fa fa-wordpress', 'bx bxl-wordpress');
                        data = data.replaceAll('fa fa-briefcase', 'bx bx-briefcase');
                        data = data.replaceAll('fab fa-wpforms', 'bx bx-news');
                        data = data.replaceAll('fas fa-file-export', 'bx bx-export');
                        data = data.replaceAll('fa fa-comment', 'bx bx-comment');
                        data = data.replaceAll('fa fa-user', 'bx bx-user');
                        data = data.replaceAll('fa fa-refresh', 'bx bx-refresh');
                        data = data.replaceAll('fa fa-plus-circle', 'bx bx-plus-circle');
                        data = data.replaceAll('fas fa-comments', 'bx bx-comment');
                        data = data.replaceAll('fa fa-hand-o-right', 'bx bx-link-external');
                        data = data.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
                        data = data.replaceAll('fas fa-exchange-alt', 'bx bx-repost');
                        data = data.replaceAll('fa fa-sync-alt', 'bx bx-sync');
                        data = data.replaceAll('fas fa-key', 'bx bx-key');
                        data = data.replaceAll('fas fa-bolt', 'bx bxs-bolt');
                        data = data.replaceAll('fas fa-clone', 'bx bxs-copy-alt');
                        data = data.replaceAll('fas fa-receipt', 'bx bx-receipt');
                        data = data.replaceAll('fa fa-paper-plane', 'bx bx-paper-plane');
                        data = data.replaceAll('fa fa-send', 'bx bx-send');

                        return data;
                    }
                },
            ],

            dom: '<"top"f>rt<"bottom"lip><"clear">',

        })


        // Displays form details

        var table1 = '';
        var perscroll1;

        $(document).on('keyup', '#searching', function (event) {

            event.preventDefault();
            table1.draw();

        });

        // Attempts to delete form

        $(document).on('click', '#delete-optin-form', function (e) {
            e.preventDefault()

            // Grabs form ID
            var form_id = $(this).data('form-id')

            swal.fire({

                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: '<?php echo $this->lang->line("Once deleted, you will not be able to recover this form!"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,

            }).then((yes) => {

                if (yes) {

                    $.ajax({

                        type: 'POST',

                        url: '<?= base_url('email_optin_form_builder/delete_form_data') ?>',

                        dataType: 'JSON',

                        data: {form_id},

                        success: function (response) {

                            if (response) {
                                if (response.success === true) {

                                    // Reloads datatable
                                    data_table.ajax.reload()

                                    // Displays success message
                                    iziToast.success({title: '', message: response.message, position: 'bottomRight'});
                                } else if (response.error === true) {
                                    // Displays error message
                                    iziToast.error({title: '', message: response.message, position: 'bottomRight'});
                                }
                            }
                        },
                        error: function (xhr, status, error) {
                            // Displays error message
                            iziToast.error({title: '', message: error, position: 'bottomRight'});
                        }
                    })
                } else {
                    return
                }
            })
        });


        $('.modal').on("hidden.bs.modal", function (e) {
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
            }
        });
    })

</script>