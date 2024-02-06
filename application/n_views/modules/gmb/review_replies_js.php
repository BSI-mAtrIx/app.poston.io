<script>
    $(document).ready(function ($) {

        var base_url = '<?php echo base_url(); ?>';

        // datatable section started
        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: false,
            order: [[1, "desc"]],
            pageLength: 10,
            ajax: {
                "url": base_url + 'gmb/review_reply_data',
                "type": 'POST',
                data: function (d) {
                    d.location_id = $('#location_id').val();
                }
            },
            language: {
                url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
            },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1],
                    visible: false
                },
                {
                    targets: [2, 3],
                    className: 'text-center'
                },
                {
                    targets: [0, 2, 3],
                    sortable: false
                },
                {
                    targets: [2, 3],
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
                        data = data.replaceAll('fas fa-hand-point-right', 'bx bx-news');
                        data = data.replaceAll('fa fa-code', 'bx bx-code');
                        data = data.replaceAll('fa fa-clone', 'bx bx-duplicate');
                        data = data.replaceAll('fas fa-pause', 'bx bx-pause');
                        data = data.replaceAll('fas fa-play', 'bx bx-play');
                        data = data.replaceAll('fa fa-cog', 'bx bx-cog');
                        data = data.replaceAll('fa fa-check-circle', 'bx bx-check-circle');
                        data = data.replaceAll('fas fa-comment', 'bx bx-comment');
                        data = data.replaceAll('swal(', 'swal.fire(');
                        data = data.replaceAll('rounded-circle', 'rounded-circle');
                        data = data.replaceAll('fas fa-check-circle', 'bx bx-check-circle');
                        data = data.replaceAll('fas fa-plug', 'bx bx-plug');
                        data = data.replaceAll('fas fa-times-circle', 'bx bx-time');
                        data = data.replaceAll('fas fa-chart-bar', 'bx bx-chart');
                        data = data.replaceAll('fas fa-cloud-download-alt', 'bx bxs-cloud-download');
                        data = data.replaceAll('padding-10', 'p-10');
                        data = data.replaceAll('padding-left-10', 'pl-10');
                        data = data.replaceAll('h4', 'h5 class="card-title font-medium-1"');
                        data = data.replaceAll('fas fa-heart', 'bx bx-heart');
                        data = data.replaceAll('fas fa-road', 'bx bx-location-plus');
                        data = data.replaceAll('fas fa-city', 'bx bxs-city');
                        data = data.replaceAll('fas fa-globe-americas', 'bx bx-globe');
                        data = data.replaceAll('fas fa-at', 'bx bx-at');
                        data = data.replaceAll('fas fa-mobile-alt', 'bx bx-mobile-alt');
                        data = data.replaceAll('<div class="dropdown-title"><?php echo $this->lang->line('Options'); ?></div>', '<h6 class="dropdown-header"><?php echo $this->lang->line('Options'); ?></h6>');
                        data = data.replaceAll('fas fa-file-signature', 'bx bxs-user-badge');
                        data = data.replaceAll('fas fa-user-circle', 'bx bxs-user');
                        data = data.replaceAll('fas fa-star', 'bx bxs-star');
                        data = data.replaceAll('114px', '225px');
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


        $(document).on('keyup', '#searching1', function (event) {
            event.preventDefault();
            table1.draw();
        });


        // End of reply table

        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: '<?php echo $this->lang->line('Do you really want to delete this review reply settings from the database?'); ?>',
                icon: 'warning',
                buttons: true,
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    var star_rating = $(this).attr('id');
                    $.ajax({
                        context: this,
                        type: 'POST',
                        url: "<?php echo base_url('gmb/delete_star')?>",
                        data: {star_rating},
                        success: function (response) {
                            var res = JSON.parse(response);

                            if (false === res.status) {
                                iziToast.error({
                                    title: '',
                                    message: res.message,
                                    position: 'bottomRight'
                                });
                            } else if (true === res.status) {
                                iziToast.success({
                                    title: '',
                                    message: res.message,
                                    position: 'bottomRight'
                                });
                                table.draw();
                            }
                        }
                    });
                }
            });
        });
    });
</script>