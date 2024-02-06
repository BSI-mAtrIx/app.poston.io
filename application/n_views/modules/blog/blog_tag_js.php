<script type="text/javascript">
    var base_url = "<?php echo site_url(); ?>";

    $(document).ready(function () {
        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[2, "desc"]],
            pageLength: 10,
            ajax: {
                "url": base_url + 'blog/tag_data',
                "type": 'POST'
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
                    targets: [0, 3, 4, 5],
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
                        data = data.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
                        data = data.replaceAll('fas fa-exchange-alt', 'bx bx-repost');
                        data = data.replaceAll('fa fa-sync-alt', 'bx bx-sync');

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

        // Tag Store
        $(document.body).on('submit', 'form[name="tag_store"]', function (e) {
            e.preventDefault();

            $("#save_tag").addClass("btn-progress");
            $('.form-control').removeClass('is-invalid');
            var action = $(this).attr('action');
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: action,
                data: formData,
                dataType: 'JSON',
                success: function (response) {
                    $("#save_tag").removeClass("btn-progress");

                    if (response.status == '0') {
                        $.each(response.errors, function (key, value) {
                            $("." + key).addClass('is-invalid');
                            $('.' + key + '_error').html(value);
                        });
                    }

                    if (response.status == "1") {
                        swal.fire('<?php echo $this->lang->line("Success")?>', response.message, 'success')
                            .then((value) => {
                                $("#add_tag_modal").modal('hide');
                            });
                        table.draw();
                    }

                    if (response.status == "2") {
                        swal.fire('<?php echo $this->lang->line("Error")?>', response.message, 'error');
                    }
                }
            });
        });

        // Tag Update Part
        $(document.body).on('click', '.edit_tag', function (e) {
            e.preventDefault();
            var tag_id = $(this).attr('data-id');
            var tag_name = $(this).attr('data-name');

            $("#tag_name").val(tag_name);
            $("input[name='tag_id']").val(tag_id);
            $("#update_tag_modal").modal();
        });

        $(document.body).on('submit', 'form[name="tag_update"]', function (e) {
            e.preventDefault();

            $("#update_tag").addClass("btn-progress");
            $('.form-control').removeClass('is-invalid');
            var action = $(this).attr('action');
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: action,
                data: formData,
                dataType: 'JSON',
                success: function (response) {
                    $("#update_tag").removeClass("btn-progress");

                    if (response.status == '0') {
                        $.each(response.errors, function (key, value) {
                            $("." + key).addClass('is-invalid');
                            $('.' + key + '_error').html(value);
                        });
                    }

                    if (response.status == "1") {
                        swal.fire('<?php echo $this->lang->line("Success")?>', response.message, 'success')
                            .then((value) => {
                                $("#update_tag_modal").modal('hide');
                            });
                        table.draw();
                    }

                    if (response.status == "2") {
                        swal.fire('<?php echo $this->lang->line("Error")?>', response.message, 'error');
                    }
                }
            });
        });

        // Tag Delete
        $(document.body).on('click', '.delete_tag', function (e) {
            e.preventDefault();
            var tag_id = $(this).attr('data-id');
            swal.fire({
                title: "<?php echo $this->lang->line("Are you sure?");?>",
                text: '<?php echo $this->lang->line("Do you really want to delete it?");?>',
                icon: "warning",
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $(this).addClass('btn-progress btn-danger').removeClass('btn-outline-danger');
                        $.ajax({
                            type: 'POST',
                            url: base_url + 'blog/tag_delete',
                            data: {tag_id: tag_id},
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == "1") {
                                    swal.fire('<?php echo $this->lang->line("Success")?>', response.message, 'success');
                                    table.draw();
                                }

                                if (response.status == "0") {
                                    swal.fire('<?php echo $this->lang->line("Error")?>', response.message, 'error');
                                }
                            }
                        });
                    }
                });
        });
    });
</script>