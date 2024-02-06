<script type="text/javascript">
    var base_url = "<?php echo site_url(); ?>";
    var perscroll;
    var table = $("#mytable").DataTable({
        serverSide: true,
        processing: true,
        bFilter: true,
        order: [[2, "desc"]],
        pageLength: 10,
        ajax: {
            "url": base_url + 'blog/post_data',
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
                targets: [8],
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
</script>

<script type="text/javascript">
    $(document).ready(function () {
        var drop_menu = '<?php echo $drop_menu;?>';
        setTimeout(function () {
            $("#mytable_filter").append(drop_menu);
        }, 1000);
        // Post Delete
        $(document.body).on('click', '.delete_post', function (e) {
            e.preventDefault();
            var post_id = $(this).attr('data-id');
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
                            url: base_url + 'blog/delete_post',
                            data: {post_id: post_id},
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