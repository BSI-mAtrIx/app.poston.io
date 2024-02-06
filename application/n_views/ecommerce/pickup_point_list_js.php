<script>
    var base_url = "<?php echo site_url(); ?>";

    $(document).ready(function () {

        $('[data-toggle=\"tooltip\"]').tooltip();

        var drop_menu = '<?php echo $drop_menu;?>';
        setTimeout(function () {
            $("#mytable_filter").append(drop_menu);
        }, 1000);

        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[2, "asc"]],
            pageLength: 10,
            ajax: {
                url: base_url + 'ecommerce/pickup_point_list_data',
                type: 'POST'
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1],
                    visible: false
                },
                {
                    targets: [2, 4, 5],
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 4, 5],
                    sortable: false
                },
                {
                    targets: [5],
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

                        return data;
                    }
                },

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

        $(document).on('click', '#add_new_row', function (event) {
            event.preventDefault();
            $("#add_row_form_modal").modal();
        });

        $(document).on('click', '#save_row', function (event) {
            event.preventDefault();

            var point_name = $("#point_name").val();
            var point_details = $("#point_details").val();

            if (point_name == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Name name is required"); ?>', 'warning');
                return;
            }

            if (point_details == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Details value is required"); ?>', 'warning');
                return;
            }

            $(this).addClass('btn-progress')
            var that = $(this);

            var alldatas = new FormData($("#row_add_form")[0]);

            $.ajax({
                url: base_url + 'ecommerce/ajax_create_new_pickup_point',
                type: 'POST',
                dataType: 'JSON',
                data: alldatas,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(that).removeClass('btn-progress');

                    if (response.status == "1") {
                        iziToast.success({title: '', message: response.message, position: 'bottomRight'});

                    } else {
                        iziToast.error({title: '', message: response.message, position: 'bottomRight'});
                    }
                    $("#add_row_form_modal").modal('hide');

                }
            })

        });

        $(document).on('click', '.edit_row', function (event) {
            event.preventDefault();
            $("#update_row_form_modal").modal();

            var table_id = $(this).attr("table_id");
            var loading = '<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center" style="font-size:40px"></i></div>';
            $("#update_contact_modal_body").html(loading);

            $.ajax({
                url: base_url + 'ecommerce/ajax_get_pickup_point_update_info',
                type: 'POST',
                data: {table_id: table_id},
                success: function (response) {
                    $("#update_row_modal_body").html(response);
                }
            })
        });


        $(document).on('click', '#update_row', function (event) {
            event.preventDefault();

            var point_name = $("#point_name2").val();
            var point_details = $("#point_details2").val();

            if (point_name == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Name name is required"); ?>', 'warning');
                return;
            }

            if (point_details == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Details value is required"); ?>', 'warning');
                return;
            }

            $(this).addClass('btn-progress')
            var that = $(this);

            var alldatas = new FormData($("#row_update_form")[0]);

            $.ajax({
                url: base_url + 'ecommerce/ajax_update_pickup_point',
                type: 'POST',
                dataType: 'JSON',
                data: alldatas,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(that).removeClass('btn-progress');

                    if (response.status == "1") {
                        iziToast.success({title: '', message: response.message, position: 'bottomRight'});

                    } else {
                        iziToast.error({title: '', message: response.message, position: 'bottomRight'});
                    }
                    $("#update_row_form_modal").modal('hide');

                }
            })

        });

        var Doyouwanttodeletethisrecordfromdatabase = "<?php echo $this->lang->line('Do you want to detete this record?'); ?>";
        $(document).on('click', '.delete_row', function (e) {
            e.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: Doyouwanttodeletethisrecordfromdatabase,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var table_id = $(this).attr('table_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            dataType: 'JSON',
                            url: "<?php echo base_url('ecommerce/delete_pickup_point')?>",
                            data: {table_id: table_id},
                            success: function (response) {
                                if (response.status == '1') {
                                    iziToast.success({
                                        title: '',
                                        message: response.message,
                                        position: 'bottomRight',
                                        timeout: 3000
                                    });
                                } else {
                                    iziToast.error({
                                        title: '',
                                        message: response.message,
                                        position: 'bottomRight',
                                        timeout: 3000
                                    });
                                }
                                table.draw(false);
                            }
                        });
                    }
                });
        });


        $("#add_row_form_modal").on('hidden.bs.modal', function () {
            $("#row_add_form").trigger('reset');
            table.draw();
        });

        $("#update_row_form_modal").on('hidden.bs.modal', function () {
            table.draw(false);
        });
    });
</script>