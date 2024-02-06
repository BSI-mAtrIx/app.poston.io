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
    var base_url = "<?php echo site_url(); ?>";

    $(document).ready(function () {

        var areWeUsingScroll = false;
        //TODO: areWeUsingScroll
        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: false,
            order: [[2, "asc"]],
            pageLength: 10,
            ajax: {
                "url": base_url + 'subscriber_manager/contact_group_data',
                "type": 'POST',
                data: function (d) {
                    d.page_id = $('#page_id').val();
                    d.searching = $('#searching').val();
                }
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1, 3],
                    visible: false
                },
                {
                    targets: [3, 5, 6],
                    className: 'text-center'
                },
                {
                    targets: [0, 5],
                    sortable: false
                },
                {
                    targets: [5],
                    "render": function (data, type, row) {
                        data = data.replaceAll('fas fa-code', 'bx bx-code');
                        data = data.replaceAll('fas fa-edit', 'bx bx-edit');
                        data = data.replaceAll('fa fa-edit', 'bx bx-edit');
                        data = data.replaceAll('far fa-copy', 'bx bx-copy');
                        data = data.replaceAll('fa fa-trash', 'bx bx-trash');
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

                        return data;
                    },
                }
            ],
            fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                if (areWeUsingScroll) {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                }
            },
            scrollX: 'auto',
            fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                if (areWeUsingScroll) {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                }
            }
        });

        $(document).on('change', '#page_id', function (event) {
            event.preventDefault();
            table.draw();
        });

        $(document).on('click', '#search_submit', function (event) {
            event.preventDefault();
            table.draw();
        });
        // end of datatable

        $(document).on('click', '.add_label', function (event) {
            event.preventDefault();
            $("#name_err").text("");
            $("#page_err").text("");
            $("#group_name").val("");
            $("#selected_page_id").val("").change();
            $("#add_label").modal();
        });

        // create new label
        $(document).on('click', '#create_label', function (event) {
            event.preventDefault();

            $("#name_err").text("");
            $("#page_err").text("");

            group_name = $("#group_name").val();
            selected_page_id = $("#selected_page_id").val();

            if (group_name == '') {
                $("#name_err").text("<?php echo $this->lang->line('Name is Required') ?>")
                return false;
            }
            if (selected_page_id == '') {
                $("#page_err").text("<?php echo $this->lang->line('Page is Required') ?>")
                return false;
            }

            $(this).addClass('btn-progress');
            var that = $(this);

            $.ajax({
                url: '<?php echo base_url('subscriber_manager/ajax_label_insert'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {group_name: group_name, selected_page_id: selected_page_id},
                success: function (response) {
                    $("#result_status").html('');
                    $("#result_status").css({"background": "", "padding": "", "margin": ""});

                    if (response.status == "0") {
                        var errorMessage = JSON.stringify(response, null, 10);
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', errorMessage, "error");
                        // iziToast.error({title: '',message: response.message,position: 'bottomRight'});
                        $("#result_status").css({"background": "#EEE", "margin": "10px"});

                    } else if (response.status == '1') {
                        iziToast.success({title: '', message: response.message, position: 'bottomRight'});
                    }

                    table.draw();
                    $(that).removeClass('btn-progress');
                }
            });

        });

        $(document).on('keyup', '#group_name', function (event) {
            event.preventDefault();
            $("#name_err").text("");
        });

        $(document).on('change', '#selected_page_id', function (event) {
            event.preventDefault();
            $("#page_err").text("");
        });


        // delete label
        $(document).on('click', '.delete_label', function (event) {
            event.preventDefault();

            swal.fire({
                title: '<?php echo $this->lang->line("Delete Label"); ?>',
                text: '<?php echo $this->lang->line("Do you want to delete this label?"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var table_id = $(this).attr("table_id");
                        var social_media = $(this).attr("social_media");

                        $(this).addClass('btn-danger btn-progress').removeClass('btn-outline-danger');
                        var that = $(this);

                        $.ajax({
                            url: '<?php echo base_url('subscriber_manager/ajax_delete_label'); ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: {table_id: table_id, social_media: social_media},
                            success: function (response) {
                                if (response.status == 'successfull') {
                                    iziToast.success({title: '', message: response.message, position: 'bottomRight'});

                                } else if (response.status == 'failed') {
                                    swal.fire("<?php echo $this->lang->line('Error') ?>", response.message, "error")

                                } else if (response.status == 'error') {
                                    var errorMessage = JSON.stringify(response, null, 10);
                                    swal.fire('<?php echo $this->lang->line("Error"); ?>', errorMessage, "error");
                                } else if (response.status == 'wrong') {
                                    swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, "error");
                                }

                                table.draw();
                                $(that).removeClass('btn-danger btn-progress').addClass('btn-outline-danger');
                            }
                        });
                    }
                });

        });

        $('#add_label').on('hidden.bs.modal', function () {
            $("#name_err").text("");
            $("#page_err").text("");
            $("#group_name").val("");
            $("#selected_page_id").val("").change();
            table.draw();
        })

    });


</script>