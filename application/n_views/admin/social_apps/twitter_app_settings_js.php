<script>
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
                url: base_url + 'social_apps/twitter_settings_data',
                type: 'POST'
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1, 2],
                    visible: false
                },
                {
                    targets: '',
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 5, 6, 7],
                    sortable: false
                },
                {
                    targets: [7],
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


        $(document).on('click', '.delete_app', function (e) {
            e.preventDefault();
            var ifyoudeletethisaccount = "<?php echo $this->lang->line('If you delete this APP then, all the imported Twitter accounts and Campaigns will be deleted too corresponding to this APP.'); ?>";
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: ifyoudeletethisaccount,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var app_table_id = $(this).attr('table_id');
                        var csrf_token = $(this).attr('csrf_token');
                        $(this).removeClass('btn-outline-danger');
                        $(this).addClass('btn-danger');
                        $(this).addClass('btn-progress');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>social_apps/delete_app_twitter",
                            dataType: 'json',
                            data: {app_table_id: app_table_id, csrf_token: csrf_token},
                            success: function (response) {

                                $(this).removeClass('btn-progress');
                                $(this).removeClass('btn-danger');
                                $(this).addClass('btn-outline-danger');

                                if (response.status == 1) {
                                    swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
                                        location.reload();
                                    });
                                } else {
                                    swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                }
                            }
                        });
                    }
                });
        });

        $(document).on('click', '.change_state', function (e) {
            e.preventDefault();
            var ifyoudeletethisaccount = "<?php echo $this->lang->line('If you change this APP status to inactive then, all the imported Twitter accounts and Campaigns will not work corresponding to this APP.'); ?>";
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: ifyoudeletethisaccount,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var app_table_id = $(this).attr('table_id');
                        $(this).removeClass('btn-outline-danger');
                        $(this).addClass('btn-danger');
                        $(this).addClass('btn-progress');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>social_apps/change_app_status_twitter",
                            dataType: 'json',
                            data: {app_table_id: app_table_id},
                            success: function (response) {

                                $(this).removeClass('btn-progress');
                                $(this).removeClass('btn-danger');
                                $(this).addClass('btn-outline-danger');

                                if (response.status == 1) {
                                    swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
                                        location.reload();
                                    });
                                } else {
                                    swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                }
                            }
                        });
                    }
                });
        });


    });
</script>